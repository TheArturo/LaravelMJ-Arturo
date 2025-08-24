<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->string('ruc', 20)->unique();
            $table->string('nombres');
            $table->string('telefono', 20)->nullable();
            $table->string('direccion')->nullable();
            $table->string('razon_social')->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('proveedores');
    }
};
