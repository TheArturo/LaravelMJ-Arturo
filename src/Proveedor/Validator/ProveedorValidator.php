<?php

namespace Src\Proveedor\Validator;

class ProveedorValidator
{
    public static function rules()
    {
        return [
            'ruc' => 'required|string|max:11',
            'nombres' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'razon_social' => 'nullable|string|max:255',
        ];
    }
}
