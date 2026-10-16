<?php
namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\{Hash,Storage,DB};
use Illuminate\Http\UploadedFile;
use App\Models\{Usuario,Producto,Insumo,Pedido,MovimientoInventario};
use App\Services\PedidoService;
class PasteleriaTest extends TestCase {
    use RefreshDatabase;
    private function user(string $rol='usuario'): Usuario {
        return Usuario::create(['nombre'=>'Prueba','correo'=>uniqid().'@example.test','pass'=>Hash::make('ClavePrueba123'),'rol'=>$rol,'estado'=>'Activo']);
    }
    private function producto(): Producto {
        $p=Producto::create(['nombre_producto'=>'Pastel de prueba','descripcion'=>'Chocolate','precio_venta'=>250,'categoria'=>'Pasteles','dias_vida_util'=>3,'estado_producto'=>'Activo']);
        $i=Insumo::create(['nombre'=>'Harina','cantidad_actual'=>10,'unidad_medida'=>'kg','stock_minimo'=>1,'fecha_ingreso'=>today(),'estado'=>'Disponible']);
        $p->ingredientes()->attach($i->id_insumo,['cantidad'=>0.125]);return $p;
    }
    private function pedido(Usuario $cliente,Producto $p): Pedido {
        return app(PedidoService::class)->crear($cliente->id,['id_producto'=>$p->id_producto,'cantidad'=>2]);
    }
    public function test_pages_render_for_each_role(): void {
        $this->get('/')->assertOk();$this->get('/login')->assertOk();$this->get('/registro')->assertOk();$this->get('/recuperar')->assertOk();
        $p=$this->producto();$cliente=$this->user();$this->pedido($cliente,$p);
        $this->actingAs($cliente)->get('/')->assertOk()->assertSee('Pedir ahora');
        $this->get('/mis-pedidos')->assertOk()->assertSee('Pastel de prueba');$this->get('/perfil')->assertOk();
        $this->actingAs($this->user('admin'));
        foreach(['/productos','/productos?editar='.$p->id_producto,'/inventario','/inventario?editar=1','/usuarios','/usuarios?editar='.$cliente->id,'/gestion/pedidos','/respaldos'] as $url) $this->get($url)->assertOk();
        $this->actingAs($this->user('empleado'))->get('/inventario')->assertOk()->assertSee('Solo lectura');
    }
    public function test_register_cannot_grant_admin_and_login_works(): void {
        $this->post('/registro',['nombre'=>'Cliente','correo'=>'cliente@example.test','password'=>'ClavePrueba123','password_confirmation'=>'ClavePrueba123','rol'=>'admin'])->assertRedirect('/login');
        $u=Usuario::first();$this->assertSame('usuario',$u->rol);$this->assertTrue(Hash::check('ClavePrueba123',$u->pass));
        $this->post('/login',['correo'=>$u->correo,'password'=>'ClavePrueba123'])->assertRedirect('/');$this->assertAuthenticatedAs($u);
        $this->post('/logout')->assertRedirect('/');$this->assertGuest();
    }
    public function test_inactive_user_cannot_log_in(): void {
        $u=$this->user();$u->update(['estado'=>'Inactivo']);
        $this->post('/login',['correo'=>$u->correo,'password'=>'ClavePrueba123'])->assertSessionHasErrors('correo');$this->assertGuest();
    }
    public function test_role_permissions_enforced_on_server(): void {
        $this->get('/productos')->assertRedirect('/login');$this->actingAs($this->user())->get('/productos')->assertForbidden();
        $this->post('/gestion/pedidos/estado',[])->assertForbidden();
        $this->actingAs($this->user('empleado'))->post('/inventario',[])->assertForbidden();
        $this->get('/usuarios')->assertForbidden();
    }
    public function test_orders_only_show_owner(): void {
        $p=$this->producto();$owner=$this->user();$this->pedido($owner,$p);
        $this->actingAs($this->user())->get('/mis-pedidos')->assertOk()->assertDontSee('Pastel de prueba');
    }
    public function test_create_does_not_deduct_and_accept_deducts_once(): void {
        $p=$this->producto();$cliente=$this->user();$admin=$this->user('admin');
        $this->actingAs($cliente)->post('/pedidos',['id_producto'=>$p->id_producto,'cantidad'=>2,'total'=>1])->assertRedirect('/mis-pedidos');
        $pedido=Pedido::first();$this->assertEquals(500,$pedido->total);$this->assertEquals(10,Insumo::first()->cantidad_actual);
        $this->actingAs($admin)->post('/gestion/pedidos/estado',['id_pedido'=>$pedido->id_pedido,'accion'=>'aceptar'])->assertSessionHasNoErrors();
        $this->assertEquals(9.75,Insumo::first()->cantidad_actual);$this->assertSame(1,MovimientoInventario::count());
        $this->post('/gestion/pedidos/estado',['id_pedido'=>$pedido->id_pedido,'accion'=>'aceptar'])->assertSessionHasErrors('pedido');
        $this->assertEquals(9.75,Insumo::first()->cantidad_actual);$this->assertSame(1,MovimientoInventario::count());
    }
    public function test_insufficient_stock_rolls_back_all_ingredients(): void {
        $p=$this->producto();$other=Insumo::create(['nombre'=>'Crema','cantidad_actual'=>0.1,'unidad_medida'=>'litros','stock_minimo'=>1,'fecha_ingreso'=>today(),'estado'=>'Disponible']);
        $p->ingredientes()->attach($other->id_insumo,['cantidad'=>1]);$pedido=$this->pedido($this->user(),$p);
        $this->actingAs($this->user('admin'))->post('/gestion/pedidos/estado',['id_pedido'=>$pedido->id_pedido,'accion'=>'aceptar'])->assertSessionHasErrors('pedido');
        $this->assertEquals(10,Insumo::first()->cantidad_actual);$this->assertSame(0,MovimientoInventario::count());$this->assertSame('Pendiente',$pedido->fresh()->estado);
    }
    public function test_expired_and_missing_recipe_cannot_be_accepted(): void {
        $p=$this->producto();$pedido=$this->pedido($this->user(),$p);$this->actingAs($this->user('empleado'));
        Insumo::first()->update(['fecha_caducidad'=>today()->subDay()]);
        $this->post('/gestion/pedidos/estado',['id_pedido'=>$pedido->id_pedido,'accion'=>'aceptar'])->assertSessionHasErrors('pedido');
        $p->ingredientes()->detach();
        $this->post('/gestion/pedidos/estado',['id_pedido'=>$pedido->id_pedido,'accion'=>'aceptar'])->assertSessionHasErrors('pedido');$this->assertSame(0,MovimientoInventario::count());
    }
    public function test_order_state_sequence_and_rejection(): void {
        $p=$this->producto();$pedido=$this->pedido($this->user(),$p);$this->actingAs($this->user('empleado'));
        $this->post('/gestion/pedidos/estado',['id_pedido'=>$pedido->id_pedido,'accion'=>'entregar'])->assertSessionHasErrors('pedido');
        foreach(['aceptar'=>'Aceptado','preparar'=>'En preparación','listo'=>'Listo','entregar'=>'Entregado'] as $accion=>$estado) {
            $this->post('/gestion/pedidos/estado',['id_pedido'=>$pedido->id_pedido,'accion'=>$accion])->assertRedirect();$this->assertSame($estado,$pedido->fresh()->estado);
        }
        $this->assertSame(1,MovimientoInventario::count());
        $otro=$this->pedido($this->user(),$p);$this->post('/gestion/pedidos/estado',['id_pedido'=>$otro->id_pedido,'accion'=>'rechazar'])->assertRedirect();
        $this->assertSame('Rechazado',$otro->fresh()->estado);$this->assertEquals(9.75,Insumo::first()->cantidad_actual);
    }
    public function test_product_and_recipe_upload_and_validation(): void {
        Storage::fake('public');$p=$this->producto();$this->actingAs($this->user('admin'));
        $data=['nombre_producto'=>'Nuevo','descripcion'=>'Descripcion','precio_venta'=>100,'categoria'=>'Pasteles','dias_vida_util'=>3,'estado_producto'=>'Activo','ingredientes'=>[1=>'0.25']];
        // Real PNG fixture: no GD extension required.
        $file=UploadedFile::fake()->createWithContent('pastel.png',base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+afo0AAAAASUVORK5CYII='));
        $this->post('/productos',$data+['imagen'=>$file])->assertSessionHasNoErrors()->assertRedirect('/productos');
        $nuevo=Producto::where('nombre_producto','Nuevo')->firstOrFail();$this->assertEquals(0.25,$nuevo->ingredientes->first()->pivot->cantidad);
        $this->assertNotNull($nuevo->imagen);Storage::disk('public')->assertExists('productos/'.basename($nuevo->imagen));
        $this->post('/productos',$data+['imagen'=>UploadedFile::fake()->create('bad.php',1,'text/plain')])->assertSessionHasErrors('imagen');
        $this->post('/productos/ocultar',['id'=>$nuevo->id_producto])->assertRedirect();$this->get('/')->assertDontSee('Nuevo');
    }
    public function test_inventory_and_user_management(): void {
        $this->actingAs($this->user('admin'));
        $this->post('/inventario',['nombre'=>'Azúcar','cantidad_actual'=>20,'stock_minimo'=>2,'unidad_medida'=>'kg','fecha_ingreso'=>today()->toDateString()])->assertSessionHasNoErrors();
        $this->assertDatabaseHas('inventario',['nombre'=>'Azúcar']);
        $this->post('/usuarios',['nombre'=>'Empleado','correo'=>'empleado@example.test','pass'=>'ClavePrueba123','rol'=>'empleado'])->assertSessionHasNoErrors();
        $u=Usuario::where('correo','empleado@example.test')->firstOrFail();$this->assertTrue(Hash::check('ClavePrueba123',$u->pass));
        $this->post('/usuarios/desactivar',['id'=>$u->id])->assertRedirect();$this->assertSame('Inactivo',$u->fresh()->estado);
    }
    public function test_backup_restore_roundtrip_and_invalid_file(): void {
        $admin=$this->user('admin');$p=$this->producto();$this->actingAs($admin);
        $response=$this->post('/respaldos/exportar',['current_password'=>'ClavePrueba123'])->assertOk();$backup=$response->streamedContent();
        Producto::whereKey($p->id_producto)->update(['nombre_producto'=>'Cambio posterior']);
        $this->post('/respaldos/restaurar',['current_password'=>'ClavePrueba123','confirmar'=>1,'respaldo'=>UploadedFile::fake()->createWithContent('backup.rock',$backup)])->assertRedirect('/login');
        $this->assertSame('Pastel de prueba',$p->fresh()->nombre_producto);$this->assertGuest();
        $this->actingAs($admin)->post('/respaldos/restaurar',['current_password'=>'ClavePrueba123','confirmar'=>1,'respaldo'=>UploadedFile::fake()->createWithContent('bad.rock','invalid')])->assertSessionHasErrors('respaldo');
    }
}
