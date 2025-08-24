<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProveedorSeeder extends Seeder {
    public function run() {
        DB::table('proveedores')->insert([
            ['ruc' => '2012345678', 'nombres' => 'Proveedor 1', 'telefono' => '999999999', 'direccion' => 'Av. Siempre Viva', 'razon_social' => 'Empresa Uno'],
        ]);
    }
}
