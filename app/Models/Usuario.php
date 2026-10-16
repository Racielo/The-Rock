<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Usuario extends Authenticatable {
    protected $table = 'usuarios';
    public $timestamps = false;
    protected $fillable = ['nombre','correo','pass','rol','estado'];
    protected $hidden = ['pass'];
    public function getAuthPasswordName() { return 'pass'; }
    public function pedidos() { return $this->hasMany(Pedido::class, 'id_usuario'); }
}
