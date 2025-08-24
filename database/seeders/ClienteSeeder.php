<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClienteSeeder extends Seeder {
    public function run() {
        DB::table('clientes')->insert([
            ['dni' => '12345678', 'nombre' => 'Omar', 'apellido' => 'Gonzalo', 'direccion' => 'Barranco', 'celular' => '123456789'],
            ['dni' => '12345679', 'nombre' => 'Edwar', 'apellido' => 'Curi', 'direccion' => 'SJL', 'celular' => '963258741'],
            ['dni' => '98745632', 'nombre' => 'Sebastian', 'apellido' => 'Ninaja', 'direccion' => 'Comas', 'celular' => '123456789'],
        ]);
    }
}
