<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Proveedor\Models\Proveedor;
use Faker\Factory as Faker;

class ProveedorSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_PE');
        for ($i = 0; $i < 10; $i++) {
            Proveedor::create([
                'ruc' => $faker->unique()->numerify('20########'),
                'nombres' => $faker->company,
                'telefono' => $faker->unique()->numerify('9########'),
                'direccion' => $faker->address,
                'razon_social' => $faker->catchPhrase,
            ]);
        }
    }
}
