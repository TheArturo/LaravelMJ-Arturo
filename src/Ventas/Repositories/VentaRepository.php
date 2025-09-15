<?php
namespace Src\Ventas\Repositories;

use Src\Ventas\Models\Venta;

class VentaRepository
{
    public function all()
    {
        return Venta::with(['cliente', 'detalles.producto'])->get();
    }

    public function find($id)
    {
        return Venta::with(['cliente', 'detalles.producto'])->findOrFail($id);
    }
}
