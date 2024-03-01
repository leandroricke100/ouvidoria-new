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
            $table->string('nome')->nullable();
            $table->string('fonte')->nullable();
            $table->string('pasta')->nullable();
            $table->string('arquivo')->nullable();
            $table->string('nome_arquivo')->nullable();
            $table->string('extensao')->nullable();
            $table->string('mime')->nullable();
            $table->unsignedBigInteger('bytes')->nullable();
            $table->string('observacao')->nullable();
            $table->tinyInteger('temporario')->default(0);
            $table->tinyInteger('restrito')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_ouvidoria_configuracao', function (Blueprint $table){
            $table->dropColumn('nome');
            $table->dropColumn('fonte');
            $table->dropColumn('pasta');
            $table->dropColumn('arquivo');
            $table->dropColumn('nome_arquivo');
            $table->dropColumn('extensao');
            $table->dropColumn('mime');
            $table->dropColumn('bytes');
            $table->dropColumn('observacao');
            $table->dropColumn('temporario');
            $table->dropColumn('restrito');
        });
    }
};
