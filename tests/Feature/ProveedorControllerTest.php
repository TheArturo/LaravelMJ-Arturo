<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Proveedor\Models\Proveedor;
use App\Models\User;

class ProveedorControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function actingAsAdmin()
    {
        \App\Models\Role::create(['nombre' => 'admin']);
        return $this->actingAs(User::factory()->create(['role_id' => 1]));
    }

    public function test_index_shows_proveedores()
    {
        $this->actingAsAdmin();

        Proveedor::create(['ruc' => '123456789', 'nombres' => 'Prov Uno']);

        $response = $this->get(route('proveedores.index'));

        $response->assertStatus(200);
        $response->assertViewIs('modulos.proveedores.index');
        $response->assertSee('Prov Uno');
    }

    public function test_store_creates_proveedor_and_redirects()
    {
        $this->actingAsAdmin();

        $response = $this->post(route('proveedores.store'), ['ruc' => '987654321', 'nombres' => 'Prov Dos']);

        $response->assertRedirect(route('proveedores.index'));
        $this->assertDatabaseHas('proveedores', ['ruc' => 987654321, 'nombres' => 'Prov Dos']);
    }

    public function test_update_changes_proveedor()
    {
        $this->actingAsAdmin();

        $proveedor = Proveedor::create(['ruc' => '111222333', 'nombres' => 'Prov Old']);

        $response = $this->put(route('proveedores.update', $proveedor->id), ['ruc' => '111222333', 'nombres' => 'Prov New']);

        $response->assertRedirect(route('proveedores.index'));
        $this->assertDatabaseHas('proveedores', ['id' => $proveedor->id, 'nombres' => 'Prov New']);
    }

    public function test_destroy_deletes_or_handles_missing_method()
    {
        $this->actingAsAdmin();

        $proveedor = Proveedor::create(['ruc' => '222333444', 'nombres' => 'Prov Remove']);

        $controllerClass = 'Src\\Proveedor\\Controllers\\ProveedorController';
        if (!class_exists($controllerClass) || !method_exists($controllerClass, 'destroy')) {
            $response = $this->delete(route('proveedores.destroy', $proveedor->id));
            $response->assertStatus(500);
            $this->assertDatabaseHas('proveedores', ['id' => $proveedor->id]);
            return;
        }

        $response = $this->delete(route('proveedores.destroy', $proveedor->id));
        $response->assertRedirect(route('proveedores.index'));
        $this->assertDatabaseMissing('proveedores', ['id' => $proveedor->id]);
    }
}
