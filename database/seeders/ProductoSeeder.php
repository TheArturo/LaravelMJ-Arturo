<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Producto\Models\Producto;
use Src\Categoria\Models\Categoria;
use Src\Proveedor\Models\Proveedor;
use Faker\Factory as Faker;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_PE');
        $categorias = Categoria::pluck('id')->toArray();
        $proveedores = Proveedor::pluck('id')->toArray();
        for ($i = 0; $i < 10; $i++) {
            Producto::create([
                'codigo' => $faker->unique()->numerify('P-#####'),
                'nombre' => $faker->word,
                'descripcion' => $faker->sentence,
                'categoria_id' => $faker->randomElement($categorias),
                'proveedor_id' => $faker->randomElement($proveedores),
                'precio' => $faker->randomFloat(2, 10, 500),
                'stock' => $faker->numberBetween(1, 100),
            ]);
        }
    }
}
