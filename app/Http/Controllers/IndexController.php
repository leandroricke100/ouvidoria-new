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


        //  dd($data);

        if (isset($data['ano']) && $data['ano'] != '') {
            $ano = $data['ano'];
        } else {
            $ano = Carbon::now()->year;
        }

        if (isset($data['mes']) && $data['mes'] != '') {

            if ($data['mes'] == '01') {
                $mesAtual = 'Janeiro/' . $ano;
            } else if ($data['mes'] == '02') {
                $mesAtual = 'Fevereiro/' . $ano;
            } else if ($data['mes'] == '03') {
                $mesAtual = 'Março/' . $ano;
            } else if ($data['mes'] == '04') {
                $mesAtual = 'Abril/' . $ano;
            } else if ($data['mes'] == '05') {
                $mesAtual = 'Maio/' . $ano;
            } else if ($data['mes'] == '06') {
                $mesAtual = 'Junho/' . $ano;
            } else if ($data['mes'] == '07') {
                $mesAtual = 'Julho/' . $ano;
            } else if ($data['mes'] == '08') {
                $mesAtual = 'Agosto/' . $ano;
            } else if ($data['mes'] == '09') {
                $mesAtual = 'Setembro/' . $ano;
            } else if ($data['mes'] == '10') {
                $mesAtual = 'Outubro/' . $ano;
            } else if ($data['mes'] == '11') {
                $mesAtual = 'Novembro/' . $ano;
            } else if ($data['mes'] == '12') {
                $mesAtual = 'Dezembro/' . $ano;
            }
        } else {
            $mesAtual = Carbon::now()->month . '/' . $ano;
        }





        // Obter o primeiro e o último dia do mês atual
        $primeiroDiaMesAtual = Carbon::now()->startOfMonth();
        $ultimoDiaMesAtual = Carbon::now()->endOfMonth();

        if (isset($data['mes']) && $data['mes'] != '') {

            $quantidadeMesAtual = OuvidoriaAtendimento::whereMonth('created_at', $data['mes'])->whereYear('created_at', $ano)->count();

            // Filtrar as mensagens dentro do intervalo do
            $quantidadeRespostasMesAtual = OuvidoriaMensagem::where('autor', 'camara')
                ->whereMonth('created_at', $data['mes'])
                ->whereYear('created_at', $ano)
                ->distinct('id_atendimento')
                ->count('id_atendimento');

            $porcentagemDentroDoPrazo = ($quantidadeMesAtual != 0) ? ($quantidadeRespostasMesAtual / $quantidadeMesAtual) * 100 : 0;

            // Limitar a porcentagem a 100%
            $porcentagemDentroDoPrazo = number_format($porcentagemDentroDoPrazo, 1);
        } else {
            $quantidadeMesAtual = OuvidoriaAtendimento::whereBetween('created_at', [$primeiroDiaMesAtual, $ultimoDiaMesAtual])->count();

            // Filtrar as mensagens dentro do intervalo do
            $quantidadeRespostasMesAtual = OuvidoriaMensagem::where('autor', 'camara')
                ->whereBetween('created_at', [$primeiroDiaMesAtual, $ultimoDiaMesAtual])
                ->distinct('id_atendimento')
                ->count('id_atendimento');


            // Calcular a porcentagem de respostas
            $porcentagemDentroDoPrazo = ($quantidadeMesAtual != 0) ? ($quantidadeRespostasMesAtual / $quantidadeMesAtual) * 100 : 0;

            // Limitar a porcentagem a 100%
            $porcentagemDentroDoPrazo = number_format($porcentagemDentroDoPrazo, 1);
        }

        // Filtrar os atendimentos dentro do intervalo do mês atual



        if (isset($data['mes']) && $data['mes'] != '') {
            // Se um mês foi selecionado, adicione uma condição para filtrar os registros do mês correspondente
            $assuntos = OuvidoriaAtendimento::whereMonth('created_at', $data['mes'])
                ->select('assunto', DB::raw('count(*) as total'))
                ->groupBy('assunto')
                ->get();

            $totalAtendimentos = OuvidoriaAtendimento::count();

            foreach ($assuntos as $assunto) {
                $porcentagem = ($assunto->total / $totalAtendimentos) * 100;
                $porcentagem = number_format($porcentagem, 1);
                $porcentagemAssunto[$assunto->assunto] = $porcentagem;
            }

            //dd($porcentagemAssunto);


        } else {
            // Caso contrário, traga todos os registros
            $assuntos = OuvidoriaAtendimento::select('assunto', DB::raw('count(*) as total'))
                ->groupBy('assunto')
                ->get();
        }

        //dd($assuntos);

        if ($assuntos->isEmpty()) {
            $porcentagemAssunto = [
                'Nenhum Cadastro' => 1,
                'Esgoto' => 0,
                'Limpeza de Terreno baldio' => 0,
                'Postos de Saúde' => 0,
                'Marcação de consulta/procedimento' => 0,
                'Fiscalização de Obras' => 0,
                'Iluminação e Energia' => 0,
                'Criação irregular de animais' => 0,
                'Maus tratos a animais' => 0,
                'Limpeza urbana' => 0,
            ];
        } else {
            $totalAtendimentos = OuvidoriaAtendimento::count();

            $porcentagemAssunto = [
                'Esgoto' => 0,
                'Limpeza de Terreno baldio' => 0,
                'Postos de Saúde' => 0,
                'Marcação de consulta/procedimento' => 0,
                'Fiscalização de Obras' => 0,
                'Iluminação e Energia' => 0,
                'Criação irregular de animais' => 0,
                'Maus tratos a animais' => 0,
                'Limpeza urbana' => 0,
            ];

            foreach ($assuntos as $assunto) {
                $porcentagem = ($assunto->total / $totalAtendimentos) * 100;
                $porcentagem = number_format($porcentagem, 1);
                $porcentagemAssunto[$assunto->assunto] = $porcentagem;
            }

            unset($porcentagemAssunto['Nenhum Cadastro']);
        }


        $porcentagemManifestacao = [];
        if (isset($data['manifestacaoTipo']) && $data['manifestacaoTipo'] != '') {
            $manifestacoes = OuvidoriaAtendimento::where('tipo', $data['manifestacaoTipo'])
                ->select('tipo', DB::raw('count(*) as total'))
                ->groupBy('tipo')
                ->get();



            $totalAtendimentos = OuvidoriaAtendimento::count();

            foreach ($manifestacoes as $tipo) {
                $porcentagem = ($tipo->total / $totalAtendimentos) * 100;
                $porcentagem = number_format($porcentagem, 1);
                $porcentagemManifestacao[$tipo->tipo] = $porcentagem;
            }
        } else {
            $manifestacao = OuvidoriaAtendimento::select('tipo', DB::raw('count(*) as total'))
                ->groupBy('tipo')
                ->get();

            if ($manifestacao->isEmpty()) {
                $porcentagemManifestacao = [
                    'Reclamação' => 0,
                    'Sugestão' => 0,
                    'Elogio' => 0,
                    'Denúncia' => 0,
                    'Solicitação' => 0,
                    'Informação' => 0,
                    'Simplifique' => 0,
                    'Nenhum Cadastro' => 1,
                ];
            } else {
                $porcentagemManifestacao = [];
                $totalAtendimentos = OuvidoriaAtendimento::count();

                if ($totalAtendimentos != 0) {
                    foreach ($manifestacao as $tipo) {
                        $porcentagem = ($tipo->total / $totalAtendimentos) * 100;

                        $porcentagem = number_format($porcentagem, 1);
                        $porcentagemManifestacao[$tipo->tipo] = $porcentagem;
                    }
                } else {
                    // Se o total de atendimentos for zero, defina todas as porcentagens como zero para evitar divisão por zero
                    foreach ($manifestacao as $tipo) {
                        $porcentagemManifestacao[$tipo->tipo] = 0;
                    }
                }
                unset($porcentagemManifestacao['Nenhum Cadastro']);
            }
        }

        //dd($porcentagemManifestacao);


        $porcentagemGenero = [];

        if (isset($data['generos']) && $data['generos'] != '') {
            if (isset($data['mes']) && $data['mes'] != '') {
                $totalGenero = OuvidoriaUsuario::whereMonth('created_at', $data['mes'])
                    ->whereYear('created_at', $ano)
                    ->count();

                $generos = OuvidoriaUsuario::whereMonth('created_at', $data['mes'])
                    ->whereYear('created_at', $ano)
                    ->get();


                foreach ($generos as $genero) {

                    $porcentagem = ($genero->total / $totalGenero) * 100;

                    $porcentagem = number_format($porcentagem, 1);
                    $porcentagemGenero[$genero->sexo] = $porcentagem;
                }


            } else {
                $totalGenero = OuvidoriaUsuario::count();

                $generos = OuvidoriaUsuario::where('sexo', $data['generos'])
                    ->select('sexo', DB::raw('count(*) as total'))
                    ->groupBy('sexo')
                    ->get();

                foreach ($generos as $genero) {
                    $porcentagem = ($genero->total / $totalGenero) * 100;
                    $porcentagem = number_format($porcentagem, 1);
                    $porcentagemGenero[$genero->sexo] = $porcentagem;
                }
            }
        } else {
            $totalGenero = OuvidoriaUsuario::count();


            $generos = OuvidoriaUsuario::select('sexo', DB::raw('count(*) as total'))
                ->groupBy('sexo')
                ->get();

            if ($generos->isEmpty()) {
                $porcentagemGenero = [
                    'Masculino' => 0,
                    'Feminino' => 0,
                    'Nenhum Cadastro' => 1,
                ];
            } else {
                $porcentagemGenero = [];
                if ($totalGenero != 0) {
                    foreach ($generos as $genero) {
                        $porcentagem = ($genero->total / $totalGenero) * 100;
                        $porcentagem = number_format($porcentagem, 1);
                        $porcentagemGenero[$genero->sexo] = $porcentagem;
                    }
                } else {
                    // Se o total de atendimentos for zero, defina todas as porcentagens como zero para evitar divisão por zero
                    foreach ($generos as $genero) {
                        $porcentagemGenero[$genero->sexo] = 0;
                    }
                }
                unset($porcentagemGenero['Nenhum Cadastro']);
            }
        }


        $usuarios = OuvidoriaUsuario::all();

        $idade18_28 = 0;
        $idade29_38 = 0;
        $idade39_48 = 0;
        $idadeNaoInformado = 0;

        foreach ($usuarios as $usuario) {
            $idade = \Carbon\Carbon::parse($usuario->data_nascimento)->age;

            if ($idade >= 18 && $idade <= 28) {
                $idade18_28++;
            } else if ($idade >= 29 && $idade <= 38) {
                $idade29_38++;
            } else if ($idade >= 39 && $idade <= 48) {
                $idade39_48++;
            } else {
                $idadeNaoInformado++;
            }
        }

        $totalUsuarios = $usuarios->count();

        $idade18_28 = ($idade18_28 / $totalUsuarios) * 100;
        $idade29_38 = ($idade29_38 / $totalUsuarios) * 100;
        $idade39_48 = ($idade39_48 / $totalUsuarios) * 100;
        $idadeNaoInformado = ($idadeNaoInformado / $totalUsuarios) * 100;

        $idade18_28 = number_format($idade18_28, 1);
        $idade29_38 = number_format($idade29_38, 1);
        $idade39_48 = number_format($idade39_48, 1);
        $idadeNaoInformado = number_format($idadeNaoInformado, 1);

        $classificacoes = OuvidoriaAtendimento::select('classificacao')->whereNotNull('classificacao')->get()->all();
        $totalAvaliacoes = count($classificacoes);

        $total = 0;
        foreach ($classificacoes as $avaliacao) $total += $avaliacao->classificacao;

        if ($totalAvaliacoes) {
            $resultado = $total / $totalAvaliacoes;
            $resultado = number_format($resultado, 1);
            $porcentagemAvaliacao = $resultado * 20;
        } else {
            $porcentagemAvaliacao = 0;
        }



        return view('pages.page-transparencia', [
            'quantidade' => $quantidadeMesAtual,
            'quantidadeRespostas' => $quantidadeRespostasMesAtual,
            'porcentagemDentroDoPrazo' => $porcentagemDentroDoPrazo,
            'porcentagemAssunto' => $porcentagemAssunto,
            'porcentagemManifestacao' => $porcentagemManifestacao,
            'porcentagemGenero' => $porcentagemGenero,
            'idade18_28' => $idade18_28,
            'idade29_38' => $idade29_38,
            'idade39_48' => $idade39_48,
            'idadeNaoInformado' => $idadeNaoInformado,
            'porcentagemAvaliacao' => $porcentagemAvaliacao,
            'filtro' => $data,
            'ano' => $ano,
            'mesAtual' => $mesAtual,
        ]);
    }
}
