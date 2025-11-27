<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Cliente\Models\Cliente;
use App\Models\User;

class ClienteControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function actingAsAdmin()
    {
        \App\Models\Role::create(['nombre' => 'admin']);
        return $this->actingAs(User::factory()->create(['role_id' => 1]));
    }

    public function test_index_shows_clientes()
    {
        $this->actingAsAdmin();

        Cliente::create([
            'dni' => 11111111,
            'nombre' => 'Juan',
            'apellido' => 'Perez',
            'direccion' => 'Calle Falsa 123',
            'celular' => 987654321
        ]);

        $response = $this->get(route('clientes.index'));

        $response->assertStatus(200);
        $response->assertViewIs('modulos.clientes.index');
        $response->assertSee('Juan');
        $response->assertSee('Perez');
    }

    public function test_store_creates_cliente_and_redirects()
    {
        $this->actingAsAdmin();

        $postData = [
            'dni' => 22222222,
            'nombre' => 'Maria',
            'apellido' => 'Lopez',
            'direccion' => 'Av Siempre Viva',
            'celular' => '912345678'
        ];

        $response = $this->post(route('clientes.store'), $postData);

        $response->assertRedirect(route('clientes.index'));
        $this->assertDatabaseHas('clientes', ['nombre' => 'Maria', 'dni' => 22222222]);
    }

    public function test_update_changes_cliente()
    {
        $this->actingAsAdmin();

        $cliente = Cliente::create([
            'dni' => 33333333,
            'nombre' => 'Antes',
            'apellido' => 'Old',
            'direccion' => 'Calle 1',
            'celular' => 900000000
        ]);

        $response = $this->put(route('clientes.update', $cliente->id), [
            'dni' => 33333333,
            'nombre' => 'Despues',
            'apellido' => 'New',
            'direccion' => 'Calle 2',
            'celular' => '912345000'
        ]);

        $response->assertRedirect(route('clientes.index'));
        $this->assertDatabaseHas('clientes', ['id' => $cliente->id, 'nombre' => 'Despues', 'apellido' => 'New']);
    }

    public function test_destroy_prevents_when_has_ventas()
    {
        $this->actingAsAdmin();

        $cliente = Cliente::create([
            'dni' => 44444444,
            'nombre' => 'Con',
            'apellido' => 'Ventas',
            'direccion' => null,
            'celular' => null
        ]);

        $user = \App\Models\User::factory()->create();

        \Src\Ventas\Models\Venta::create([
            'cliente_id' => $cliente->id,
            'usuario_id' => $user->id,
            'fecha' => now()->toDateString(),
            'hora' => now()->toTimeString(),
            'cantidad_total' => 1,
            'total' => 10.00,
        ]);

        $response = $this->delete(route('clientes.destroy', $cliente->id));
        $response->assertStatus(500);
        $this->assertDatabaseHas('clientes', ['id' => $cliente->id]);
    }

    public function test_destroy_deletes_when_no_ventas()
    {
        $this->actingAsAdmin();

        $cliente = Cliente::create([
            'dni' => 55555555,
            'nombre' => 'Sin',
            'apellido' => 'Ventas',
            'direccion' => null,
            'celular' => null
        ]);

        $response = $this->delete(route('clientes.destroy', $cliente->id));

        $response->assertRedirect(route('clientes.index'));
        $this->assertDatabaseMissing('clientes', ['id' => $cliente->id]);
    }
}
