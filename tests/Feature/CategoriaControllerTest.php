<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Categoria\Models\Categoria;
use Src\Producto\Models\Producto;
use App\Models\User;

class CategoriaControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function actingAsAdmin()
    {
        \App\Models\Role::create(['nombre' => 'admin']);
        return $this->actingAs(User::factory()->create(['role_id' => 1]));
    }

    public function test_index_shows_categories()
    {
        $this->actingAsAdmin();

        Categoria::create(['nombre' => 'Sillas']);

        $response = $this->get(route('categorias.index'));

        $response->assertStatus(200);
        $response->assertViewIs('modulos.categorias.index');
        $response->assertSee('Sillas');
    }

    public function test_store_creates_category_and_redirects()
    {
        $this->actingAsAdmin();

        $response = $this->post(route('categorias.store'), ['nombre' => 'Mesas']);

        $response->assertRedirect(route('categorias.index'));
        $this->assertDatabaseHas('categorias', ['nombre' => 'Mesas']);
    }

    public function test_update_changes_category()
    {
        $this->actingAsAdmin();

        $categoria = Categoria::create(['nombre' => 'Antiguo']);

        $response = $this->put(route('categorias.update', $categoria->id), ['nombre' => 'Nuevo']);

        $response->assertRedirect(route('categorias.index'));
        $this->assertDatabaseHas('categorias', ['id' => $categoria->id, 'nombre' => 'Nuevo']);
    }

    public function test_destroy_prevents_when_has_products()
    {
        $this->actingAsAdmin();

        $categoria = Categoria::create(['nombre' => 'ConProd']);
        Producto::create([
            'codigo' => 'X1',
            'nombre' => 'ProdX',
            'descripcion' => null,
            'precio' => 1.00,
            'stock' => 1,
            'categoria_id' => $categoria->id,
        ]);

        $response = $this->delete(route('categorias.destroy', $categoria->id));

        $response->assertRedirect(route('categorias.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('categorias', ['id' => $categoria->id]);
    }

    public function test_destroy_deletes_when_no_products()
    {
        $this->actingAsAdmin();

        $categoria = Categoria::create(['nombre' => 'SinProd']);

        $response = $this->delete(route('categorias.destroy', $categoria->id));

        $response->assertRedirect(route('categorias.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('categorias', ['id' => $categoria->id]);
    }
}
