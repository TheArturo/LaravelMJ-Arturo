<?php
namespace Src\Ventas\Models;

use Illuminate\Database\Eloquent\Model;

class Param extends Model
{
    protected $table = 't_params';
    protected $fillable = [
        'id', 'id_tipo_comprobante', 'tipo_comprobante', 'serie', 'numero_comprobante'
    ];
}