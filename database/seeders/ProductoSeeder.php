<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder {
    public function run() {
        DB::table('productos')->insert([
            ['codigo' => 'P00001', 'nombre' => 'Mesa de madera de Mesa', 'categoria' => 'Mesa', 'proveedor' => 'Mesa', 'precio' => 400.0, 'stock' => 2],
            ['codigo' => 'P00002', 'nombre' => 'Prueba', 'categoria' => 'Decoracion', 'proveedor' => 'Decoracion', 'precio' => 22.0, 'stock' => 2],
            ['codigo' => 'P00003', 'nombre' => 'prueba2', 'categoria' => 'Silla', 'proveedor' => 'Silla', 'precio' => 1000.0, 'stock' => 6],
        ]);
    }
}
