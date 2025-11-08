<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('usuarios') && ! Schema::hasColumn('usuarios', 'role_id')) {
            Schema::table('usuarios', function (Blueprint $table) {
                $table->unsignedBigInteger('role_id')->nullable()->after('id')->index();
                // optional foreign key; keep it nullable to avoid migration errors on legacy DBs
                $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('usuarios') && Schema::hasColumn('usuarios', 'role_id')) {
            Schema::table('usuarios', function (Blueprint $table) {
                $table->dropForeign(['role_id']);
                $table->dropColumn('role_id');
            });
        }
    }
};
