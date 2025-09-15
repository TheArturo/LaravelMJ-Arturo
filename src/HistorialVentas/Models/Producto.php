<?php
namespace Src\HistorialVentas\Models;

class Producto
{
    public $id;
    public $codigo;
    public $nombre;

    public function __construct($id, $codigo, $nombre)
    {
        $this->id = $id;
        $this->codigo = $codigo;
        $this->nombre = $nombre;
    }
}
