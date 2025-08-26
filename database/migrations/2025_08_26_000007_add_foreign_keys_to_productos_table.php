<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('productos', function (Blueprint $table) {
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('set null');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');
        });
    }
    public function down() {
        Schema::table('productos', function (Blueprint $table) {
            $table->dropForeign(['proveedor_id']);
            $table->dropForeign(['categoria_id']);
        });
    }
};
