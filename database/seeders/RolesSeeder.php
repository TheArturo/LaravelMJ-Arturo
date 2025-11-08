<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Role 1 = admin (tiene todo)
        Role::updateOrCreate(['id' => 1], ['nombre' => 'admin', 'descripcion' => 'Acceso completo al sistema']);
        // Role 2 = cajero (ventas, nueva venta, productos CRUD, clientes CRUD)
        Role::updateOrCreate(['id' => 2], ['nombre' => 'cajero', 'descripcion' => 'Permisos limitados para cajero']);
    }
}
