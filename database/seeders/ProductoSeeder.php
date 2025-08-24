<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Producto\Models\Producto;
use Faker\Factory as Faker;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_PE');
        for ($i = 0; $i < 10; $i++) {
            Producto::create([
                'codigo' => $faker->unique()->numerify('P-#####'),
                'nombre' => $faker->word,
                'categoria' => $faker->word,
                'proveedor' => $faker->company,
                'precio' => $faker->randomFloat(2, 10, 500),
                'stock' => $faker->numberBetween(1, 100),
            ]);
        }
    }
}
