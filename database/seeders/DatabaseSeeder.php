<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // Roles deben crearse antes que usuarios para poder asignar role_id
            RolesSeeder::class,
            ClienteSeeder::class,
            UsuarioSeeder::class,
            ProductoSeeder::class,
            ProveedorSeeder::class,
        ]);
    }
}
