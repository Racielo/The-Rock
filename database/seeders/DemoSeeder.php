<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\{Producto,Insumo};
class DemoSeeder extends Seeder {
    public function run(): void {
        if (Producto::exists() || Insumo::exists()) throw new \RuntimeException('DemoSeeder requiere catálogo e inventario vacíos.');
        DB::transaction(function () {
            $harina=Insumo::create(['nombre'=>'Harina','cantidad_actual'=>10,'unidad_medida'=>'kg','stock_minimo'=>2,'fecha_ingreso'=>today(),'estado'=>'Disponible']);
            $azucar=Insumo::create(['nombre'=>'Azúcar','cantidad_actual'=>8,'unidad_medida'=>'kg','stock_minimo'=>1,'fecha_ingreso'=>today(),'estado'=>'Disponible']);
            $p=Producto::create(['nombre_producto'=>'Pastel de chocolate','descripcion'=>'Bizcocho suave con cobertura de chocolate. Producto de demostración.','elaboracion'=>'Preparación artesanal. Receta simplificada únicamente para probar el sistema.','imagen'=>'assets/img/pastel-de-chocolate.png','precio_venta'=>350,'categoria'=>'Pasteles','dias_vida_util'=>3,'estado_producto'=>'Activo']);
            $p->ingredientes()->attach([$harina->id_insumo=>['cantidad'=>0.350],$azucar->id_insumo=>['cantidad'=>0.200]]);
        });
    }
}
