<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Pedido extends Model {
 protected $table = 'pedidos';
 protected $primaryKey = 'id_pedido';
 public $timestamps = false;
 protected $fillable = ['id_usuario', 'fecha_pedido', 'fecha_entrega', 'indicaciones', 'estado', 'total', 'fecha_aceptacion', 'atendido_por'];
 public function detalles() { return $this->hasMany(PedidoDetalle::class, 'id_pedido'); }
public function cliente() { return $this->belongsTo(Usuario::class, 'id_usuario'); }
}
