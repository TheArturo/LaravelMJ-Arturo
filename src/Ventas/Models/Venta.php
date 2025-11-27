<?php
namespace Src\Ventas\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $fillable = [
        'id_tipo_documento', 
        'tipo_documento', 
        'numero_documento', 
        'cliente_id', 
        'cliente', 
        'direccion', 
        'id_tipo_comprobante', 
        'tipo_comprobante', 
        'serie', 
        'numero_comprobante', 
        'medio_pago', 
        'fecha', 
        'hora', 
        'cantidad_total', 
        'igv', 
        'sub_total', 
        'total', 
        'usuario_id', 
        'sunat_aceptada', 
        'sunat_codigo_hash', 
        'sunat_enlace_pdf', 
        'sunat_enlace_xml', 
        'sunat_enlace_cdr'
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
