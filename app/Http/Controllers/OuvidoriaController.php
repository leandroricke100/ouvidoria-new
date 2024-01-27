<?php

namespace App\Http\Controllers;

use App\Models\OuvidoriaUsuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class OuvidoriaController extends Controller
{
    public function cadastro(Request $request)
    {
        $dadosForm = $request->all();

        $user = new OuvidoriaUsuario;

        if ($dadosForm['profissao'] == 'null') {
            $user->profissao = null;
        } else {
            $user->profissao = $dadosForm['profissao'];
        }

        if ($dadosForm['sexo'] == 'null') {
            $user->sexo = null;
        } else {
            $user->sexo = $dadosForm['sexo'];
        }

        if ($dadosForm['areaAtuacao'] == 'null') {
            $user->area_atuacao = null;
        } else {
            $user->area_atuacao = $dadosForm['areaAtuacao'];
        }

        $user->bairro = $dadosForm['bairro'];
        $user->celular = $dadosForm['celular'];
        $user->cep = intval($dadosForm['cep']);
        $user->cidade = $dadosForm['cidade'];
        $user->cnpj = $dadosForm['cnpj'];
        $user->complemento = $dadosForm['complemento'];
        $user->cpf = $dadosForm['cpf'];
        $user->data_nascimento = $dadosForm['dataNascimento'];
        $user->email = $dadosForm['email'];
        $user->email_alternativo = $dadosForm['emailAlternativo'];
        $user->endereco = $dadosForm['endereco'];
        $user->cargo = $dadosForm['funcao'];
        $user->nome_completo = $dadosForm['nomeCompleto'];
        $user->contato_principal = $dadosForm['nomeContato'];
        $user->nome_fantasia = $dadosForm['nomeFantasia'];
        $user->organizacao = $dadosForm['organizacao'];
        $user->razao_social = $dadosForm['razaoSocial'];
        $user->senha = Hash::make($dadosForm['senha']);
        $user->telefone = $dadosForm['telefone'];
        $user->tipo_pessoa = $dadosForm['tipoCadastro'];
        $user->nome_responsavel = $dadosForm['nomeContato'];
        $user->save();

        return response()->json([
            'status' => true,
            'msg' => 'Solicitação cadastrada com sucesso!',
            'dados' => $dadosForm
        ]);
    }
}