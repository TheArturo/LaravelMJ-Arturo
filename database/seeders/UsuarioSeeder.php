<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_PE');
        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
            ]);
            // assign role: first user admin, others cajero by default
            if ($i === 0) {
                $user->role_id = 1;
            } else {
                $user->role_id = 2;
            }
            $user->save();
        }
    }
}
