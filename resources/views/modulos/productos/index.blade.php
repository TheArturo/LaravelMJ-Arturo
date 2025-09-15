@vite('resources/css/productos.css')
<x-layouts.app :title="'Productos'">
    <div class="producto-index-bg">
        <div class="producto-index-container">
            <form id="formProducto" method="POST"
                action="{{ isset($editProducto) ? route('productos.update', $editProducto->id) : route('productos.store') }}"
                class="producto-index-form">
                @csrf
                <input type="hidden" name="_method" id="inputMethod" value="POST">
                <input type="hidden" name="producto_id" id="producto_id" value="">
                <h2 class="producto-index-title">Nuevo Producto</h2>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre del producto" value=""
                    class="producto-index-input">
                <input type="number" name="precio" id="precio" placeholder="Precio" value=""
                    class="producto-index-input">
                <input type="number" name="stock" id="stock" placeholder="Stock" value=""
                    class="producto-index-input">
                <input type="text" name="codigo" id="codigo" placeholder="Código del producto" value=""
                    class="producto-index-input">
                <select name="categoria_id" id="categoria_id" class="producto-index-select">
                    <option value="">Sin categoría</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
                <select name="proveedor_id" id="proveedor_id" class="producto-index-select">
                    <option value="">Sin proveedor</option>
                    @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombres }}</option>
                    @endforeach
                </select>
                <div class="producto-index-actions">
                    <button type="submit" id="btnGuardar" class="producto-index-btn">Guardar</button>
                    <button type="button" id="btnLimpiar" class="producto-index-cancel">Limpiar</button>
                </div>
            </form>
            <div class="producto-index-list">
                <form method="GET" action="{{ route('productos.index') }}" class="producto-index-search">
                    <input type="text" name="term" value="{{ request('term') }}"
                        placeholder="Buscar por nombre..." class="producto-index-input">
                    <button type="submit" class="producto-index-btn producto-index-btn-search">Buscar</button>
                    <a href="{{ route('productos.index') }}"
                        class="producto-index-cancel producto-index-btn-list">Listar</a>
                </form>
                <div class="producto-index-table-wrap">
                    <table class="producto-index-table">
                        <thead>
                            <tr class="producto-index-table-header">
                                <th class="producto-index-th">CÓDIGO</th>
                                <th class="producto-index-th">NOMBRE</th>
                                <th class="producto-index-th">CATEGORÍA</th>
                                <th class="producto-index-th">PROVEEDOR</th>
                                <th class="producto-index-th">PRECIO</th>
                                <th class="producto-index-th">STOCK</th>
                                <th class="producto-index-th"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productos as $producto)
                                <tr class="producto-index-tr">
                                    <td class="producto-index-td">{{ $producto->codigo }}</td>
                                    <td class="producto-index-td">{{ $producto->nombre }}</td>
                                    <td class="producto-index-td">
                                        {{ is_object($producto->categoria) ? $producto->categoria->nombre : 'Sin categoría' }}
                                    </td>
                                    <td class="producto-index-td">
                                        {{ is_object($producto->proveedor) ? $producto->proveedor->nombres : 'Sin proveedor' }}
                                    </td>
                                    <td class="producto-index-td">{{ $producto->precio }}</td>
                                    <td class="producto-index-td">{{ $producto->stock }}</td>
                                    <td class="producto-index-td">
                                        <div class="producto-index-actions-table">
                                            <a href="{{ route('productos.edit', $producto->id) }}"
                                                class="producto-index-btn producto-index-btn-edit">Editar</a>
                                            <form method="POST"
                                                action="{{ route('productos.destroy', $producto->id) }}"
                                                class="producto-index-form-delete"
                                                onsubmit="return confirm('¿Seguro que deseas eliminar este producto?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="producto-index-btn producto-index-btn-delete">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="producto-index-empty">No hay productos registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="producto-index-pagination">
                    {{ $productos->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
<script src="{{ asset('resources/js/productos.js') }}"></script>
