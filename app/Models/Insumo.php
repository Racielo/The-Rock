<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Insumo extends Model {
 protected $table = 'inventario';
 protected $primaryKey = 'id_insumo';
 public $timestamps = false;
 protected $fillable = ['nombre', 'cantidad_actual', 'unidad_medida', 'stock_minimo', 'fecha_ingreso', 'fecha_caducidad', 'estado'];
 public function productos() { return $this->belongsToMany(Producto::class, 'recetas', 'id_insumo', 'id_producto')->withPivot('cantidad'); }
}
