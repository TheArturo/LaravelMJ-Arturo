<?php
namespace Src\Producto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'categoria_id',
        'proveedor_id',
    ];

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(\Src\Categoria\Models\Categoria::class, 'categoria_id');
    }

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(\Src\Proveedor\Models\Proveedor::class, 'proveedor_id');
    }
}
