<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PedidoDetalle extends Model {
 protected $table = 'pedido_detalles';
 protected $primaryKey = 'id_detalle';
 public $timestamps = false;
 protected $fillable = ['id_pedido', 'id_producto', 'nombre_producto', 'cantidad', 'precio_unitario'];
 public function producto() { return $this->belongsTo(Producto::class, 'id_producto'); }
}
