<?php
namespace Src\Categoria\Validator;

class CategoriaValidator
{
    public static function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100',
        ];
    }
}
