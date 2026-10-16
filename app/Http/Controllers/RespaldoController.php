<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB,Crypt,Auth};
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Validation\ValidationException;
class RespaldoController extends Controller {
    private const TABLES=['usuarios','productos','inventario','recetas','pedidos','pedido_detalles','movimientos_inventario'];
    public function exportar(Request $request) {
        $request->validate(['current_password'=>'required|current_password']);
        $data=DB::transaction(function () {
            $data=[];foreach(self::TABLES as $table) $data[$table]=DB::table($table)->get()->toArray();return $data;
        });
        $payload=Crypt::encryptString(json_encode(['format'=>'the-rock-laravel-v1','tables'=>$data], JSON_THROW_ON_ERROR));
        return response()->streamDownload(fn()=>print($payload),'the-rock-'.now()->format('Y-m-d-His').'.rock',['Content-Type'=>'application/octet-stream']);
    }
    public function restaurar(Request $request) {
        $request->validate(['current_password'=>'required|current_password','confirmar'=>'accepted','respaldo'=>'required|file|max:20480']);
        try { $data=json_decode(Crypt::decryptString(file_get_contents($request->file('respaldo')->getRealPath())),true,512,JSON_THROW_ON_ERROR); }
        catch (DecryptException|\JsonException $e) { throw ValidationException::withMessages(['respaldo'=>'Respaldo inválido o generado con otra APP_KEY.']); }
        if (($data['format'] ?? '') !== 'the-rock-laravel-v1' || array_keys($data['tables'] ?? []) !== self::TABLES) throw ValidationException::withMessages(['respaldo'=>'Formato de respaldo incompatible.']);
        DB::transaction(function () use ($data) {
            foreach(array_reverse(self::TABLES) as $table) DB::table($table)->delete();
            foreach(self::TABLES as $table) foreach(array_chunk($data['tables'][$table],100) as $chunk) DB::table($table)->insert($chunk);
        });
        Auth::logout();$request->session()->invalidate();$request->session()->regenerateToken();
        return to_route('login')->with('success','Datos restaurados. Inicia sesión con una cuenta del respaldo.');
    }
}
