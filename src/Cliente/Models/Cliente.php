<?php

namespace Src\Cliente\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = [
        'dni',
        'nombre',
        'apellido',
        'direccion',
        'celular'
    ];
}
