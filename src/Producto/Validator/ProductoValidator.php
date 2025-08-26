<?php
namespace Src\Producto\Validator;

class ProductoValidator
{
    public static function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
        ];
    }
}
