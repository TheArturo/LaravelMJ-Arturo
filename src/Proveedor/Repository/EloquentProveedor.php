<?php

namespace Src\Proveedor\Repository;

use Src\Proveedor\Models\Proveedor;
use Src\Proveedor\Validator\ProveedorValidator;
use Illuminate\Support\Facades\Validator;

class EloquentProveedor
{
    public function all()
    {
        return Proveedor::orderByDesc('id')->paginate(10);
    }

    public function find($id)
    {
        return Proveedor::findOrFail($id);
    }

    public function create(array $data)
    {
        $validator = Validator::make($data, ProveedorValidator::rules());
        $validator->validate();
        return Proveedor::create($data);
    }

    public function update($id, array $data)
    {
        $validator = Validator::make($data, ProveedorValidator::rules());
        $validator->validate();
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->update($data);
        return $proveedor;
    }

    public function delete($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();
    }

    public function search($term)
    {
        $term = trim((string)$term);
        if ($term === '') {
            return Proveedor::orderByDesc('id')->paginate(10);
        }
        return Proveedor::where('ruc', 'like', $term . '%')->orderByDesc('id')->paginate(10);
    }
}
