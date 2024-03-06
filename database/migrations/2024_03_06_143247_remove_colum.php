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
            $table->dropColumn('nome');
            $table->dropColumn('fonte');
            $table->dropColumn('pasta');
            $table->dropColumn('nome_arquivo');
            $table->dropColumn('extensao');
            $table->dropColumn('mime');
            $table->dropColumn('bytes');
            $table->dropColumn('observacao');
            $table->dropColumn('temporario');
            $table->dropColumn('restrito');
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
