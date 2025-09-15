<x-layouts.app :title="'Editar Venta'">
    <link rel="stylesheet" href="{{ asset('resources/css/ventas.css') }}">
    <div class="venta-edit-bg">
        <div class="venta-edit-container">
            <h2 class="venta-edit-title">Editar Venta</h2>
            <form method="POST" action="{{ route('ventas.update', $venta->id) }}" class="venta-edit-form">
                @csrf
                @method('PUT')
                <input type="text" name="cliente_id" value="{{ $venta->cliente_id }}" placeholder="ID Cliente" class="venta-edit-input">
                <input type="text" name="producto_id" value="{{ $venta->producto_id }}" placeholder="ID Producto" class="venta-edit-input">
                <input type="number" name="cantidad" value="{{ $venta->cantidad }}" placeholder="Cantidad" class="venta-edit-input">
                <input type="number" name="total" value="{{ $venta->total }}" placeholder="Total" class="venta-edit-input">
                <div class="venta-edit-actions">
                    <button type="submit" class="venta-edit-btn">Guardar cambios</button>
                    <a href="{{ route('ventas.index') }}" class="venta-edit-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
<script src="{{ asset('resources/js/ventas.js') }}"></script>
