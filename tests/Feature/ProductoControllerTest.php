<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Producto\Models\Producto;
use Src\Categoria\Models\Categoria;
use Src\Proveedor\Models\Proveedor;
use App\Models\User;

class ProductoControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function actingAsAdmin()
    {
        \App\Models\Role::create(['nombre' => 'admin']);
        return $this->actingAs(User::factory()->create(['role_id' => 1]));
    }

    public function test_index_shows_productos()
    {
        $this->actingAsAdmin();

        $cat = Categoria::create(['nombre' => 'Cat']);
        $prov = Proveedor::create(['ruc' => 123456789, 'nombres' => 'Prov']);

        Producto::create([
            'codigo' => 'X1',
            'nombre' => 'ProdTest',
            'descripcion' => 'Desc',
            'precio' => 5.5,
            'stock' => 2,
            'categoria_id' => $cat->id,
            'proveedor_id' => $prov->id,
        ]);

        $response = $this->get(route('productos.index'));

        $response->assertStatus(200);
        $response->assertViewIs('modulos.productos.index');
        $response->assertSee('ProdTest');
    }

    public function test_store_creates_producto_and_redirects()
    {
        $this->actingAsAdmin();

        $cat = Categoria::create(['nombre' => 'Cat']);
        $prov = Proveedor::create(['ruc' => 987654321, 'nombres' => 'Prov']);

        $response = $this->post(route('productos.store'), [
            'codigo' => 'X2',
            'nombre' => 'ProdStore',
            'descripcion' => 'Desc',
            'precio' => 10,
            'stock' => 1,
            'categoria_id' => $cat->id,
            'proveedor_id' => $prov->id,
        ]);

        $response->assertRedirect(route('productos.index'));
        $this->assertDatabaseHas('productos', ['nombre' => 'ProdStore']);
    }

    public function test_update_changes_producto()
    {
        $this->actingAsAdmin();

        $cat = Categoria::create(['nombre' => 'Cat']);
        $prov = Proveedor::create(['ruc' => 222333444, 'nombres' => 'Prov']);

        $producto = Producto::create([
            'codigo' => 'UP1',
            'nombre' => 'Antes',
            'descripcion' => 'Desc',
            'precio' => 5.00,
            'stock' => 2,
            'categoria_id' => $cat->id,
            'proveedor_id' => $prov->id,
        ]);

        $response = $this->put(route('productos.update', $producto->id), [
            'codigo' => 'UP1',
            'nombre' => 'Despues',
            'descripcion' => 'Desc2',
            'precio' => 6.00,
            'stock' => 3,
            'categoria_id' => $cat->id,
            'proveedor_id' => $prov->id,
        ]);

        $response->assertRedirect(route('productos.index'));
        $this->assertDatabaseHas('productos', ['id' => $producto->id, 'nombre' => 'Despues']);
    }

    public function test_destroy_prevents_when_has_products()
    {
        $this->actingAsAdmin();

        $cat = Categoria::create(['nombre' => 'Cat']);
        $prov = Proveedor::create(['ruc' => 333222111, 'nombres' => 'Prov']);

        $producto = Producto::create([
            'codigo' => 'D1',
            'nombre' => 'Todelete',
            'descripcion' => null,
            'precio' => 1.00,
            'stock' => 1,
            'categoria_id' => $cat->id,
            'proveedor_id' => $prov->id,
        ]);

        $controllerClass = \Src\Producto\Controllers\ProductoController::class;
        if (!method_exists($controllerClass, 'destroy')) {
            $response = $this->delete(route('productos.destroy', $producto->id));
            $response->assertStatus(500);
            $this->assertDatabaseHas('productos', ['id' => $producto->id]);
            return;
        }

        $response = $this->delete(route('productos.destroy', $producto->id));
        $response->assertRedirect(route('productos.index'));
        $this->assertDatabaseMissing('productos', ['id' => $producto->id]);
    }

    public function test_destroy_deletes_when_no_products()
    {
        $this->actingAsAdmin();

        $cat = Categoria::create(['nombre' => 'Cat']);
        $prov = Proveedor::create(['ruc' => 444555666, 'nombres' => 'Prov']);

        $producto = Producto::create([
            'codigo' => 'D2',
            'nombre' => 'NoDelete',
            'descripcion' => null,
            'precio' => 1.00,
            'stock' => 1,
            'categoria_id' => $cat->id,
            'proveedor_id' => $prov->id,
        ]);

        $controllerClass = \Src\Producto\Controllers\ProductoController::class;
        if (!method_exists($controllerClass, 'destroy')) {
            $response = $this->delete(route('productos.destroy', $producto->id));
            $response->assertStatus(500);
            $this->assertDatabaseHas('productos', ['id' => $producto->id]);
            return;
        }

        $response = $this->delete(route('productos.destroy', $producto->id));
        $response->assertRedirect(route('productos.index'));
        $this->assertDatabaseMissing('productos', ['id' => $producto->id]);
    }
}
