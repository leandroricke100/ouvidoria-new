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
        Schema::create('tb_ouvidoria_configuracao', function (Blueprint $table) {
            $table->id();
            $table->string('informacoes', 255)->nullable();
            $table->string('titulo', 255)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('tb_ouvidoria_configuracao')->insert([
            'titulo' => 'Câmara Municipal de XXX - MG',
            'informacoes' => 'Rua XXX, nº 123, Centro, XXX - MG, CEP: 12345-678'
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_ouvidoria_configuracao');
    }
};
