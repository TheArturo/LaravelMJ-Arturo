<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder {
    public function run() {
        DB::table('usuarios')->insert([
            ['name' => 'Cesar Arturo', 'email' => 'arturo123@example.com', 'password' => Hash::make('123')],
            ['name' => 'Señor Prueba', 'email' => 'senor123@example.com', 'password' => Hash::make('123')],
        ]);
    }
}
