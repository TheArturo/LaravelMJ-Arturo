<?php

namespace Src\Cliente\Repository;

use Src\Cliente\Models\Cliente;
use Src\Cliente\Validator\ClienteValidator;
use Illuminate\Http\Request;

class EloquentClient
{
    public function getList(Request $request)
    {
        $query = $request->input('q');
        if ($query) {
            return $this->search($query);
        }
        return $this->all();
    }

    public function getEdit($id)
    {
        return $this->find($id);
    }

    public function store(Request $request)
    {
        $request->validate(ClienteValidator::rules());
        return $this->create($request->all());
    }

    public function update(Request $request, $id)
    {
        $request->validate(ClienteValidator::rules());
        return $this->updateData($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->delete($id);
    }

    // Métodos internos
    public function all($orderBy = 'id', $direction = 'desc')
    {
        return Cliente::orderBy($orderBy, $direction)->paginate(10);
    }

    public function search($query)
    {
        return Cliente::where(function ($q) use ($query) {
            $q->where('tipo_persona', 'like', "$query%")
                ->orWhere('tipo_documento', 'like', "$query%")
                ->orWhere('numero_documento', 'like', "$query%")
                ->orWhere('apellidos_razon_social', 'like', "$query%")
                ->orWhere('nombres', 'like', "$query%")
                ->orWhere('direccion', 'like', "$query%")
                ->orWhere('celular', 'like', "$query%")
                ->orWhere('id', 'like', "$query%");
        })->orderByDesc('id')->paginate(10);
    }

    public function searchByDni($term)
    {
        $term = trim((string)$term);
        if ($term === '') {
            return Cliente::all();
        }
        return Cliente::where('dni', 'like', '%' . $term . '%')->get();
    }

    public function find($id)
    {
        return Cliente::findOrFail($id);
    }

    public function create(array $data)
    {
        return Cliente::create($data);
    }

    public function updateData($id, array $data)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->update($data);
        return $cliente;
    }

    public function delete($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();
        return true;
    }
}
