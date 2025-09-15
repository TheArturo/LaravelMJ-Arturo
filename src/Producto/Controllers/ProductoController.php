<?php
namespace Src\Producto\Controllers;

use Src\Producto\Models\Producto;
use Src\Categoria\Models\Categoria;
use Src\Proveedor\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $term = $request->input('term');
        $productos = ($term)
            ? Producto::with(['categoria', 'proveedor'])->where('nombre', 'like', "%$term%")->orderByDesc('id')->paginate(10)
            : Producto::with(['categoria', 'proveedor'])->orderByDesc('id')->paginate(10);
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        return view('modulos.productos.index', compact('productos', 'categorias', 'proveedores'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo' => 'required|string|max:20|unique:productos,codigo',
            'nombre' => 'required|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'categoria_id' => 'nullable|exists:categorias,id',
            'proveedor_id' => 'nullable|exists:proveedores,id',
        ]);
        Producto::create($data);
        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente');
    }

    public function edit($id)
    {
        $producto = Producto::with(['categoria', 'proveedor'])->findOrFail($id);
        $categorias = Categoria::all();
        $proveedores = Proveedor::all();
        return view('modulos.productos.edit', compact('producto', 'categorias', 'proveedores'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'codigo' => 'required|string|max:20|unique:productos,codigo,' . $id,
            'nombre' => 'required|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'categoria_id' => 'nullable|exists:categorias,id',
            'proveedor_id' => 'nullable|exists:proveedores,id',
        ]);
        $producto = Producto::findOrFail($id);
        $producto->update($data);
        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente');
    }
}
