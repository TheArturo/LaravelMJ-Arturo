<?php
namespace Src\HistorialVentas\Validator;

class VentaValidator
{
    public static function validate($data)
    {
        $errors = [];
        if (empty($data['cliente_nombre'])) $errors[] = 'El cliente es obligatorio.';
        if (empty($data['usuario_nombre'])) $errors[] = 'El usuario es obligatorio.';
        if (empty($data['fecha'])) $errors[] = 'La fecha es obligatoria.';
        if (empty($data['hora'])) $errors[] = 'La hora es obligatoria.';
        if (!is_numeric($data['total'])) $errors[] = 'El total debe ser numérico.';
        if (empty($data['detalles']) || !is_array($data['detalles'])) $errors[] = 'Debe haber al menos un producto.';
        foreach ($data['detalles'] as $detalle) {
            if (empty($detalle['nombre_producto'])) $errors[] = 'El nombre del producto es obligatorio.';
            if (!is_numeric($detalle['cantidad']) || $detalle['cantidad'] <= 0) $errors[] = 'La cantidad debe ser mayor a 0.';
            if (!is_numeric($detalle['precio_unitario'])) $errors[] = 'El precio debe ser numérico.';
        }
        return $errors;
    }
}
