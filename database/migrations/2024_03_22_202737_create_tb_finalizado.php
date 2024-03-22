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
        Schema::table('tb_ouvidoria_atendimento', function (Blueprint $table) {
            $table->dateTime('finalizado_em')->nullable()->after('situacao');
        });

        Schema::table('tb_ouvidoria_usuarios', function (Blueprint $table) {
            $table->dropColumn('cargo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
