<?php

namespace App\Http\Controllers;

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

        //pegar a aprtir do do array de mensagens a primeira resposta do usuario

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
        if (!count($setado)) $queryAtendimentos = $queryAtendimentos->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));

        $queryRespostas = OuvidoriaMensagem::where('autor', 'camara');
        if (isset($data['ano']) && $data['ano'] != '') $queryRespostas = $queryRespostas->whereYear('created_at', $data['ano']);
        if (isset($data['mes']) && $data['mes'] != '') $queryRespostas = $queryRespostas->whereMonth('created_at', $data['mes']);
        if (isset($data['periodo_inicial']) && $data['periodo_inicial'] != '') $queryRespostas = $queryRespostas->where('created_at', '>=', $data['periodo_inicial']);
        if (isset($data['periodo_final']) && $data['periodo_final'] != '') $queryRespostas = $queryRespostas->where('created_at', '<=', $data['periodo_final']);
        if (!count($setado)) $queryRespostas = $queryRespostas->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));

        $queryUsuarios = OuvidoriaUsuario::where('admin', 0);
        if (isset($data['ano']) && $data['ano'] != '') $queryUsuarios = $queryUsuarios->whereYear('created_at', $data['ano']);
        if (isset($data['mes']) && $data['mes'] != '') $queryUsuarios = $queryUsuarios->whereMonth('created_at', $data['mes']);
        if (isset($data['periodo_inicial']) && $data['periodo_inicial'] != '') $queryUsuarios = $queryUsuarios->where('created_at', '>=', $data['periodo_inicial']);
        if (isset($data['periodo_final']) && $data['periodo_final'] != '') $queryUsuarios = $queryUsuarios->where('created_at', '<=', $data['periodo_final']);
        if (!count($setado)) $queryUsuarios = $queryUsuarios->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'));


        // Filtro por Assunto
        $assuntos = [];
        $assuntosPorcentagem = [];
        $totalAtendimentos = $queryAtendimentos->count();
        foreach ($queryAtendimentos->get()->all() as $atendimento) $assuntos[$atendimento->assunto] = isset($assuntos[$atendimento->assunto]) ? $assuntos[$atendimento->assunto] + 1 : 1;

        if ($totalAtendimentos > 0) {
            $assuntosPorcentagem = [];
            foreach ($assuntos as $assunto => $total) {
                $porcentagem = ($total / $totalAtendimentos) * 100;
                $assuntosPorcentagem[$assunto] = number_format($porcentagem, 1);
            }
        } else {
            $assuntosPorcentagem = [
                'Nenhum cadastrado' => 100,
                'Outros' => '0',
            ];
        }

        //filtrar tipo de manifestação

        if (isset($data['manifestacaoTipo']) && $data['manifestacaoTipo'] != '') {
            //porcentagem de manifestações por tipo
            $queryAtendimentosTotal = $queryAtendimentos->count();
            $queryAtendimentosManifestacaoSelecionado = $queryAtendimentos->where('tipo', $data['manifestacaoTipo'])->count();

            if ($queryAtendimentosTotal > 0) {
                $manifestacoesPorcentagem = $queryAtendimentosManifestacaoSelecionado / $queryAtendimentosTotal * 100;
            }
        }

        //filtro por tipo de manifestação
        $informação = 0;
        $reclamação = 0;
        $sugestão = 0;
        $denúncia = 0;
        $elogio = 0;

        foreach ($queryAtendimentos->get()->all() as $atendimento) {
            if ($atendimento->tipo == 'Informação') $informação++;
            if ($atendimento->tipo == 'Reclamação') $reclamação++;
            if ($atendimento->tipo == 'Sugestão') $sugestão++;
            if ($atendimento->tipo == 'Denúncia') $denúncia++;
            if ($atendimento->tipo == 'Elogio') $elogio++;
        }

        $totalManifestacoes = $informação + $reclamação + $sugestão + $denúncia + $elogio;
        if ($totalManifestacoes > 0) {


            $manifestacoesPorcentagem = [
                'Informação' => number_format(($informação / $totalManifestacoes) * 100, 1),
                'Reclamação' => number_format(($reclamação / $totalManifestacoes) * 100, 1),
                'Sugestão' => number_format(($sugestão / $totalManifestacoes) * 100, 1),
                'Denúncia' => number_format(($denúncia / $totalManifestacoes) * 100, 1),
                'Elogio' => number_format(($elogio / $totalManifestacoes) * 100, 1),
            ];

            //dd($manifestacoesPorcentagem);
        } else {
            $manifestacoesPorcentagem = [
                'Informação' => 0,
                'Reclamação' => 0,
                'Sugestão' => 0,
                'Denúncia' => 0,
                'Elogio' => 0,
                'Nenhum cadastrado' => 1,
            ];
        }

        if (isset($data['genero']) && $data['genero'] != '') {
            $queryUsuarios = $queryUsuarios->where('sexo', $data['genero']);
        }

        if (isset($data['generos']) && $data['generos'] != '') {
            $porcentagemGenero = $queryUsuarios->where('sexo', $data['generos'])->count();
        } else {
            $Masculino = 0;
            $Feminino = 0;
            $NãoInformado = 0;

            foreach ($queryUsuarios->get()->all() as $usuario) {
                if ($usuario->sexo == 'Masculino') $Masculino++;
                if ($usuario->sexo == 'Feminino') $Feminino++;
                if ($usuario->sexo == 'Não Informado') $NãoInformado++;
            }

            $totalGenero = $Masculino + $Feminino + $NãoInformado;
            if ($totalGenero > 0) {
                $porcentagemGenero = [
                    'Masculino' => number_format(($Masculino / $totalGenero) * 100, 1),
                    'Feminino' => number_format(($Feminino / $totalGenero) * 100, 1),
                    'Não Informado' => number_format(($NãoInformado / $totalGenero) * 100, 1),
                ];
            } else {
                $porcentagemGenero = [
                    'Masculino' => 0,
                    'Feminino' => 0,
                    'Não Informado' => 0,
                    'Nenhum cadastrado' => 1,
                ];
            }
        }


        if (isset($data['faixaEtaria']) && $data['faixaEtaria'] != '') {


            $idade18_28 = 0;
            $idade29_38 = 0;
            $idade39_48 = 0;
            $idadeAcimade48 = 0;


            foreach ($queryAtendimentos->get()->all() as $atendimento) {
                $idade = Carbon::parse($atendimento->usuario->data_nascimento)->age;


                if ($idade >= 18 && $idade <= 28) $idade18_28++;
                if ($idade >= 29 && $idade <= 38) $idade29_38++;
                if ($idade >= 39 && $idade <= 48) $idade39_48++;
                if ($idade > 48) $idadeAcimade48++;
            }


            if ($data['faixaEtaria'] == '18-28') {
                $porcentagemIdade = $idade18_28;
            } elseif ($data['faixaEtaria'] == '29-38') {
                $porcentagemIdade = $idade29_38;
            } elseif ($data['faixaEtaria'] == '39-48') {
                $porcentagemIdade = $idade39_48;
            } elseif ($data['faixaEtaria'] == '+ 48') {
                $porcentagemIdade = $idadeAcimade48;
            }
        } else {
            $idade18_28 = 0;
            $idade29_38 = 0;
            $idade39_48 = 0;
            $idadeAcimade48 = 0;
            foreach ($queryAtendimentos->get()->all() as $atendimento) {
                $idade = Carbon::parse($atendimento->usuario->data_nascimento)->age;
                if ($idade >= 18 && $idade <= 28) $idade18_28++;
                if ($idade >= 29 && $idade <= 38) $idade29_38++;
                if ($idade >= 39 && $idade <= 48) $idade39_48++;
                if ($idade > 48) $idadeAcimade48++;
            }

            $totalIdade = $idade18_28 + $idade29_38 + $idade39_48 + $idadeAcimade48;
            if ($totalIdade > 0) {
                $porcentagemIdade = [
                    '18-28' => number_format(($idade18_28 / $totalIdade) * 100, 1),
                    '29-38' => number_format(($idade29_38 / $totalIdade) * 100, 1),
                    '39-48' => number_format(($idade39_48 / $totalIdade) * 100, 1),
                    'Acima de 48' => number_format(($idadeAcimade48 / $totalIdade) * 100, 1),
                ];
            } else {
                $porcentagemIdade = [
                    '18-28' => 0,
                    '29-38' => 0,
                    '39-48' => 0,
                    'Acima de 48' => 0,
                    'Nenhum cadastrado' => 1,
                ];
            }
        }

        // Filtro por classificação

        $totalAvaliacoes = 0;
        $notaTotal = 0;
        // Somar as notas de todas as avaliações
        foreach ($queryAtendimentos->where('situacao', 'Finalizado')->whereNotNull('classificacao')->get()->all() as $atendimento) {
            $totalAvaliacoes++;
            $notaTotal += $atendimento->classificacao;
        }

        // Calcular a média das avaliações
        if ($totalAvaliacoes > 0) {
            $media = $notaTotal / $totalAvaliacoes;
            // Converter a média em porcentagem (supondo que 5 é a classificação máxima)
            $classificacoesPorcentagem = ($media / 5) * 100;
        } else {
            // Caso não haja avaliações, a porcentagem é 0
            $classificacoesPorcentagem = 0;
        }

        //dd(number_format($porcentagem, 1));


        if (isset($data['ano']) && $data['ano'] != '') {
            $anoAtual = $data['ano'];
        } else {
            $anoAtual = date('Y');
        }

        if (isset($data['mes']) && $data['mes'] != '') {
            $mesAtual = $data['mes'];
        } else {
            $mesAtual = number_format(date('m'), 0);
        }

        $mesNome = [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro',
        ];

        $mesNome = $mesNome[$mesAtual];

        if (isset($data['ano']) && $data['ano'] != '') {
            $anoAtual = $data['ano'];
        } else {
            $anoAtual = date('Y');
        }

        //filtrar por atendimento finalizado_em até 30 dias
        if (isset($data['mes']) && $data['mes'] != '') {
            $iniciomes = Carbon::createFromDate($data['ano'], $data['mes'], 1)->startOfMonth();
            $fimmes = Carbon::createFromDate($data['ano'], $data['mes'], 1)->endOfMonth();

            $totalAtendimentos = OuvidoriaAtendimento::where('created_at', '>=', $iniciomes)
                ->where('created_at', '<=', $fimmes)
                ->whereYear('created_at', $anoAtual)
                ->count();

            $atendimentosFinalizados = OuvidoriaAtendimento::where('finalizado_em', '>=', $iniciomes)
                ->where('finalizado_em', '<=', $fimmes)
                ->whereYear('created_at', $anoAtual)
                ->count();

            if ($totalAtendimentos != 0) {
                $porcentagemDentroDoPrazo = ($atendimentosFinalizados / $totalAtendimentos) * 100;
                $porcentagemDentroDoPrazo = number_format($porcentagemDentroDoPrazo, 1);
            } else {
                $porcentagemDentroDoPrazo = 0; // ou outro valor padrão desejado
            }
        } else if (isset($data['periodo_inicial']) && $data['periodo_inicial'] != '' || isset($data['periodo_final']) && $data['periodo_final'] != '') {
            // Se apenas o período inicial estiver definido
            if (isset($data['periodo_inicial']) && $data['periodo_inicial'] != '' && !isset($data['periodo_final'])) {
                $periodo_inicial = Carbon::parse($data['periodo_inicial']);
                $periodo_final = $periodo_inicial->copy()->addDays(30)->endOfDay(); // Adiciona 30 dias ao período inicial
            }
            // Se apenas o período final estiver definido
            else if (!isset($data['periodo_inicial']) && isset($data['periodo_final']) && $data['periodo_final'] != '') {
                $periodo_final = Carbon::parse($data['periodo_final'])->endOfDay();
                $periodo_inicial = $periodo_final->copy()->subDays(30); // Subtrai 30 dias do período final
            }
            // Se ambos os períodos estiverem definidos
            else {
                $periodo_inicial = Carbon::parse($data['periodo_inicial']);
                $periodo_final = Carbon::parse($data['periodo_final'])->endOfDay(); // Define o final do dia
            }

            $totalAtendimentos = OuvidoriaAtendimento::whereBetween('created_at', [$periodo_inicial, $periodo_final])->count();

            $atendimentosFinalizados = OuvidoriaAtendimento::whereBetween('finalizado_em', [$periodo_inicial, $periodo_final])->count();

            if ($totalAtendimentos != 0) {
                $porcentagemDentroDoPrazo = ($atendimentosFinalizados / $totalAtendimentos) * 100;
                $porcentagemDentroDoPrazo = number_format($porcentagemDentroDoPrazo, 1);
            } else {
                $porcentagemDentroDoPrazo = 0; // ou outro valor padrão desejado
            }
        } else {
            $totalAtendimentos = OuvidoriaAtendimento::where('created_at', '>=', Carbon::now()->subDays(30))->count();

            $atendimentosFinalizados = OuvidoriaAtendimento::where('finalizado_em', '>=', Carbon::now()->subDays(30))
                ->where('finalizado_em', '<=', Carbon::now())
                ->count();

            if ($totalAtendimentos != 0) {


                $porcentagemDentroDoPrazo = ($atendimentosFinalizados / $totalAtendimentos) * 100;
                $porcentagemDentroDoPrazo = number_format($porcentagemDentroDoPrazo, 1);
            } else {
                $porcentagemDentroDoPrazo = 0; // ou outro valor padrão desejado
            }
        }

        return view('pages.page-transparencia', [
            'quantidade' => $totalAtendimentos, // OK
            'quantidadeRespostas' => $queryRespostas->count(), // OK
            'porcentagemDentroDoPrazo' => $porcentagemDentroDoPrazo,
            'porcentagemAssunto' => $assuntosPorcentagem, // OK
            'manifestacoesPorcentagem' => $manifestacoesPorcentagem, // OK
            'porcentagemGenero' => $porcentagemGenero, // OK
            'porcentagemIdade' => $porcentagemIdade, //ok
            'idadeAcimade48' => $idadeAcimade48, //ok
            'classificacoesPorcentagem' => $classificacoesPorcentagem, //ok
            'filtro' => $data, //ok
            'ano' => $anoAtual, //ok
            'mesAtual' => $mesNome, //ok
            //'queryAtendimentosManifestacao' => $queryAtendimentosManifestacao, //ok
        ]);
    }
}
