<x-layouts.app :title="'Productos'">
    <div style="min-height:100vh; background:#222; display:flex; align-items:center; justify-content:center;">
        <div style="width:100%; max-width:1100px; display:flex; gap:48px;">
            <form id="formProducto" method="POST"
                action="{{ isset($editProducto) ? route('productos.update', $editProducto->id) : route('productos.store') }}"
                style="flex:1; background:#292929; border-radius:12px; padding:32px; display:flex; flex-direction:column; gap:20px;">
                @csrf
                <input type="hidden" name="_method" id="inputMethod" value="POST">
                <input type="hidden" name="producto_id" id="producto_id" value="">
                <h2 style="font-size:2rem; font-weight:bold; color:#fff; text-align:center; margin-bottom:16px;">Nuevo
                    Producto</h2>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre del producto" value=""
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                <input type="number" name="precio" id="precio" placeholder="Precio" value=""
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                <input type="number" name="stock" id="stock" placeholder="Stock" value=""
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                <input type="text" name="codigo" id="codigo" placeholder="Código del producto" value=""
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                <select name="categoria_id" id="categoria_id"
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                    <option value="">Sin categoría</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
                <select name="proveedor_id" id="proveedor_id"
                    style="padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                    <option value="">Sin proveedor</option>
                    @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombres }}</option>
                    @endforeach
                </select>
                <div style="display:flex; gap:16px; margin-top:8px;">
                    <button type="submit" id="btnGuardar"
                        style="background:#2563eb; color:#fff; font-weight:500; border:none; border-radius:6px; padding:10px 32px; cursor:pointer;">Guardar</button>
                    <button type="button" id="btnLimpiar"
                        style="background:#555; color:#fff; font-weight:500; border:none; border-radius:6px; padding:10px 32px; cursor:pointer;">Limpiar</button>
                </div>
            </form>
            <div
                style="flex:2; background:#292929; border-radius:12px; padding:32px; display:flex; flex-direction:column; gap:20px;">
                <form method="GET" action="{{ route('productos.index') }}"
                    style="display:flex; gap:16px; margin-bottom:16px;">
                    <input type="text" name="term" value="{{ request('term') }}"
                        placeholder="Buscar por nombre..."
                        style="flex:1; padding:10px 16px; border-radius:6px; border:1px solid #444; background:#222; color:#fff;">
                    <button type="submit"
                        style="background:#2563eb; color:#fff; font-weight:500; border:none; border-radius:6px; padding:10px 24px; cursor:pointer;">Buscar</button>
                    <a href="{{ route('productos.index') }}"
                        style="background:#555; color:#fff; font-weight:500; border:none; border-radius:6px; padding:10px 24px; text-align:center; text-decoration:none; cursor:pointer;">Listar</a>
                </form>
                <div style="overflow-x:auto;">
                    <table
                        style="width:100%; border-collapse:collapse; background:#222; color:#fff; border-radius:8px; overflow:hidden;">
                        <thead>
                            <tr style="background:#2563eb; color:#fff;">
                                <th style="padding:12px 8px; text-align:left; font-weight:600;">CÓDIGO</th>
                                <th style="padding:12px 8px; text-align:left; font-weight:600;">NOMBRE</th>
                                <th style="padding:12px 8px; text-align:left; font-weight:600;">CATEGORÍA</th>
                                <th style="padding:12px 8px; text-align:left; font-weight:600;">PROVEEDOR</th>
                                <th style="padding:12px 8px; text-align:left; font-weight:600;">PRECIO</th>
                                <th style="padding:12px 8px; text-align:left; font-weight:600;">STOCK</th>
                                <th style="padding:12px 8px; text-align:left; font-weight:600;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productos as $producto)
                                <tr style="border-bottom:1px solid #333; background:#222;">
                                    <td style="padding:10px 8px;">{{ $producto->codigo }}</td>
                                    <td style="padding:10px 8px;">{{ $producto->nombre }}</td>
                                    <td style="padding:10px 8px;">
                                        {{ is_object($producto->categoria) ? $producto->categoria->nombre : 'Sin categoría' }}
                                    </td>
                                    <td style="padding:10px 8px;">
                                        {{ is_object($producto->proveedor) ? $producto->proveedor->nombres : 'Sin proveedor' }}
                                    </td>
                                    <td style="padding:10px 8px;">{{ $producto->precio }}</td>
                                    <td style="padding:10px 8px;">{{ $producto->stock }}</td>
                                    <td style="padding:10px 8px;">
                                        <div style="display:flex; gap:8px;">
                                            <a href="{{ route('productos.edit', $producto->id) }}"
                                                style="background:#2563eb; color:#fff; border-radius:6px; padding:6px 16px; text-decoration:none; font-size:0.95rem;">Editar</a>
                                            <form method="POST"
                                                action="{{ route('productos.destroy', $producto->id) }}"
                                                style="display:inline;"
                                                onsubmit="return confirm('¿Seguro que deseas eliminar este producto?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    style="background:#dc2626; color:#fff; border:none; border-radius:6px; padding:6px 16px; font-size:0.95rem; cursor:pointer;">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" style="text-align:center; padding:16px; color:#aaa;">No hay
                                        productos registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div style="margin-top:24px; text-align:center;">
                    {{ $productos->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
<script src="{{ asset('resources/js/productos.js') }}"></script>
