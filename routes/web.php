<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController,ProductoController,InventarioController,UsuarioController,PedidoController,RespaldoController};
Route::get('/',[PedidoController::class,'catalogo'])->name('home');
Route::middleware('guest')->group(function () {
    Route::view('/login','login')->name('login');
    Route::post('/login',[AuthController::class,'login'])->middleware('throttle:6,1')->name('verificar');
    Route::view('/registro','registro')->name('registro');
    Route::post('/registro',[AuthController::class,'registro'])->middleware('throttle:6,1')->name('registrar');
});
Route::view('/recuperar','recuperar')->name('recuperar');
Route::middleware(['auth','rol:admin,empleado,usuario'])->group(function () {
    Route::post('/logout',[AuthController::class,'logout'])->name('logout');
    Route::view('/perfil','configuracion')->name('configuracion');
    Route::post('/perfil',[AuthController::class,'perfil'])->name('guardar-perfil');
});
Route::middleware(['auth','rol:usuario'])->group(function () {
    Route::get('/mis-pedidos',[PedidoController::class,'index'])->name('misPedidos');
    Route::post('/pedidos',[PedidoController::class,'store'])->name('realizarPedido');
});
Route::middleware(['auth','rol:admin,empleado'])->group(function () {
    Route::get('/gestion/pedidos',[PedidoController::class,'index'])->name('pedidosAdmin');
    Route::post('/gestion/pedidos/estado',[PedidoController::class,'accion'])->name('accionPedido');
    Route::get('/inventario',[InventarioController::class,'index'])->name('inventario');
});
Route::middleware(['auth','rol:admin'])->group(function () {
    Route::get('/productos',[ProductoController::class,'index'])->name('productos');
    Route::post('/productos',[ProductoController::class,'guardar'])->name('crearProducto');
    Route::post('/productos/ocultar',[ProductoController::class,'ocultar'])->name('borrarProducto');
    Route::post('/productos/{id}',[ProductoController::class,'guardar'])->whereNumber('id')->name('editarProducto');
    Route::post('/inventario',[InventarioController::class,'guardar'])->name('crearInventario');
    Route::post('/inventario/eliminar',[InventarioController::class,'eliminar'])->name('borrarInventario');
    Route::post('/inventario/{id}',[InventarioController::class,'guardar'])->whereNumber('id')->name('editarInventario');
    Route::get('/usuarios',[UsuarioController::class,'index'])->name('usuarios');
    Route::post('/usuarios',[UsuarioController::class,'guardar'])->name('crear');
    Route::post('/usuarios/desactivar',[UsuarioController::class,'desactivar'])->name('borrar');
    Route::post('/usuarios/{id}',[UsuarioController::class,'guardar'])->whereNumber('id')->name('editar');
    Route::view('/respaldos','respaldos')->name('restaurar');
    Route::post('/respaldos/exportar',[RespaldoController::class,'exportar'])->name('exportar-bd');
    Route::post('/respaldos/restaurar',[RespaldoController::class,'restaurar'])->name('restaurar-bd');
});
