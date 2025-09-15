<?php
namespace Src\HistorialVentas\Models;

class HistorialVenta
{
    public $id;
    public $cliente;
    public $usuario;
    public $fecha;
    public $hora;
    public $total;
    public $detalles = [];

    private static $ventas = [];

    public function __construct($id, $cliente, $usuario, $fecha, $hora, $total, $detalles = [])
    {
        $this->id = $id;
        $this->cliente = $cliente;
        $this->usuario = $usuario;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->total = $total;
        $this->detalles = $detalles;
    }

    public static function getAll()
    {
        return self::$ventas;
    }

    public static function find($id)
    {
        foreach (self::$ventas as $venta) {
            if ($venta->id == $id) {
                return $venta;
            }
        }
        return null;
    }

    public function save()
    {
        $this->id = count(self::$ventas) + 1;
        self::$ventas[] = $this;
    }
}
