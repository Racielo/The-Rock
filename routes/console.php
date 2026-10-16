<?php
use Illuminate\Support\Facades\{Artisan,Hash,Validator};
use App\Models\Usuario;
Artisan::command('rock:admin', function () {
    $nombre=$this->ask('Nombre del administrador');$correo=$this->ask('Correo');$pass=$this->secret('Contraseña (mínimo 8 caracteres)');
    $data=compact('nombre','correo','pass');$validator=Validator::make($data,['nombre'=>'required|string|max:150','correo'=>'required|email|max:190|unique:usuarios,correo','pass'=>'required|string|min:8']);
    if ($validator->fails()) { foreach ($validator->errors()->all() as $error) $this->error($error); return 1; }
    Usuario::create(['nombre'=>$nombre,'correo'=>$correo,'pass'=>Hash::make($pass),'rol'=>'admin','estado'=>'Activo']);$this->info('Administrador creado.');
})->purpose('Crear un administrador sin contraseñas predeterminadas');
Artisan::command('rock:password {correo}', function () {
    $user=Usuario::where('correo',$this->argument('correo'))->first();if (!$user) {$this->error('Cuenta no encontrada.');return 1;}
    $pass=$this->secret('Nueva contraseña');if (strlen($pass ?? '')<8) {$this->error('Mínimo 8 caracteres.');return 1;}
    $user->update(['pass'=>Hash::make($pass)]);$this->info('Contraseña actualizada.');
})->purpose('Restablecer contraseña desde la terminal local');
