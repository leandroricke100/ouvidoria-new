<?php

use App\Models\OuvidoriaMensagem;
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
        Schema::table('tb_ouvidoria_mensagem', function (Blueprint $table) {
            $table->json('arquivos')->nullable()->after('mensagem');
        });

        foreach (OuvidoriaMensagem::all() as $mensagem) if ($mensagem->arquivo) $mensagem->arquivos = json_encode([$mensagem->arquivo]);

        Schema::table('tb_ouvidoria_mensagem', function (Blueprint $table) {
            $table->dropColumn('arquivo');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // desfazer
        Schema::table('tb_ouvidoria_mensagem', function (Blueprint $table) {
            $table->string('arquivo')->nullable()->after('mensagem');
        });

        foreach (OuvidoriaMensagem::all() as $mensagem) if ($mensagem->arquivos) $mensagem->arquivo = json_decode($mensagem->arquivos)[0];

        Schema::table('tb_ouvidoria_mensagem', function (Blueprint $table) {
            $table->dropColumn('arquivos');
        });
    }
};
