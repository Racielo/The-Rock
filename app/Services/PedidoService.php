<?php
namespace App\Services;
use App\Models\{Producto,Pedido,Insumo,MovimientoInventario};
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
class PedidoService {
    private function fail(string $message): never { throw ValidationException::withMessages(['pedido'=>$message]); }
    public function crear(int $usuario, array $data): Pedido {
        return DB::transaction(function () use ($usuario,$data) {
            $producto = Producto::whereIn('estado_producto',['Activo','Temporada'])->findOrFail($data['id_producto']);
            $pedido = Pedido::create(['id_usuario'=>$usuario,'fecha_pedido'=>now(),'fecha_entrega'=>$data['fecha_entrega'] ?? null,
                'indicaciones'=>$data['indicaciones'] ?? null,'estado'=>'Pendiente',
                'total'=>round((float)$producto->precio_venta * 100) * $data['cantidad'] / 100]);
            $pedido->detalles()->create(['id_producto'=>$producto->id_producto,'nombre_producto'=>$producto->nombre_producto,
                'cantidad'=>$data['cantidad'],'precio_unitario'=>$producto->precio_venta]);
            return $pedido;
        });
    }
    public function accion(int $id, string $accion, int $empleado): void {
        DB::transaction(function () use ($id,$accion,$empleado) {
            $pedido = Pedido::lockForUpdate()->findOrFail($id);
            if ($accion !== 'aceptar') {
                $map = ['rechazar'=>['Pendiente','Rechazado'],'preparar'=>['Aceptado','En preparación'],
                    'listo'=>['En preparación','Listo'],'entregar'=>['Listo','Entregado']];
                if (!isset($map[$accion]) || $pedido->estado !== $map[$accion][0]) $this->fail('Transición no válida. Actualiza la página.');
                $pedido->update(['estado'=>$map[$accion][1]]); return;
            }
            if ($pedido->estado !== 'Pendiente') $this->fail('Solo se aceptan pedidos pendientes.');
            $requeridos = [];
            foreach ($pedido->detalles as $detalle) {
                $ingredientes = $detalle->producto->ingredientes;
                if ($ingredientes->isEmpty()) $this->fail('Configura la receta antes de aceptar el pedido.');
                foreach ($ingredientes as $insumo) {
                    // Enteros en milésimas para evitar errores de punto flotante.
                    $requeridos[$insumo->id_insumo] = ($requeridos[$insumo->id_insumo] ?? 0) + (int)round($insumo->pivot->cantidad * 1000) * $detalle->cantidad;
                }
            }
            if (!$requeridos) $this->fail('El pedido no tiene ingredientes.');
            ksort($requeridos, SORT_NUMERIC);
            foreach ($requeridos as $idInsumo=>$milesimas) {
                $insumo = Insumo::lockForUpdate()->findOrFail($idInsumo);
                if (!in_array($insumo->estado,['Disponible','Por caducar']) || ($insumo->fecha_caducidad && $insumo->fecha_caducidad < today()->toDateString())) $this->fail($insumo->nombre.': no disponible o caducado.');
                $resto = (int)round($insumo->cantidad_actual * 1000) - $milesimas;
                if ($resto < 0) $this->fail('No alcanza '.$insumo->nombre.'. Requerido: '.($milesimas/1000).' '.$insumo->unidad_medida);
                $insumo->update(['cantidad_actual'=>$resto/1000,'estado'=>$resto === 0 ? 'Agotado' : $insumo->estado]);
                MovimientoInventario::create(['id_pedido'=>$id,'id_insumo'=>$idInsumo,'cantidad_descontada'=>$milesimas/1000,'fecha'=>now()]);
            }
            $pedido->update(['estado'=>'Aceptado','fecha_aceptacion'=>now(),'atendido_por'=>$empleado]);
        }, 3);
    }
}
