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
        Schema::table('tb_ouvidoria_configuracao', function (Blueprint $table) {

            $table->integer('id_admin')->nullable()->after('id');
            $table->integer('status')->nullable()->after('slog');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_ouvidoria_configuracao', function (Blueprint $table) {
            $table->dropColumn('id_admin');
            $table->dropColumn('status');
        });
    }
};
