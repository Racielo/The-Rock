<?php
namespace App\Http\Controllers;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
class UsuarioController extends Controller {
    public function index() { return view('usuarios',['usuarios'=>Usuario::where('rol','!=','admin')->get()->toArray()]); }
    public function guardar(Request $request, ?int $id=null) {
        $usuario=$id ? Usuario::where('rol','!=','admin')->findOrFail($id) : new Usuario();
        $data=$request->validate(['nombre'=>'required|string|max:150','correo'=>['required','email','max:190',Rule::unique('usuarios','correo')->ignore($id)],'pass'=>($id ? 'nullable' : 'required').'|string|min:8','rol'=>'required|in:usuario,empleado','estado'=>'sometimes|in:Activo,Inactivo']);
        if (!empty($data['pass'])) $data['pass']=Hash::make($data['pass']); else unset($data['pass']);
        $usuario->fill($data)->save();return to_route('usuarios')->with('success','Cuenta guardada.');
    }
    public function desactivar(Request $request) {
        $data=$request->validate(['id'=>'required|integer']);Usuario::where('rol','!=','admin')->findOrFail($data['id'])->update(['estado'=>'Inactivo']);return back()->with('success','Cuenta desactivada.');
    }
}
