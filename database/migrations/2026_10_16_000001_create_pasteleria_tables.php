<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('usuarios', function (Blueprint $t) {
            $t->increments('id'); $t->string('nombre',150); $t->string('correo',190)->unique();
            $t->string('pass'); $t->string('rol',20)->default('usuario'); $t->string('estado',20)->default('Activo');
        });
        Schema::create('productos', function (Blueprint $t) {
            $t->increments('id_producto'); $t->string('nombre_producto'); $t->text('descripcion');
            $t->string('imagen')->nullable(); $t->text('elaboracion')->nullable(); $t->decimal('precio_venta',12,2)->default(0);
            $t->string('categoria',90); $t->unsignedInteger('dias_vida_util')->default(3); $t->string('estado_producto',30)->default('Activo');
        });
        Schema::create('inventario', function (Blueprint $t) {
            $t->increments('id_insumo'); $t->string('nombre',200); $t->decimal('cantidad_actual',12,3)->default(0);
            $t->string('unidad_medida',30); $t->decimal('stock_minimo',12,3)->default(0);
            $t->date('fecha_ingreso'); $t->date('fecha_caducidad')->nullable(); $t->string('estado',30)->default('Disponible');
        });
        Schema::create('recetas', function (Blueprint $t) {
            $t->unsignedInteger('id_producto'); $t->unsignedInteger('id_insumo'); $t->decimal('cantidad',12,3);
            $t->primary(['id_producto','id_insumo']);
            $t->foreign('id_producto')->references('id_producto')->on('productos')->restrictOnDelete();
            $t->foreign('id_insumo')->references('id_insumo')->on('inventario')->restrictOnDelete();
        });
        Schema::create('pedidos', function (Blueprint $t) {
            $t->increments('id_pedido'); $t->unsignedInteger('id_usuario'); $t->dateTime('fecha_pedido')->useCurrent();
            $t->date('fecha_entrega')->nullable(); $t->string('indicaciones',500)->nullable();
            $t->string('estado',24)->default('Pendiente')->index(); $t->decimal('total',12,2);
            $t->dateTime('fecha_aceptacion')->nullable(); $t->unsignedInteger('atendido_por')->nullable();
            $t->foreign('id_usuario')->references('id')->on('usuarios')->restrictOnDelete();
            $t->foreign('atendido_por')->references('id')->on('usuarios')->nullOnDelete();
        });
        Schema::create('pedido_detalles', function (Blueprint $t) {
            $t->increments('id_detalle'); $t->unsignedInteger('id_pedido'); $t->unsignedInteger('id_producto');
            $t->string('nombre_producto'); $t->unsignedInteger('cantidad'); $t->decimal('precio_unitario',12,2);
            $t->foreign('id_pedido')->references('id_pedido')->on('pedidos')->cascadeOnDelete();
            $t->foreign('id_producto')->references('id_producto')->on('productos')->restrictOnDelete();
        });
        Schema::create('movimientos_inventario', function (Blueprint $t) {
            $t->increments('id_movimiento'); $t->unsignedInteger('id_pedido'); $t->unsignedInteger('id_insumo');
            $t->decimal('cantidad_descontada',12,3); $t->dateTime('fecha')->useCurrent();
            $t->foreign('id_pedido')->references('id_pedido')->on('pedidos')->restrictOnDelete();
            $t->foreign('id_insumo')->references('id_insumo')->on('inventario')->restrictOnDelete();
            $t->unique(['id_pedido','id_insumo']);
        });
    }
    public function down(): void {
        foreach (['movimientos_inventario','pedido_detalles','pedidos','recetas','inventario','productos','usuarios'] as $table) Schema::dropIfExists($table);
    }
};
