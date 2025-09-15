<?php
namespace Src\HistorialVentas\Models;

class DetalleVenta
{
    public $id;
    public $venta;
    public $producto;
    public $cantidad;
    public $precio_unitario;
    public $subtotal;

    public function __construct($id, $venta, $producto, $cantidad, $precio_unitario, $subtotal)
    {
        $this->id = $id;
        $this->venta = $venta;
        $this->producto = $producto;
        $this->cantidad = $cantidad;
        $this->precio_unitario = $precio_unitario;
        $this->subtotal = $subtotal;
    }
}
