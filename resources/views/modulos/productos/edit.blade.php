<x-layouts.app :title="'Editar Producto'">
    <div style="min-height:100vh; background:#222; display:flex; align-items:center; justify-content:center;">
        <div style="width:100%; max-width:600px; background:#292929; border-radius:12px; padding:32px;">
            <form method="POST" action="{{ route('productos.update', $producto->id) }}" style="display:flex; flex-direction:column; gap:20px;">
                @csrf
                @method('PUT')
                <h2 style="font-size:2rem; font-weight:bold; color:#fff; text-align:center; margin-bottom:16px;">Editar Producto</h2>
                <input type="text" name="nombre" id="nombre" value="{{ $producto->nombre }}" placeholder="Nombre del producto"
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                <input type="number" name="precio" id="precio" value="{{ $producto->precio }}" placeholder="Precio"
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                <input type="number" name="stock" id="stock" value="{{ $producto->stock }}" placeholder="Stock"
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                <select name="categoria_id" id="categoria_id" style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                    <option value="">Sin categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" @if($producto->categoria_id == $categoria->id) selected @endif>{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
                <div style="display:flex; gap:16px; margin-top:8px;">
                    <button type="submit" style="background:#2563eb; color:#fff; font-weight:500; border:none; border-radius:6px; padding:10px 32px; cursor:pointer;">Guardar</button>
                    <a href="{{ route('productos.index') }}" style="background:#555; color:#fff; font-weight:500; border:none; border-radius:6px; padding:10px 32px; text-align:center; text-decoration:none; cursor:pointer;">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
<script src="{{ asset('resources/js/productos.js') }}"></script>
