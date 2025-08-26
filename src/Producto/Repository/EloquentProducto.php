<?php
namespace Src\Producto\Repository;

use Src\Producto\Models\Producto;
use Illuminate\Support\Facades\Validator;

class EloquentProducto
{
    public function all()
    {
        return Producto::with('categoria')->orderByDesc('id')->paginate(10);
    }

    public function find($id)
    {
        return Producto::with('categoria')->findOrFail($id);
    }

    public function create(array $data)
    {
        $validator = Validator::make($data, [
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);
        $validator->validate();
        return Producto::create($data);
    }

    public function update($id, array $data)
    {
        $validator = Validator::make($data, [
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
        ]);
        $validator->validate();
        $producto = Producto::findOrFail($id);
        $producto->update($data);
        return $producto;
    }

    public function delete($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();
    }

    public function search($term)
    {
        $term = trim((string)$term);
        if ($term === '') {
            return Producto::with('categoria')->orderByDesc('id')->paginate(10);
        }
        return Producto::with('categoria')
            ->where('nombre', 'like', "%$term%")
            ->orderByDesc('id')
            ->paginate(10);
    }
}
