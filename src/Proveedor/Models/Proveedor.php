<?php

namespace Src\Proveedor\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $fillable = [
        'ruc',
        'nombres',
        'telefono',
        'direccion',
        'razon_social',
    ];

    public function productos()
    {
        return $this->hasMany(\Src\Producto\Models\Producto::class, 'proveedor_id');
    }
}
