<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Proveedor\Models\Proveedor;

class ProveedorModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_proveedor_has_expected_table_and_fillable()
    {
        $proveedor = new Proveedor();

        $this->assertEquals('proveedores', $proveedor->getTable());
        $this->assertContains('nombre', $proveedor->getFillable());
    }

    public function test_proveedor_can_be_created()
    {
        $proveedor = Proveedor::create(['nombre' => 'Proveedor Test']);

        $this->assertDatabaseHas('proveedores', ['nombre' => 'Proveedor Test']);
        $this->assertEquals('Proveedor Test', $proveedor->nombre);
    }

    public function test_proveedor_productos_relationship()
    {
        $proveedor = Proveedor::create(['nombres' => 'Prov Rel', 'razon_social' => 'RS']);

        $producto = \Src\Producto\Models\Producto::create([
            'codigo' => 'PR-REL',
            'nombre' => 'Prod Rel',
            'descripcion' => 'Desc',
            'precio' => 9.99,
            'stock' => 4,
            'proveedor_id' => $proveedor->id,
        ]);

        $this->assertTrue($proveedor->productos()->exists());
        $this->assertEquals(1, $proveedor->productos()->count());
        $this->assertEquals('Prod Rel', $proveedor->productos()->first()->nombre);
    }
}
