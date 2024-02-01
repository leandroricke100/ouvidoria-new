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

            $table->string('titulo')->nullable();
            $table->string('conteudo')->nullable();
            $table->string('slog')->nullable();
            $table->string('link')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_ouvidoria_configuracao');
    }
};
