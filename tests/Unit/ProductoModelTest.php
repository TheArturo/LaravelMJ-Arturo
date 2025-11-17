<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Producto\Models\Producto;
use Src\Categoria\Models\Categoria;
use Src\Proveedor\Models\Proveedor;

class ProductoModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_producto_has_expected_table_and_fillable()
    {
        $producto = new Producto();

        $this->assertEquals('productos', $producto->getTable());
        $this->assertContains('nombre', $producto->getFillable());
        $this->assertContains('codigo', $producto->getFillable());
    }

    public function test_producto_belongs_to_categoria_and_proveedor()
    {
        $categoria = Categoria::create(['nombre' => 'Cat Test']);
        $proveedor = Proveedor::create(['nombre' => 'Prov Test']);

        $producto = Producto::create([
            'codigo' => 'PR-001',
            'nombre' => 'Producto Test',
            'descripcion' => 'Desc',
            'precio' => 15.0,
            'stock' => 3,
            'categoria_id' => $categoria->id,
            'proveedor_id' => $proveedor->id,
        ]);

        $this->assertDatabaseHas('productos', ['codigo' => 'PR-001', 'nombre' => 'Producto Test']);
        $this->assertEquals($categoria->id, $producto->categoria_id);
        $this->assertEquals($proveedor->id, $producto->proveedor_id);
    }
}
