<?php
namespace App\Http\Controllers;
use App\Models\Insumo;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
class InventarioController extends Controller {
    public function index() { return view('inventario',['inventario'=>Insumo::all()->toArray()]); }
    public function guardar(Request $request, ?int $id=null) {
        $data=$request->validate(['nombre'=>'required|string|max:200','cantidad_actual'=>'required|numeric|min:0|max:999999999|decimal:0,3','unidad_medida'=>'required|in:g,kg,ml,litros,piezas','stock_minimo'=>'required|numeric|min:0|max:999999999|decimal:0,3','fecha_ingreso'=>'required|date_format:Y-m-d','fecha_caducidad'=>'nullable|date_format:Y-m-d|after_or_equal:fecha_ingreso','estado'=>'sometimes|in:Disponible,Por caducar,Agotado,Inactivo']);
        $insumo=$id ? Insumo::findOrFail($id) : new Insumo();
        if ($id && $insumo->unidad_medida !== $data['unidad_medida'] && $insumo->productos()->exists()) return back()->withErrors(['unidad_medida'=>'No cambies la unidad de un insumo utilizado en recetas. Crea un insumo nuevo.']);
        $insumo->fill($data)->save();return to_route('inventario')->with('success','Materia prima guardada.');
    }
    public function eliminar(Request $request) {
        $data=$request->validate(['id'=>'required|integer']);
        try { Insumo::findOrFail($data['id'])->delete(); }
        catch (QueryException $e) { if (str_starts_with((string)$e->getCode(),'23')) return back()->withErrors(['inventario'=>'Este insumo se utiliza en recetas o pedidos. Márcalo Inactivo.']);throw $e; }
        return back()->with('success','Insumo eliminado.');
    }
}
