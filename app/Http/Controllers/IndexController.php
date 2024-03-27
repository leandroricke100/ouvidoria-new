<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\OuvidoriaAtendimento;
use App\Models\OuvidoriaConfiguracao;
use App\Models\OuvidoriaMensagem;
use App\Models\OuvidoriaUsuario;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    public function atendimentos(Request $request)
    {
        $user = session('usuario');


        $data = $request->all();

        if (!session('usuario')) return redirect('/login');


        if ($user->admin == 1) {
            $query = OuvidoriaAtendimento::orderBy('created_at', 'desc');
        } else {
            $query = OuvidoriaAtendimento::where('id_usuario', $user->id)->orderBy('created_at', 'desc');
        }

        // Filtros
        if (isset($data['sigiloso']) && $data['sigiloso'] != '') $query = $query->where('sigiloso', $data['sigiloso']);

        if (isset($data['mes']) && $data['mes'] != '') {
            $query->where(DB::raw('MONTH(created_at)'), $data['mes']);
        }

        if (isset($data['ano']) && $data['ano'] != '') {
            $query->where(DB::raw('YEAR(created_at)'), $data['ano']);
        }

        if (isset($data['situacao']) && $data['situacao'] != '') {
            $query->where('situacao', $data['situacao']);
        }

        if (isset($data['prioridade']) && $data['prioridade'] != '') {
            $query->where('prioridade', $data['prioridade']);
        }

        // Palavra Chave
        if (isset($data['palavra_chave']) && $data['palavra_chave'] != '') {
            $query = $query->where(function ($query) use ($data) {
                $query->where('assunto', 'like', '%' . $data['palavra_chave'] . '%');
            });
        }

        if (isset($data['periodo_inicial']) && $data['periodo_inicial'] != '') {
            $query->where('created_at', '>=', $data['periodo_inicial']);
        }

        if (isset($data['periodo_final']) && $data['periodo_final'] != '') {
            $query->where('created_at', '<=', $data['periodo_final']);
        }

        // Resultados

        $atendimentos = $query->get()->all();


        $mensagens = OuvidoriaMensagem::where('id_atendimento', $user->id)->orderBy('id')->get()->all();

        foreach ($mensagens as $mensagem) {
            $mensagem->tempo_atras = $this->calcularTempoAtras($mensagem->created_at);
        }

        $atendimentosAberto = 0;
        $atendimentosArquivado = 0;

        foreach ($atendimentos as $atendimento) {
            $atendimento->tempo_atras = $this->calcularTempoAtras($atendimento->created_at);

            if ($atendimento->situacao !== 'Finalizado') {
                $atendimentosAberto++;
            } else {
                $atendimentosArquivado++;
            }
        }

        return view('pages.page-atendimentos', [
            'atendimentos' => $atendimentos,
            'mensagens' => $mensagens,
            'atendimentosAberto' => $atendimentosAberto,
            'atendimentosArquivado' => $atendimentosArquivado,
            'filtro' => $data,
            'user' => $user,

        ]);
    }

    public function calcularTempoAtras($data)
    {



        $agora = Carbon::now();
        $dataAtendimento = Carbon::parse($data);
        $diferencaEmHoras = $agora->diffInHours($dataAtendimento);
        $diferencaEmMinutos = $agora->diffInMinutes($dataAtendimento);

        if ($diferencaEmMinutos < 60) {
            // Se a diferença for menor que 1 hora, exibe em minutos
            return $diferencaEmMinutos . ' minuto(s) atrás';
        } elseif ($diferencaEmMinutos < 1440) {
            // Se a diferença for menor que 24 horas, exibe em horas
            $diferencaEmHoras = $agora->diffInHours($dataAtendimento);
            return $diferencaEmHoras . ' hora(s) atrás';
        } else {
            // Se a diferença for maior ou igual a 24 horas, exibe em dias
            $diferencaEmDias = $agora->diffInDays($dataAtendimento);
            return $diferencaEmDias . ' dia(s) atrás';
        }
    }

    public function atendimento(Request $request, $id)
    {

        if (!session('usuario')) return redirect('/');

        $atendimento = OuvidoriaAtendimento::find($id);
        $mensagens = OuvidoriaMensagem::where('id_atendimento', $id)->orderBy('id')->get()->all();
        $user = session('usuario');

        $atendimento = OuvidoriaAtendimento::find($id);

        if ($atendimento->ref_atendimento != null) {
            $AtendimentoAnterior = $atendimento->ref_atendimento;
        } else {
            $AtendimentoAnterior = null;
        }

        if ($user->id == $atendimento->id_usuario) {
            $abrirAtendimento = true;
        } else {
            $abrirAtendimento = false;
        }



        if (!$atendimento) {
            return view('404', ['msg' => 'Página não encontrada']);
        }

        $primeiraRespostaCamara = OuvidoriaMensagem::where('id_atendimento', $atendimento->id)->where('autor', 'Camara')->count() >= 1;

        foreach ($mensagens as $mensagem) {
            $agora = Carbon::now();
            $dataAtendimento = Carbon::parse($mensagem->created_at);

            $diferencaEmMinutos = $agora->diffInMinutes($dataAtendimento);;

            if ($diferencaEmMinutos <= 10) {
                $mensagem->permitidoDelete = true;
            } else {
                $mensagem->permitidoDelete = false;
            }

            $mensagem->tempo_atras = $this->calcularTempoAtras($mensagem->created_at);
        }

        $userReclamanteId = $atendimento->id_usuario;

        $userReclamante = OuvidoriaUsuario::find($userReclamanteId);



        $admin = ($user->admin == 1);
        $titular = ($user->id == $atendimento->id_usuario);


        $avaliacao = $atendimento->classificacao;

        $permitir_resposta = $admin || $titular;

        $numFormat = str_replace('.', '', $atendimento->codigo);
        $link = route('usuario-protocolo', ['numero' => $numFormat]);

        //contar quantos dias se passaram desde a abertura do atendimento

        $dataAbertura = Carbon::parse($atendimento->created_at);
        $dataAtual = Carbon::now();

        $diferencaEmDias = $dataAbertura->diffInDays($dataAtual);
        $dataRestante = 30 - $diferencaEmDias;


        //se usuario ja avaliou o atendimento

        $avaliacaoEnviada = $atendimento->classificacao;

        $avaliacaoEnviada ? $avaliacaoEnviada = true : $avaliacaoEnviada = false;

        $dono = $user && $user->id ==  $atendimento->id_usuario;


        return view('pages.page-atendimento', [
            'atendimento' => $atendimento,
            'mensagens' => $mensagens,
            'user' => $user,
            'permitir_resposta' => $permitir_resposta,
            'titular' => $titular,
            'avaliacao' => $avaliacao,
            'link' => $link,
            'primeiraRespostaCamara' => $primeiraRespostaCamara,
            'userReclamante' => $userReclamante,
            'por_codigo' => true,
            'AtendimentoAnterior' => $AtendimentoAnterior,
            'abrirAtendimento' => $abrirAtendimento,
            'dataRestante' => $dataRestante,
            'avaliacaoEnviada' => $avaliacaoEnviada,
            'dono' => $dono,
        ]);
    }

    public function protocolo(Request $request, $numero)
    {

        // if (!session('usuario')) return redirect('/');
        $protocolo = substr($numero, 0, 4) . '.' . substr($numero, 4, 3) . '.' . substr($numero, 7, 3);

        $atendimento = OuvidoriaAtendimento::where('codigo', $protocolo)->first();

        if (!$atendimento) {
            return view('404', ['msg' => 'Página não encontrada']);
        }

        $mensagens = OuvidoriaMensagem::where('id_atendimento', $atendimento->id)->orderBy('id')->get()->all();
        $user = session('usuario');

        if (isset($user) && $user->id == $atendimento->id_usuario) {
            $abrirAtendimento = true;
        } else {
            $abrirAtendimento = false;
        }

        $admin = $user && $user->admin == 1;
        $titular = $user && $user->id == $atendimento->id_usuario;

        $avaliacao = $atendimento->classificacao;

        $permitir_resposta = $admin || $titular;

        $numFormat = str_replace('.', '', $atendimento->codigo);
        $link = route('usuario-protocolo', ['numero' => $numFormat]);

        $primeiraRespostaCamara = OuvidoriaMensagem::where('id_atendimento', $atendimento->id)->where('autor', 'Camara')->count() >= 1;


        return view('pages.page-atendimento', [
            'atendimento' => $atendimento,
            'mensagens' => $mensagens,
            'user' => $user,
            'permitir_resposta' => $permitir_resposta,
            'avaliacao' => $avaliacao,
            'link' => $link,
            'userReclamante' => OuvidoriaUsuario::find($atendimento->id_usuario),
            'primeiraRespostaCamara' => $primeiraRespostaCamara,
            'por_codigo' => false,
            'abrirAtendimento' => $abrirAtendimento,
        ]);
    }

    public function menus(Request $request)
    {
        $user = session('usuario');
        if (!$user) return redirect('/');

        // $menus = OuvidoriaConfiguracao::where('id_admin', $user->id)->orderBy('created_at', 'desc')->get();
        // foreach ($menus as $menu) {
        //     $menu->tempo_atras = $this->calcularTempoAtras($menu->created_at);
        // }

        return view('pages.page-config', [
            'menus' => null,
            'usuario' => $user,
        ]);
    }

    public function inicio(Request $request)
    {
        $menus = OuvidoriaConfiguracao::orderBy('created_at', 'desc')->get()->all();

        return view('pages.page-inicio', [
            'menus' => $menus,
        ]);
    }

    public function novoAtendimento(Request $request, $codigo_ref = null)
    {
        $user = session('usuario');
        if (!$user) return redirect('/login');



        return view('pages.page-novo-atendimento', [
            'usuario' => $user,
            'codigo_ref' => $codigo_ref,
        ]);
    }


    public function transparencia(Request $request)
    {

        $data = $request->all();

        $setado = [];
        if (isset($data['ano']) && $data['ano'] != '') $setado[] = 'ano';
        if (isset($data['mes']) && $data['mes'] != '') $setado[] = 'mes';
        if (isset($data['periodo_inicial']) && $data['periodo_inicial'] != '') $setado[] = 'periodo_inicial';
        if (isset($data['periodo_final']) && $data['periodo_final'] != '') $setado[] = 'periodo_final';

        $queryAtendimentos = new OuvidoriaAtendimento;
        if (isset($data['ano']) && $data['ano'] != '') $queryAtendimentos = $queryAtendimentos->whereYear('created_at', $data['ano']);
        if (isset($data['mes']) && $data['mes'] != '') $queryAtendimentos = $queryAtendimentos->whereMonth('created_at', $data['mes']);
        if (isset($data['periodo_inicial']) && $data['periodo_inicial'] != '') $queryAtendimentos = $queryAtendimentos->where('created_at', '>=', $data['periodo_inicial']);
        if (isset($data['periodo_final']) && $data['periodo_final'] != '') $queryAtendimentos = $queryAtendimentos->where('created_at', '<=', $data['periodo_final']);
        if (isset($data['manifestacaoTipo']) && $data['manifestacaoTipo'] != '') $queryAtendimentos = $queryAtendimentos->where('tipo', $data['manifestacaoTipo']);
        if (isset($data['genero']) && $data['genero'] != '') $queryAtendimentos = $queryAtendimentos->whereHas('usuario', function ($query) use ($data) {
            $query->where('sexo', $data['genero']);
        });
        if (isset($data['faixaEtaria']) && $data['faixaEtaria'] != '') {
            if (strpos($data['faixaEtaria'], '-') !== false) {
                $faixaEtaria = explode('-', $data['faixaEtaria']);
                $anoNascMax = date('Y') - (preg_replace('/\D/', '', $faixaEtaria[0])); // 2024 - 18 = 2006
                $anoNascMin = date('Y') - (preg_replace('/\D/', '', $faixaEtaria[1])); // 2024 - 28 = 1996
            } else {
                $anoNascMin = 0;
                $anoNascMax = date('Y') - (preg_replace('/\D/', '', $data['faixaEtaria']));
            }

            $queryAtendimentos = $queryAtendimentos->whereHas('usuario', function ($query) use ($data, $anoNascMin, $anoNascMax) {
                $query->whereYear('data_nascimento', '>=', $anoNascMin)->whereYear('data_nascimento', '<=', $anoNascMax);
            });
        }
        if (!count($setado)) $queryAtendimentos = $queryAtendimentos->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));

        // Filtro por Assunto
        $assuntosPorcentagem = [];
        foreach ($queryAtendimentos->get()->all() as $atendimento) $assuntosPorcentagem[$atendimento->assunto] = isset($assuntosPorcentagem[$atendimento->assunto]) ? $assuntosPorcentagem[$atendimento->assunto] + 1 : 1;
        foreach ($assuntosPorcentagem as $assunto => $total) $assuntosPorcentagem[$assunto] = number_format(($total / $queryAtendimentos->count()) * 100, 1);
        if (!$queryAtendimentos->count()) $assuntosPorcentagem['Nenhum cadastrado'] = 100;

        // Filtro por tipo de manifestação
        $manifestacoesPorcentagem = [];
        foreach ($queryAtendimentos->get()->all() as $atendimento) $manifestacoesPorcentagem[$atendimento->tipo] = isset($manifestacoesPorcentagem[$atendimento->tipo]) ? $manifestacoesPorcentagem[$atendimento->tipo] + 1 : 1;
        if (!isset($data['manifestacaoTipo'])) foreach ($manifestacoesPorcentagem as $tipo => $total) $manifestacoesPorcentagem[$tipo] = $queryAtendimentos->count() ? number_format(($total / $queryAtendimentos->count()) * 100, 1) : $manifestacoesPorcentagem[$tipo];
        if (!$queryAtendimentos->count()) $manifestacoesPorcentagem['Nenhum cadastrado'] = 1;

        //dd($manifestacoesPorcentagem);

        // Filtro por gênero
        $porcentagemGenero = [];
        foreach ($queryAtendimentos->get()->all() as $atendimento) $porcentagemGenero[$atendimento->usuario->sexo] = isset($porcentagemGenero[$atendimento->usuario->sexo]) ? $porcentagemGenero[$atendimento->usuario->sexo] + 1 : 1;
        foreach ($porcentagemGenero as $genero => $total) $porcentagemGenero[$genero] = $queryAtendimentos->count() ? number_format(($total / $queryAtendimentos->count()) * 100, 1) : $porcentagemGenero[$genero];
        if (!$queryAtendimentos->count()) $porcentagemGenero['Nenhum cadastrado'] = 1;
        if (isset($data['genero'])) $porcentagemGenero = $porcentagemGenero[$data['genero']] ?? 0;


        // Filtro por faixa etária
        $porcentagemIdade = ['18-28' => 0, '29-38' => 0,  '39-48' => 0, 'Acima de 48' => 0];
        foreach ($queryAtendimentos->get()->all() as $atendimento) {
            $idade = Carbon::parse($atendimento->usuario->data_nascimento)->age;
            if ($idade >= 18 && $idade <= 28) $porcentagemIdade['18-28'] = isset($porcentagemIdade['18-28']) ? $porcentagemIdade['18-28'] + 1 : 1;
            if ($idade >= 29 && $idade <= 38) $porcentagemIdade['29-38'] = isset($porcentagemIdade['29-38']) ? $porcentagemIdade['29-38'] + 1 : 1;
            if ($idade >= 39 && $idade <= 48) $porcentagemIdade['39-48'] = isset($porcentagemIdade['39-48']) ? $porcentagemIdade['39-48'] + 1 : 1;
            if ($idade > 48) $porcentagemIdade['Acima de 48'] = isset($porcentagemIdade['Acima de 48']) ? $porcentagemIdade['Acima de 48'] + 1 : 1;
        }
        if (!isset($data['faixaEtaria'])) foreach ($porcentagemIdade as $faixa => $total) $porcentagemIdade[$faixa] = $queryAtendimentos->count() ? number_format(($total / $queryAtendimentos->count()) * 100, 1) : $porcentagemIdade[$faixa];
        if (!$queryAtendimentos->count()) $porcentagemIdade['Nenhum cadastrado'] = 1;

        //dd($porcentagemIdade);

        // Respostas
        $qtdRespondidos = 0;
        foreach ($queryAtendimentos->get()->all() as $atendimento) if ($atendimento->mensagens->where('autor', 'Camara')->count() > 0) $qtdRespondidos++;

        // Dentro do Prazo
        $porcentagemDentroDoPrazo = 0;
        foreach ($queryAtendimentos->get()->all() as $atendimento) {
            if ($atendimento->situacao != 'Finalizado') continue;
            $diferenca = Carbon::parse($atendimento->created_at)->diffInDays(Carbon::parse($atendimento->finalizado_em));
            if ($diferenca <= 30) $porcentagemDentroDoPrazo++;
        }
        $porcentagemDentroDoPrazo = $queryAtendimentos->count() ? number_format(($porcentagemDentroDoPrazo / $queryAtendimentos->count()) * 100, 1) : 0;


        // Filtro por classificação
        $quantidadeClassificao = 0;
        $quantidadeAtendimento = 0;
        foreach ($queryAtendimentos->get()->all() as $atendimento) {
            if ($atendimento->situacao == 'Finalizado' && $atendimento->classificacao != null) {
                $quantidadeAtendimento++;
                $quantidadeClassificao += $atendimento->classificacao;
            }
        }

        $classificacoesPorcentagem = $quantidadeAtendimento ? number_format(($quantidadeClassificao / $quantidadeAtendimento) * 20, 1) : 0;


        //dd($manifestacoesPorcentagem);


        return view('pages.page-transparencia', [
            'quantidade' => $queryAtendimentos->count(), // OK
            'quantidadeRespostas' => $qtdRespondidos, // OK
            'porcentagemDentroDoPrazo' => $porcentagemDentroDoPrazo,
            'porcentagemAssunto' => $assuntosPorcentagem, // OK
            'manifestacoesPorcentagem' => $manifestacoesPorcentagem, // OK
            'porcentagemGenero' => $porcentagemGenero, // OK
            'porcentagemIdade' => $porcentagemIdade, //ok
            'classificacoesPorcentagem' => $classificacoesPorcentagem, //ok
            'filtro' => $data, //ok
            'ano' => isset($data['ano']) ? $data['ano'] : date('Y'), //ok
            'mesAtual' => isset($data['mes']) ? Helper::obterNomeMes($data['mes']) : Helper::obterNomeMes(ltrim(date('m'), '0')), //ok
            //'queryAtendimentosManifestacao' => $queryAtendimentosManifestacao, //ok
        ]);
    }
}
