<?php
namespace Src\Categoria\Repository;

use Src\Categoria\Models\Categoria;
use Illuminate\Support\Facades\Validator;

class EloquentCategoria
{
    public function all()
    {
        return Categoria::orderByDesc('id')->paginate(10);
    }

    public function find($id)
    {
        return Categoria::findOrFail($id);
    }

    public function create(array $data)
    {
        $validator = Validator::make($data, [
            'nombre' => 'required|string|max:100',
        ]);
        $validator->validate();
        return Categoria::create($data);
    }

    public function update($id, array $data)
    {
        $validator = Validator::make($data, [
            'nombre' => 'required|string|max:100',
        ]);
        $validator->validate();
        $categoria = Categoria::findOrFail($id);
        $categoria->update($data);
        return $categoria;
    }

    public function delete($id)
    {
        $categoria = Categoria::findOrFail($id);
        if ($categoria->productos()->count() > 0) {
            session()->flash('error', 'No se puede eliminar la categoría porque está asociada a productos existentes.');
            return false;
        }
        return $categoria->delete();
    }

    public function search($term)
    {
        $term = trim((string)$term);
        if ($term === '') {
            return Categoria::orderByDesc('id')->paginate(10);
        }
        return Categoria::where('nombre', 'like', "%$term%")->orderByDesc('id')->paginate(10);
    }
}
