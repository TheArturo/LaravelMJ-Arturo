<?php

namespace Src\Categoria\Controllers;

use Src\Categoria\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $term = $request->input('term');
        $categorias = ($term)
            ? Categoria::where('nombre', 'like', "%$term%")->paginate(10)
            : Categoria::paginate(10);
        return view('modulos.categorias.index', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
        ]);
        Categoria::create($request->only('nombre'));
        return redirect()->route('categorias.index');
    }

    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('modulos.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
        ]);
        $categoria = Categoria::findOrFail($id);
        $categoria->update($request->only('nombre'));
        return redirect()->route('categorias.index');
    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();
        return redirect()->route('categorias.index');
    }
}
