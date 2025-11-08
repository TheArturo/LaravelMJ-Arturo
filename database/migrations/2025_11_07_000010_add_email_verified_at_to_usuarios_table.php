<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('usuarios') && ! Schema::hasColumn('usuarios', 'email_verified_at')) {
            Schema::table('usuarios', function (Blueprint $table) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('usuarios') && Schema::hasColumn('usuarios', 'email_verified_at')) {
            Schema::table('usuarios', function (Blueprint $table) {
                $table->dropColumn('email_verified_at');
            });
        }
    }
};
