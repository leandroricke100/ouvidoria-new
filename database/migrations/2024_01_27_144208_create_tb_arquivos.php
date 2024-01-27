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
        Schema::create('tb_arquivos', function (Blueprint $table) {
            $table->id()->startingValue(50);
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
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_arquivos');
    }
};