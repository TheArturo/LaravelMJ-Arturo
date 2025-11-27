@vite('resources/css/historialventas.css')
<x-layouts.app>
<div>
    <h2>Detalle de Venta</h2>
    <table class="table">
        <tr><th>Cliente</th><td>{{ $venta->cliente ?? '-' }}</td></tr>
    <tr><th>Usuario</th><td>{{ $venta->usuario->name ?? '-' }}</td></tr>
        <tr><th>Fecha</th><td>{{ $venta->fecha }}</td></tr>
        <tr><th>Hora</th><td>{{ $venta->hora }}</td></tr>
        <tr><th>Cantidad total</th><td>{{ $venta->cantidad_total }}</td></tr>
        <tr><th>Total</th><td>${{ $venta->total }}</td></tr>
    </table>
    <h3>Productos vendidos</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre del producto</th>
                <th>Cantidad</th>
                <th>Precio unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venta->detalles as $detalle)
            <tr>
                <td>{{ $detalle->producto->codigo ?? '-' }}</td>
                <td>{{ $detalle->producto->nombre ?? '-' }}</td>
                <td>{{ $detalle->cantidad }}</td>
                <td>{{ $detalle->precio_unitario }}</td>
                <td>{{ $detalle->subtotal }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <a href="{{ route('historial_ventas.index') }}">Volver al historial</a>
</div>
</x-layouts.app>
