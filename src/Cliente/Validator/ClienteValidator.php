<?php

namespace Src\Cliente\Validator;

class ClienteValidator
{
    public static function rules()
    {
        return [
            'dni' => 'required|numeric',
            'nombre' => 'required',
            'apellido' => 'required',
            'direccion' => 'required',
            'celular' => 'required|numeric',
        ];
    }
}
