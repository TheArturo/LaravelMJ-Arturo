<?php

namespace Src\Cliente\Controllers;

use Illuminate\Http\Request;
use Src\Cliente\Repository\EloquentClient;

class ClienteController extends \App\Http\Controllers\Controller
{
    protected $eloquent;

    public function __construct()
    {
        $this->eloquent = new EloquentClient();
    }

    public function index(Request $request)
    {
        $term = $request->input('term');
        $clientes = (trim($term) !== '')
            ? $this->eloquent->search($term)
            : $this->eloquent->all();
        return view('modulos.clientes.index', compact('clientes'));
    }

    public function edit($id)
    {
        $cliente = $this->eloquent->getEdit($id);
        return view('modulos.clientes.editar', compact('cliente'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            // ...otros campos...
            'celular' => ['required', 'digits:9'],
        ]);

        $this->eloquent->store($request);
        return redirect()->route('clientes.index');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            // ...otros campos...
            'celular' => ['required', 'digits:9'],
        ]);

        $this->eloquent->update($request, $id);
        return redirect()->route('clientes.index');
    }

    public function destroy($id)
    {
        $this->eloquent->destroy($id);
        return redirect()->route('clientes.index');
    }
}
