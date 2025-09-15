<?php
namespace Src\HistorialVentas\Repository;

use Src\HistorialVentas\Models\HistorialVenta;

class VentaRepository
{
    public static function saveVenta($venta)
    {
        $venta->save();
    }

    public static function getVentas()
    {
        return HistorialVenta::getAll();
    }

    public static function getVentaById($id)
    {
        return HistorialVenta::find($id);
    }
}
