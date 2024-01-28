<?php

namespace App\Http\Controllers;

use App\Helper\FileHelper;
use App\Models\OuvidoriaUsuario;
use App\Models\OuvidoriaAtendimento;
use App\Models\OuvidoriaMensagem;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

        session([
            'usuario' => $user
        ]);

        return response()->json([
            'status' => true,
            'msg' => 'Cadastro realizado com sucesso!',
            'dados' => $dadosForm
        ]);
    }

    public function novoAtendimento(Request $request)
    {
        $dadosForm = $request->all();

        $nome_arquivo = null;
        if ($request->file('arquivo')) {
            $FileHelper = new FileHelper;
            $infoAnexoImg = $FileHelper->upload([
                'file' => $request->file('arquivo'),
                'pasta' => 'ouvidoria/arquivos',
                'nome' => 'Arquivo Ouvidoria',
                'observacao' => '',
                'temporario' => false,
                'restrito' => true,
            ]);
            $nome_arquivo = $infoAnexoImg['status'] ? $infoAnexoImg['nome_arquivo'] : null;

            if (!$infoAnexoImg['status']) return ['status' => false, 'msg' => 'Falha no upload do arquivo.', 'retorno' => $infoAnexoImg];
        }

        $ultimoAtendimento = OuvidoriaAtendimento::where('ano', date('Y'))->orderBy('id', 'desc')->first();
        $numero = $ultimoAtendimento ? $ultimoAtendimento->numero + 1 : 1;
        $codigo = preg_replace('/(\d{4})(\d{3})(\d{3})/', '$1.$2.$3', substr(str_pad(time(), 10, '0', STR_PAD_LEFT), -10));

        // CADASTRO DO ATENDIMENTO
        $atendimento = new OuvidoriaAtendimento;

        if ($dadosForm['sigilo'] === 'semSigilo') {
            $atendimento->sigiloso = 0;
        } else {
            $atendimento->sigiloso = 1;
        }

        $atendimento->assunto = $dadosForm['assunto'];
        $atendimento->tipo = $dadosForm['finalidade'];
        $atendimento->situacao = 'Novo';
        $atendimento->data = $dadosForm['data'];
        $atendimento->hora = $dadosForm['hora'];
        $atendimento->endereco = $dadosForm['endereco'];
        $atendimento->numero_referencia = $dadosForm['referencia'];
        $atendimento->ref_atendimento = $dadosForm['codAnterior'];
        $atendimento->ano = date('Y');
        $atendimento->numero = $numero;
        $atendimento->status = 'Aguardando resposta da Câmara';
        $atendimento->codigo = $codigo;
        $atendimento->prioridade = $dadosForm['prioridade'];
        $atendimento->id_usuario = 1;
        $atendimento->save();

        $mensagem = new OuvidoriaMensagem;

        $mensagem->mensagem = $dadosForm['atendimentoUsuario'];
        $mensagem->id_atendimento = $atendimento->id;
        $mensagem->arquivo = $nome_arquivo;
        $mensagem->autor = $dadosForm['autor'];
        $mensagem->save();


        return response()->json(['status' => true, 'msg' => 'Solicitação cadastrada com sucesso!', 'dados' => $dadosForm]);
    }
}
