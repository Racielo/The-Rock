<?php
namespace App\Http\Controllers;
use App\Models\{Producto,Insumo};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB,Storage};
use Illuminate\Validation\ValidationException;
class ProductoController extends Controller {
    public function index(Request $request) {
        $productos=Producto::withCount('ingredientes as numero_ingredientes')->get()->toArray();
        $ingredientes=Insumo::all()->toArray();
        $producto=$request->integer('editar') ? Producto::findOrFail($request->integer('editar')) : null;
        $receta=$producto ? $producto->ingredientes->pluck('pivot.cantidad','id_insumo')->all() : [];
        return view('productos',compact('productos','ingredientes','producto','receta'));
    }
    public function guardar(Request $request, ?int $id=null) {
        $data=$request->validate(['nombre_producto'=>'required|string|max:255','descripcion'=>'required|string|max:10000','elaboracion'=>'nullable|string|max:10000','precio_venta'=>'required|numeric|min:0|max:99999999.99','categoria'=>'required|string|max:90','dias_vida_util'=>'required|integer|min:0|max:3650','estado_producto'=>'required|in:Activo,Inactivo,Temporada','imagen'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:5120','ingredientes'=>'nullable|array','ingredientes.*'=>'nullable|numeric|min:0|max:999999999|decimal:0,3']);
        $producto=$id ? Producto::findOrFail($id) : new Producto();
        $receta=[];
        foreach ($data['ingredientes'] ?? [] as $insumo=>$cantidad) {
            if ($cantidad > 0) {
                if (!ctype_digit((string)$insumo) || !Insumo::whereKey($insumo)->exists()) throw ValidationException::withMessages(['ingredientes'=>'Ingrediente no válido.']);
                $receta[$insumo]=['cantidad'=>$cantidad];
            }
        }
        unset($data['ingredientes'],$data['imagen']); $path=null;
        try {
            if ($request->hasFile('imagen')) { $path=$request->file('imagen')->store('productos','public'); $data['imagen']=Storage::disk('public')->url($path); }
            DB::transaction(function () use ($producto,$data,$receta) { $producto->fill($data)->save();$producto->ingredientes()->sync($receta); });
        } catch (\Throwable $e) { if ($path) Storage::disk('public')->delete($path); throw $e; }
        return to_route('productos')->with('success','Producto y receta guardados.');
    }
    public function ocultar(Request $request) {
        $data=$request->validate(['id'=>'required|integer']);Producto::findOrFail($data['id'])->update(['estado_producto'=>'Inactivo']);return back()->with('success','Producto ocultado.');
    }
}
