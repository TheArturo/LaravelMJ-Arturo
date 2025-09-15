<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->unique();
            $table->string('nombre');
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->string('descripcion')->nullable();
            $table->unsignedBigInteger('proveedor_id')->nullable();
            $table->decimal('precio', 10, 2);
            $table->integer('stock');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('productos');
    }
};
