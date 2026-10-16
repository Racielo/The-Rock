<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Producto extends Model {
 protected $table = 'productos';
 protected $primaryKey = 'id_producto';
 public $timestamps = false;
 protected $fillable = ['nombre_producto', 'descripcion', 'imagen', 'elaboracion', 'precio_venta', 'categoria', 'dias_vida_util', 'estado_producto'];
 public function ingredientes() { return $this->belongsToMany(Insumo::class, 'recetas', 'id_producto', 'id_insumo')->withPivot('cantidad'); }
}
