<?php
namespace Src\Ventas\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_ventas';
    protected $fillable = [
        'venta_id',
        'producto_id',
        'codigo_producto',
        'nombre_producto',
        'cliente_nombre',
        'usuario_nombre',
        'fecha',
        'hora',
        'cantidad',
        'valor_unitario',
        'precio_unitario',
        'subtotal',
        'igv',
        'total'
    ];

    public function producto()
    {
        return $this->belongsTo(\Src\Producto\Models\Producto::class, 'producto_id');
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }
}
