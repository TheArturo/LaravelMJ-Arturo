<?php

namespace Src\Cliente\Validator;

class ClienteValidator
{
    public static function rules()
    {
        return [
            'tipo_persona' => 'required',
            'tipo_documento' => 'required',
            'numero_documento' => 'required|numeric',
            'apellidos_razon_social' => 'required',
            //'nombres' => 'required',
            'direccion' => 'required',
            'celular' => 'required|numeric',
        ];
    }
}
