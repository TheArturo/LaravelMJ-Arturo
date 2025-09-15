<?php
namespace Src\Ventas\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $fillable = [
        'cliente_id', 'fecha', 'hora', 'cantidad_total', 'total', 'usuario_id'
    ];


    public function cliente()
    {
        return $this->belongsTo(\Src\Cliente\Models\Cliente::class, 'cliente_id');
    }

    public function usuario()
    {
        return $this->belongsTo(\App\Models\User::class, 'usuario_id');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleVenta::class, 'venta_id');
    }
}
