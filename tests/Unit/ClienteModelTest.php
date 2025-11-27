<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\Cliente\Models\Cliente;

class ClienteModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_cliente_has_expected_table_and_fillable()
    {
        $cliente = new Cliente();

        $this->assertEquals('clientes', $cliente->getTable());
        $this->assertContains('nombre', $cliente->getFillable());
    }

    public function test_cliente_can_be_created()
    {
        $cliente = Cliente::create(['nombre' => 'Cliente Prueba']);

        $this->assertDatabaseHas('clientes', ['nombre' => 'Cliente Prueba']);
        $this->assertEquals('Cliente Prueba', $cliente->nombre);
    }

    public function test_cliente_ventas_relationship()
    {
        $cliente = Cliente::create(['nombre' => 'Cliente Rel']);

        $venta = \Src\Ventas\Models\Venta::create([
            'cliente_id' => $cliente->id,
            'fecha' => now()->toDateString(),
            'hora' => now()->toTimeString(),
            'cantidad_total' => 1,
            'total' => 100,
            'usuario_id' => 1,
        ]);

        $this->assertTrue($cliente->ventas()->exists());
        $this->assertEquals(1, $cliente->ventas()->count());
        $this->assertEquals($venta->id, $cliente->ventas()->first()->id);
    }
}
