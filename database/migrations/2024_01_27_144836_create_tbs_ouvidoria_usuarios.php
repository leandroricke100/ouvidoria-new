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

        date_default_timezone_set('America/Sao_Paulo');

        Schema::create('tb_ouvidoria_usuarios', function (Blueprint $table) {
            $table->id();

            $table->string('tipo_pessoa')->nullable();
            $table->string('nome_completo')->nullable();
            $table->string('cpf', 15)->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('cargo')->nullable();
            $table->string('organizacao')->nullable();
            $table->string('profissao')->nullable();
            $table->string('sexo')->nullable();
            $table->string('email')->nullable();
            $table->string('telefone')->nullable();
            $table->string('celular')->nullable();
            $table->string('email_alternativo')->nullable();
            $table->string('endereco')->nullable();
            $table->string('cep', 9)->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('senha')->nullable();
            $table->string('token_senha')->nullable();

            $table->string('nome_fantasia')->nullable();
            $table->string('cnpj')->nullable();
            $table->string('razao_social')->nullable();
            $table->string('contato_principal')->nullable();
            $table->string('area_atuacao')->nullable();
            $table->string('nome_responsavel')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('tb_ouvidoria_atendimento', function (Blueprint $table) {
            $table->id();

            $table->integer('id_usuario')->nullable();
            $table->string('assunto')->nullable();
            $table->string('prioridade')->nullable();
            $table->string('data')->nullable();
            $table->string('hora')->nullable();
            $table->string('endereco')->nullable();
            $table->string('numero_referencia')->nullable();
            $table->string('tipo')->nullable();
            $table->string('cod_atendimento_anterior')->nullable();

            $table->string('numero')->nullable();
            $table->integer('ano')->nullable();
            $table->string('status')->nullable();
            $table->string('situacao')->nullable();
            $table->string('codigo')->nullable();
            $table->tinyInteger('sigiloso')->default(0);
            $table->string('ref_atendimento')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('tb_ouvidoria_mensagem', function (Blueprint $table) {
            $table->id();
            $table->integer('id_atendimento')->nullable();
            $table->text('mensagem')->nullable();
            $table->string('arquivo')->nullable();
            $table->string('autor')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_ouvidoria_usuarios');
        Schema::dropIfExists('tb_ouvidoria_atendimento');
        Schema::dropIfExists('tb_ouvidoria_mensagem');
    }
};