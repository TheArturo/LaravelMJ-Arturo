<?php

namespace Src\Proveedor\Controllers;

use Src\Proveedor\Repository\EloquentProveedor;
use Illuminate\Http\Request;

class ProveedorController
{
    protected $repo;

    public function __construct()
    {
        $this->repo = new EloquentProveedor();
    }

    public function index(Request $request)
    {
        $term = $request->input('term');
        $proveedores = (trim($term) !== '')
            ? $this->repo->search($term)
            : $this->repo->all();
        return view('modulos.proveedores.index', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $this->repo->create($request->all());
        return redirect()->route('proveedores.index');
    }

    public function edit($id)
    {
        $proveedor = $this->repo->find($id);
        return view('modulos.proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, $id)
    {
        $this->repo->update($id, $request->all());
        return redirect()->route('proveedores.index');
    }

    public function destroy($id)
    {
        $result = $this->repo->delete($id);
        if ($result === false) {
            return redirect()->route('proveedores.index')->with('error', session('error'));
        }
        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente');
    }

    public function show($id)
    {
        // Este método está definido para evitar el error de ruta, pero no se usa en la vista.
        return redirect()->route('proveedores.index');
    }
}
