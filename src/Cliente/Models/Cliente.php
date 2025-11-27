<?php

namespace Src\Cliente\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = [
        'tipo_persona',
        'tipo_documento',
        'numero_documento',
        'apellidos_razon_social',
        'nombres',
        'direccion',
        'celular'
    ];
}
