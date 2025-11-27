<?php
namespace Src\Ventas\Repositories;

use Src\Ventas\Models\Venta;

class VentaRepository
{
    public function all($filters = [])
    {
        return Venta::with(['cliente', 'detalles.producto'])
            ->when(!empty($filters['fecha_desde']), function ($query) use ($filters) {
                $query->whereDate('fecha', '>=', $filters['fecha_desde']);
            })
            ->when(!empty($filters['fecha_hasta']), function ($query) use ($filters) {
                $query->whereDate('fecha', '<=', $filters['fecha_hasta']);
            })
            ->when(!empty($filters['tipo_comprobante']), function ($query) use ($filters) {
                $query->where('tipo_comprobante', $filters['tipo_comprobante']);
            })
            ->when(!empty($filters['numero_comprobante']), function ($query) use ($filters) {
                $query->where('numero_comprobante', $filters['numero_comprobante']);
            })
            ->when(!empty($filters['documento']), function ($query) use ($filters) {
                $query->where('numero_documento', 'like', '%' . $filters['documento'] . '%');
            })
            ->when(!empty($filters['cliente']), function ($query) use ($filters) {
                $query->where('cliente', 'like', '%' . $filters['cliente'] . '%');
            })
            ->when(!empty($filters['estado_sunat']), function ($query) use ($filters) {
                $query->where('sunat_aceptada', $filters['estado_sunat']);
            })
            ->orderBy('id', 'desc')
            ->get();
    }

    public function find($id)
    {
        return Venta::with(['cliente', 'detalles.producto'])->findOrFail($id);
    }
}
