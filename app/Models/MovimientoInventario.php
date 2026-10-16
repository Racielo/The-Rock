<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class MovimientoInventario extends Model {
 protected $table = 'movimientos_inventario';
 protected $primaryKey = 'id_movimiento';
 public $timestamps = false;
 protected $fillable = ['id_pedido', 'id_insumo', 'cantidad_descontada', 'fecha'];
 public function pedido() { return $this->belongsTo(Pedido::class, 'id_pedido'); }
}
