<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\Cliente\Models\Cliente;
use Faker\Factory as Faker;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_PE');
        for ($i = 0; $i < 10; $i++) {
            Cliente::create([
                'dni' => $faker->unique()->numerify('########'),
                'nombre' => $faker->firstName,
                'apellido' => $faker->lastName,
                'direccion' => $faker->streetAddress,
                'celular' => $faker->unique()->numerify('9########'),
            ]);
        }
    }
}
