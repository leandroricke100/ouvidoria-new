<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tb_ouvidoria_usuarios', function (Blueprint $table) {
            $table->string('admin')->nullable()->after('cidade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_ouvidoria_usuarios', function (Blueprint $table) {
            $table->dropColumn('admin');
        });
    }
};
