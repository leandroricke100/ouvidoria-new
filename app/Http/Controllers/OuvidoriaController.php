<?php

namespace App\Http\Controllers;

use App\Helper\FileHelper;
use App\Models\OuvidoriaUsuario;
use App\Models\OuvidoriaAtendimento;
use App\Models\OuvidoriaConfiguracao;
use App\Models\OuvidoriaMensagem;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class OuvidoriaController extends Controller
{
    public function cadastro(Request $request)
    {
        $dadosForm = $request->all();

        // return response()->json([
        //     'status' => false,
        //     'msg' => 'aa',
        //     'dados' => $dadosForm
        // ]);

        $user = new OuvidoriaUsuario;



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
        $user->profissao = $dadosForm['profissao'];
        $user->email_alternativo = $dadosForm['emailAlternativo'];
        $user->endereco = $dadosForm['endereco'];
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

        // return response()->json([
        //     'status' => true,
        //     'msg' => 'Solicitação cadastrada com sucesso!',
        //     'dados' => $dadosForm,
        // ]);


        if (!session('usuario')) return redirect('/');

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

        // if ($dadosForm['sigilo'] === 'semSigilo') {
        //     $atendimento->sigiloso = 0;
        // } else {
        //     $atendimento->sigiloso = 1;
        // }


        if ($dadosForm['assunto'] == 'Outros') {
            $atendimento->assunto = $dadosForm['assuntoDesejado'];
        } else {
            $atendimento->assunto = $dadosForm['assunto'];
        }

        $atendimento->sigiloso = $dadosForm['sigilo'];
        // $atendimento->assunto = $dadosForm['assunto'];
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
        $atendimento->id_usuario = session('usuario')->id;
        $atendimento->save();

        $mensagem = new OuvidoriaMensagem;

        $mensagem->mensagem = $dadosForm['atendimentoUsuario'];
        $mensagem->id_atendimento = $atendimento->id;
        $mensagem->arquivo = $nome_arquivo;
        $mensagem->autor = $dadosForm['autor'];
        $mensagem->save();


        return response()->json([
            'status' => true,
            'msg' => 'Solicitação cadastrada com sucesso!',
            'dados' => $dadosForm,
            'usuario' => session('usuario'),
        ]);
    }

    public function atendimento(Request $request)
{
    $dadosForm = $request->all();
    if (!session('usuario')) return redirect('/');

    if (!$dadosForm['atendimentoUsuario']) return ['status' => false, 'msg' => 'Nenhuma mensagem enviada'];

    $nome_arquivo = null;
    if ($request->hasFile('arquivo')) {
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

    $respostaUser = new OuvidoriaMensagem;
    $respostaUser->id_atendimento = $dadosForm['id_atendimento'];
    $respostaUser->autor = $dadosForm['autor'];
    $respostaUser->mensagem = $dadosForm['atendimentoUsuario'];
    $respostaUser->arquivo = $nome_arquivo;
    $respostaUser->save();


    $countMensagens = OuvidoriaMensagem::where('id_atendimento', $dadosForm['id_atendimento'])->count();
    $primeiraRespostaCamara = $countMensagens >= 2 && $dadosForm['autor'] === 'Camara';

    // Se for a primeira resposta e for da Câmara, atualize a situação do atendimento para "Andamento"
    if ($primeiraRespostaCamara) {
        $atendimento = OuvidoriaAtendimento::find($dadosForm['id_atendimento']);
        if ($atendimento) {
            $atendimento->situacao = 'Andamento';
            $atendimento->save();
        }
    }

    return response()->json([
        'status' => true,
        'msg' => 'Nova mensagem enviada com sucesso!',
        'dados' => $dadosForm,
        'primeiraRespostaCamara' => $primeiraRespostaCamara,
    ]);
}


    public function login(Request $request)
    {
        $dados = $request->only(['metodo', 'email', 'cpfCnpj', 'senha']);
        $metodo = $dados['metodo'];

        if ($metodo == 'login') {
            $user = OuvidoriaUsuario::where(function ($query) use ($dados) {
                $query->where('email', $dados['email'] ?? '0')
                    ->orWhere('cpf', $dados['cpfCnpj'] ?? '0')
                    ->orWhere('cnpj', $dados['cpfCnpj'] ?? '0');
            })
                ->first();


            if (!$user || !Hash::check($dados['senha'], $user->senha)) {
                return response()->json(['status' => false, 'msg' => 'Não foi possível fazer login. Verifique suas credenciais.']);
            }

            session(['usuario' => $user]);

            return response()->json([
                'status' => true,
                'msg' => 'Logado com sucesso!',
                // 'dados' => $dados,
                'usuario' => $user,
            ]);
        } elseif ($metodo == 'sair') {
            // DESLOGAR
            session()->invalidate();

            return response()->json([
                'status' => true,
                'msg' => 'Deslogado'
            ]);
        }

        return response()->json(['status' => false, 'msg' => 'Método inválido.']);
    }

    public function verificarEmail(Request $request)
    {
        $dados = $request->all();

        $user = OuvidoriaUsuario::where('email', $dados['email'])->first();
        $user = !$user && $dados['cpfCnpj'] ? OuvidoriaUsuario::where('cpf', $dados['cpfCnpj'])->first() : $user;
        $user = !$user && $dados['cpfCnpj'] ? OuvidoriaUsuario::where('cnpj', $dados['cpfCnpj'])->first() : $user;

        if (!$user) {
            return response()->json([
                'status' => false,
                'msg' => 'Não existe conta com esses dados.'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'msg' => 'Dados encontrado.',
                'dados' => $dados
            ]);
        }
    }

    public function codigo(Request $request)
    {
        $dados = $request->all();
        $protocolo = OuvidoriaAtendimento::where('codigo', $dados['protocolo'])->get()->first();

        if (!$protocolo) return response()->json(['status' => false, 'msg' => 'Não foi encontrado nenhum protocolo com esses dados.']);

        $numFormat = str_replace('.', '', $dados['protocolo']);

        $link = route('usuario-protocolo', ['numero' => $numFormat]);

        return response()->json([
            'status' => true,
            'msg' => 'Protocolo encontrado.',
            'dados' => $protocolo,
            'link' => $link
        ]);
    }

    public function deleteMsg(Request $request)
    {
        $dadosForm = $request->all();

        $mensagem = OuvidoriaMensagem::find($dadosForm['id']);

        if ($mensagem) {
            $mensagem->delete();

            return response()->json([
                'status' => true,
                'msg' => 'Mensagem deletada.',
                'dados' => $dadosForm
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'Mensagem não encontrada!',
            ]);
        }
    }

    public function inputAdmin(Request $request)
    {

        $dadosForm = $request->all();

        $atendimento = OuvidoriaAtendimento::find($dadosForm['id']);
        $atendimento->situacao = $dadosForm['situacao'];

        $atendimento->save();


        return response()->json([
            'status' => true,
            'msg' => 'Valor trocado.',
            'dados' => $dadosForm
        ]);
    }

    public function recuperarSenha(Request $request)
    {
        $dados = $request->all();

        $user = OuvidoriaUsuario::where('email', $dados['email'])->get()->first();

        if (!$user) {
            return response()->json(['status' => false, 'msg' => 'Dados inválidos.']);
        } else {
            $token = rand(1000, 9999);
            mail($dados['email'], 'Recuperação de Senha', 'Seu token para alterar sua senha é:<br>' . $token);

            $user->token_senha = $token;
            $user->save();
        }

        return response()->json([
            'status' => true,
            'msg' => 'Verifique seu email para obter o código de alteração da sua senha.',
            'dados' => $dados
        ]);
    }

    public function salvarNovaSenha(Request $request)
    {
        $dados = $request->all();

        $user = OuvidoriaUsuario::where('email', $dados['email'])->get()->first();

        if (!$user || $dados['senha'] != $dados['confirmarSenha'] || $dados['token'] != $user['token_senha'] || !$dados['senha']) {
            return response()->json(['status' => false, 'msg' => 'Dados inválidos do token ou senha']);
        } else {

            $user->senha = Hash::make($dados['senha']);
            $user->save();

            return response()->json([
                'status' => true,
                'msg' => 'Nova senha cadastrada com sucesso.',
                'dados' => $dados
            ]);
        }
    }

    public function EditAccountAdmin(Request $request)
    {
        $dadosForm = $request->all();

        $usuario = OuvidoriaUsuario::where('id', $dadosForm['conta'])->get()->first();

        if ($usuario) {
            return response()->json([
                'status' => true,
                'msg' => 'Conta encontrado.',
                'menu' => $usuario
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'Não foi possível encontrar a conta.',
            ]);
        }
    }

    public function EditAccountUser(Request $request)
    {
        $dadosForm = $request->all();

        return response()->json([
            'status' => true,
            'msg' => 'Conta encontrado.',
            'menu' => $dadosForm
        ]);
    }

    public function EditCadAtualizado(Request $request)
    {
        $dadosForm = $request->all();

        $userUpdate = OuvidoriaUsuario::find($dadosForm['id_usuario']);

        if (!$userUpdate) {
            return response()->json([
                'status' => false,
                'msg' => 'Usuário não encontrado.',
            ]);
        }


        if (isset($dadosForm['senha'])) {
            $userUpdate->senha = Hash::make($dadosForm['senha']);

            if ($dadosForm['senha'] != $dadosForm['confirmarSenha']) {
                return response()->json([
                    'status' => false,
                    'msg' => 'Senhas não conferem.',
                ]);
            }
        }

        $userUpdate->profissao = $dadosForm['profissao'] ?? null;
        $userUpdate->sexo = $dadosForm['sexo'] ?? null;
        $userUpdate->area_atuacao = $dadosForm['areaAtuacao'] ?? null;
        $userUpdate->bairro = $dadosForm['bairro'] ?? null;
        $userUpdate->celular = $dadosForm['celular'] ?? null;
        $userUpdate->cep = isset($dadosForm['cep']) ? intval($dadosForm['cep']) : null;
        $userUpdate->cidade = $dadosForm['cidade'] ?? null;
        $userUpdate->cnpj = $dadosForm['cnpj'] ?? null;
        $userUpdate->complemento = $dadosForm['complemento'] ?? null;
        $userUpdate->cpf = $dadosForm['cpf'] ?? null;
        $userUpdate->data_nascimento = $dadosForm['dataNascimento'] ?? null;
        $userUpdate->email = $dadosForm['email'] ?? null;
        $userUpdate->email_alternativo = $dadosForm['emailAlternativo'] ?? null;
        $userUpdate->endereco = $dadosForm['endereco'] ?? null;
        $userUpdate->nome_completo = $dadosForm['nomeCompleto'] ?? null;
        $userUpdate->contato_principal = $dadosForm['nomeContato'] ?? null;
        $userUpdate->nome_fantasia = $dadosForm['nomeFantasia'] ?? null;
        $userUpdate->organizacao = $dadosForm['organizacao'] ?? null;
        $userUpdate->razao_social = $dadosForm['razaoSocial'] ?? null;
        $userUpdate->telefone = $dadosForm['telefone'] ?? null;
        $userUpdate->tipo_pessoa = $dadosForm['tipoCadastro'] ?? null;
        $userUpdate->nome_responsavel = $dadosForm['nomeContato'] ?? null;
        $userUpdate->save();

        return response()->json([
            'status' => true,
            'msg' => 'Dados do usuário atualiados com sucesso.',
            'dados' => $dadosForm
        ]);
    }

    public function EditInformacao(Request $request)
    {
        $dadosForm = $request->all();

        $updateEndereco = OuvidoriaConfiguracao::find($dadosForm['idEndereco']);

        return response()->json([
            'status' => true,
            'msg' => 'Conta encontrado.',
            'endereco' => $updateEndereco
        ]);
    }


    public function EditInfoAtualizado(Request $request)
    {
        $dadosForm = $request->all();
        $enderecoAtualizado = OuvidoriaConfiguracao::find(1);


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

            if ($infoAnexoImg['status']) {
                // deletar antigo
                $FileHelper->delete($enderecoAtualizado->arquivo);
                $enderecoAtualizado->arquivo = $nome_arquivo;
            }
        }


        $enderecoAtualizado->informacoes = $dadosForm['enderecoCompleto'] ?? null;
        $enderecoAtualizado->titulo = $dadosForm['nomeMunicipio'] ?? null;
        $enderecoAtualizado->save();

        return response()->json([
            'status' => true,
            'msg' => 'Informações Atualizada.',
            'endereco' => $dadosForm,
        ]);
    }

    public function Classsicacao(Request $request)
    {
        $dados = $request->all();

        $atendimento = OuvidoriaAtendimento::find($dados['id_atendimento']);

        if (!$atendimento) {
            return response()->json([
                'status' => false,
                'msg' => 'Atendimento não encontrado.',
            ]);
        }

        if ($dados['permitido'] != 1) {
            return response()->json([
                'status' => false,
                'msg' => 'Você não tem permissão para classificar esse atendimento.',
            ]);
        }

        $atendimento->classificacao = $dados['classificacao'];
        $atendimento->save();

        return response()->json([
            'status' => true,
            'msg' => 'Avaliação Enviada.',
            'dados' => $dados,
        ]);
    }
}
