<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Categoria\Models\Categoria;
use Src\Producto\Models\Producto;

class CategoriaModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_categoria_has_expected_table_and_fillable()
    {
        $categoria = new Categoria();

        $this->assertEquals('categorias', $categoria->getTable());
        $this->assertContains('nombre', $categoria->getFillable());
    }

    public function test_categoria_productos_relationship()
    {
        $categoria = Categoria::create(['nombre' => 'Muebles']);

        $producto = Producto::create([
            'codigo' => 'P-001',
            'nombre' => 'Silla',
            'descripcion' => 'Silla de prueba',
            'precio' => 10.5,
            'stock' => 5,
            'categoria_id' => $categoria->id,
        ]);

        $this->assertTrue($categoria->productos()->exists());
        $this->assertEquals(1, $categoria->productos()->count());
        $this->assertEquals('Silla', $categoria->productos()->first()->nombre);
    }
}
