<?php
namespace App\Http\Controllers;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth,Hash};
use Illuminate\Validation\{Rule,ValidationException};
class AuthController extends Controller {
    public function login(Request $request) {
        $data=$request->validate(['correo'=>'required|email','password'=>'required|string']);
        if (!Auth::attempt(['correo'=>$data['correo'],'password'=>$data['password'],'estado'=>'Activo'])) throw ValidationException::withMessages(['correo'=>'Correo o contraseña incorrectos, o cuenta inactiva.']);
        $request->session()->regenerate(); return redirect()->intended(route('home'));
    }
    public function registro(Request $request) {
        $data=$request->validate(['nombre'=>'required|string|max:150','correo'=>'required|email|max:190|unique:usuarios,correo','password'=>'required|string|min:8|confirmed']);
        Usuario::create(['nombre'=>$data['nombre'],'correo'=>$data['correo'],'pass'=>Hash::make($data['password']),'rol'=>'usuario','estado'=>'Activo']);
        return to_route('login')->with('success','Cuenta creada. Ya puedes iniciar sesión.');
    }
    public function logout(Request $request) {
        Auth::logout();$request->session()->invalidate();$request->session()->regenerateToken();return to_route('home');
    }
    public function perfil(Request $request) {
        $data=$request->validate(['nombre'=>'required|string|max:150','correo'=>['required','email','max:190',Rule::unique('usuarios','correo')->ignore($request->user()->id)],'password'=>'nullable|string|min:8|confirmed','current_password'=>'required|current_password']);
        $user=$request->user();$user->nombre=$data['nombre'];$user->correo=$data['correo'];
        if (!empty($data['password'])) $user->pass=Hash::make($data['password']);
        $user->save();return back()->with('success','Perfil actualizado.');
    }
}
