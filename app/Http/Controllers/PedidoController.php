<?php
namespace App\Http\Controllers;
use App\Models\{Producto,Pedido};
use App\Services\PedidoService;
use Illuminate\Http\Request;
class PedidoController extends Controller {
    public function catalogo() { return view('home',['productos'=>Producto::whereIn('estado_producto',['Activo','Temporada'])->get()->toArray()]); }
    public function index(Request $request) {
        $gestion = $request->user()->rol !== 'usuario';
        $query = Pedido::with(['cliente','detalles'])->latest('fecha_pedido');
        if (!$gestion) $query->where('id_usuario',$request->user()->id);
        $pedidos = $query->get()->flatMap(fn($p)=>$p->detalles->map(fn($d)=>array_merge($p->toArray(),$d->toArray(),['cliente'=>$p->cliente->nombre])))->all();
        return view('pedidos',compact('gestion','pedidos'));
    }
    public function store(Request $request, PedidoService $service) {
        $data=$request->validate(['id_producto'=>'required|integer|exists:productos,id_producto','cantidad'=>'required|integer|min:1|max:50','fecha_entrega'=>'nullable|date_format:Y-m-d|after_or_equal:today','indicaciones'=>'nullable|string|max:500']);
        $pedido=$service->crear($request->user()->id,$data);
        return to_route('misPedidos')->with('success','Pedido #'.$pedido->id_pedido.' recibido. Pendiente de aprobación, sin descontar inventario.');
    }
    public function accion(Request $request, PedidoService $service) {
        $data=$request->validate(['id_pedido'=>'required|integer|exists:pedidos,id_pedido','accion'=>'required|in:aceptar,rechazar,preparar,listo,entregar']);
        $service->accion($data['id_pedido'],$data['accion'],$request->user()->id);
        return back()->with('success','Pedido actualizado correctamente.');
    }
}
