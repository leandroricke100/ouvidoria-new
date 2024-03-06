<?php

namespace App\Http\Controllers;

use App\Models\OuvidoriaAtendimento;
use App\Models\OuvidoriaConfiguracao;
use App\Models\OuvidoriaMensagem;
use App\Models\OuvidoriaUsuario;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function atendimentos(Request $request)
    {
        $user = session('usuario');


        if (!session('usuario')) return redirect('/login');


        if ($user->admin == 1) {
            $atendimentos = OuvidoriaAtendimento::orderBy('created_at', 'desc')->get();
        } else {
            $atendimentos = OuvidoriaAtendimento::where('id_usuario', $user->id)->orderBy('created_at', 'desc')->get();
        }

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

        foreach ($mensagens as $mensagem) {
            $mensagem->tempo_atras = $this->calcularTempoAtras($mensagem->created_at);
        }

        $admin = ($user->admin == 1);
        $titular = ($user->id == $atendimento->id_usuario);

        $permitido = $admin || $titular;

        return view('pages.page-atendimento', [
            'atendimento' => $atendimento,
            'mensagens' => $mensagens,
            'user' => $user,
            'permitir_resposta' => $permitido,
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

        $admin = $user && $user->admin == 1;
        $titular = $user && $user->id == $atendimento->id_usuario;

        $permitido = $admin || $titular;

        return view('pages.page-atendimento', [
            'atendimento' => $atendimento,
            'mensagens' => $mensagens,
            'user' => $user,
            'permitir_resposta' => $permitido,
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

    public function novoAtendimento(Request $request)
    {
        $user = session('usuario');
        if (!session('usuario')) return redirect('/login');

        return view('pages.page-novo-atendimento', [
            'usuario' => $user,
        ]);
    }
    public function transparencia(Request $request)
    {


        // Obter o primeiro e o último dia do mês atual
        $primeiroDiaMesAtual = Carbon::now()->startOfMonth();
        $ultimoDiaMesAtual = Carbon::now()->endOfMonth();

        // Filtrar os atendimentos dentro do intervalo do mês atual
        $quantidadeMesAtual = OuvidoriaAtendimento::whereBetween('created_at', [$primeiroDiaMesAtual, $ultimoDiaMesAtual])->count();

        // Filtrar as mensagens dentro do intervalo do mês atual
        $quantidadeRespostasMesAtual = OuvidoriaMensagem::where('autor', 'camara')
            ->whereBetween('created_at', [$primeiroDiaMesAtual, $ultimoDiaMesAtual])
            ->distinct('id_atendimento')
            ->count('id_atendimento');


        // Calcular a porcentagem de respostas
        $porcentagemDentroDoPrazo = ($quantidadeMesAtual != 0) ? ($quantidadeRespostasMesAtual / $quantidadeMesAtual) * 100 : 0;

        // Limitar a porcentagem a 100%
        $porcentagemDentroDoPrazo = min($porcentagemDentroDoPrazo, 100);


        $assuntos = OuvidoriaAtendimento::select('assunto', DB::raw('count(*) as total'))
            ->groupBy('assunto')
            ->get();

        $totalAtendimentos = OuvidoriaAtendimento::count();

        $porcentagemAssunto = [];

        foreach ($assuntos as $assunto) {
            $porcentagem = ($assunto->total / $totalAtendimentos) * 100;
            $porcentagem = number_format($porcentagem, 1);
            $porcentagemAssunto[$assunto->assunto] = $porcentagem;
        }

        $manifestacao = OuvidoriaAtendimento::select('tipo', DB::raw('count(*) as total'))
            ->groupBy('tipo')
            ->get();

        $porcentagemManifestacao = [];

        foreach ($manifestacao as $tipo) {
            $porcentagem = ($tipo->total / $totalAtendimentos) * 100;
            $porcentagem = number_format($porcentagem, 1);
            $porcentagemManifestacao[$tipo->tipo] = $porcentagem;
        }

        $porcentagemGenero = [
            'Masculino' =>  OuvidoriaUsuario::whereNotNull('sexo')->where('sexo', 'Masculino')->count(),
            'Feminino' => OuvidoriaUsuario::whereNotNull('sexo')->where('sexo', 'Feminino')->count(),
            'Não Informado' => OuvidoriaUsuario::whereNull('sexo')->orWhere('sexo', '')->count(),
        ];

        $totalGenero = OuvidoriaUsuario::count();

        foreach ($porcentagemGenero as $sexo => $contagem) {

            $porcentagem = ($contagem / $totalGenero) * 100;
            $porcentagem = number_format($porcentagem, 1);
            $porcentagemGenero[$sexo] = $porcentagem;
        }




        return view('pages.page-transparencia', [
            'quantidade' => $quantidadeMesAtual,
            'quantidadeRespostas' => $quantidadeRespostasMesAtual,
            'porcentagemDentroDoPrazo' => $porcentagemDentroDoPrazo,
            'porcentagemAssunto' => $porcentagemAssunto,
            'porcentagemManifestacao' => $porcentagemManifestacao,
            'porcentagemGenero' => $porcentagemGenero,
        ]);
    }
}
