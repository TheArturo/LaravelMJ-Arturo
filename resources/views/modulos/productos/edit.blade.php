@vite('resources/css/productos.css')
<x-layouts.app :title="'Editar Producto'">
    <div class="producto-index-bg">
        <div class="producto-index-container">
            <form method="POST" action="{{ route('productos.update', $producto->id) }}" class="producto-index-form">
                @csrf
                @method('PUT')
                <h2 class="producto-index-title">Editar Producto</h2>
                <input type="text" name="nombre" id="nombre" value="{{ $producto->nombre }}" placeholder="Nombre del producto" class="producto-index-input">
                <input type="text" name="codigo" id="codigo" value="{{ $producto->codigo }}" placeholder="Código" class="producto-index-input">
                <input type="number" name="precio" id="precio" value="{{ $producto->precio }}" placeholder="Precio" class="producto-index-input">
                <input type="number" name="stock" id="stock" value="{{ $producto->stock }}" placeholder="Stock" class="producto-index-input">
                <select name="categoria_id" id="categoria_id" class="producto-index-select">
                    <option value="">Sin categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" @if($producto->categoria_id == $categoria->id) selected @endif>{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
                <select name="proveedor_id" id="proveedor_id" class="producto-index-select">
                    <option value="">Sin proveedor</option>
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}" @if($producto->proveedor_id == $proveedor->id) selected @endif>{{ $proveedor->nombres }}</option>
                    @endforeach
                </select>
                <div class="producto-index-actions">
                    <button type="submit" class="producto-index-btn">Guardar</button>
                    <a href="{{ route('productos.index') }}" class="producto-index-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
<script src="{{ asset('resources/js/productos.js') }}"></script>
