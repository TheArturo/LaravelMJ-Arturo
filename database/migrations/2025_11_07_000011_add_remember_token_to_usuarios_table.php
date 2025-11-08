<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('usuarios') && ! Schema::hasColumn('usuarios', 'remember_token')) {
            Schema::table('usuarios', function (Blueprint $table) {
                $table->string('remember_token', 100)->nullable()->after('password');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('usuarios') && Schema::hasColumn('usuarios', 'remember_token')) {
            Schema::table('usuarios', function (Blueprint $table) {
                $table->dropColumn('remember_token');
            });
        }
    }
};
