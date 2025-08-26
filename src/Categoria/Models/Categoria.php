<?php

namespace Src\Categoria\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $fillable = ['nombre'];

    public function productos(): HasMany
    {
        return $this->hasMany(\Src\Producto\Models\Producto::class, 'categoria_id');
    }
}
