@vite('resources/css/historialventas.css')
<x-layouts.app>
    <div class="container">
        <h2>Historial de Ventas</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Cantidad</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                <tr>
                    <td>{{ $venta->cliente->nombre ?? '-' }}</td>
                    <td>{{ $venta->cantidad_total }}</td>
                    <td>{{ $venta->fecha }}</td>
                    <td>{{ $venta->hora }}</td>
                    <td>
                        <a href="{{ route('historial_ventas.show', $venta->id) }}">Ver detalle</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.app>
