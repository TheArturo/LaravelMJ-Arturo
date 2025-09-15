<?php
namespace Src\HistorialVentas\Controllers;

use Src\Ventas\Models\Venta;
use Src\Ventas\Models\DetalleVenta;
use Src\Producto\Models\Producto;

class HistorialVentasController
{
    // Mostrar historial de ventas
    public function index()
    {
    $ventas = Venta::with(['cliente', 'user', 'detalles.producto'])->orderBy('fecha', 'desc')->get();
    return view('modulos.historial_ventas.index', compact('ventas'));
    }

    // Mostrar detalle de una venta
    public function show($id)
    {
    $venta = Venta::with(['cliente', 'user', 'detalles.producto'])->findOrFail($id);
    return view('modulos.historial_ventas.show', compact('venta'));
    }

    // Guardar una nueva venta
    public function store($data)
    {
        // Validación básica
        if (empty($data['cliente_id']) || empty($data['user_id']) || empty($data['fecha']) || empty($data['hora']) || empty($data['total']) || empty($data['detalles'])) {
            return ['error' => 'Datos incompletos'];
        }
        $venta = new Venta();
        $venta->cliente_id = $data['cliente_id'];
        $venta->user_id = $data['user_id'];
        $venta->fecha = $data['fecha'];
        $venta->hora = $data['hora'];
        $venta->total = $data['total'];
        $venta->save();

        foreach ($data['detalles'] as $detalle) {
            $detalleVenta = new DetalleVenta();
            $detalleVenta->venta_id = $venta->id;
            $detalleVenta->producto_id = $detalle['producto_id'];
            $detalleVenta->codigo_producto = $detalle['codigo_producto'] ?? null;
            $detalleVenta->nombre_producto = $detalle['nombre_producto'];
            $detalleVenta->cantidad = $detalle['cantidad'];
            $detalleVenta->precio_unitario = $detalle['precio_unitario'];
            $detalleVenta->subtotal = $detalle['subtotal'];
            $detalleVenta->save();
        }
        return true;
    }
}
