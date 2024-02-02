<?php

namespace App\Http\Controllers;

use App\Models\OuvidoriaAtendimento;
use App\Models\OuvidoriaConfiguracao;
use App\Models\OuvidoriaMensagem;
use App\Models\OuvidoriaUsuario;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IndexController extends Controller
{
    public function atendimentos(Request $request)
    {
        $user = session('usuario');
        if (!$user) return redirect('/');


        if ($user->admin == 1) {
            $atendimentos = OuvidoriaAtendimento::orderBy('created_at', 'desc')->get();
        } else {
            $atendimentos = OuvidoriaAtendimento::where('id_usuario', $user->id)->orderBy('created_at', 'desc')->get();
        }

        $mensagens = OuvidoriaMensagem::where('id_atendimento', $user->id)->orderBy('id')->get()->all();


        foreach ($mensagens as $mensagem) {
            $mensagem->tempo_atras = $this->calcularTempoAtras($mensagem->created_at);
        }

        foreach ($atendimentos as $atendimento) {
            $atendimento->tempo_atras = $this->calcularTempoAtras($atendimento->created_at);
        }

        return view('pages.page-atendimentos', [
            'atendimentos' => $atendimentos,
            'usuario' => $user,
            'mensagens' => $mensagem
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

        if (!session('usuario')) return redirect('/');
        $protocolo = substr($numero, 0, 4) . '.' . substr($numero, 4, 3) . '.' . substr($numero, 7, 3);

        $atendimento = OuvidoriaAtendimento::where('codigo', $protocolo)->first();

        if (!$atendimento) {
            return view('404', ['msg' => 'Página não encontrada']);
        }

        $mensagens = OuvidoriaMensagem::where('id_atendimento', $atendimento->id)->orderBy('id')->get()->all();
        $user = session('usuario');


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

    public function menus(Request $request)
    {
        $user = session('usuario');
        if ($user->admin !== 1) return redirect('/');

        $menus = OuvidoriaConfiguracao::where('id_admin', $user->id)->orderBy('created_at', 'desc')->get();
        foreach ($menus as $menu) {
            $menu->tempo_atras = $this->calcularTempoAtras($menu->created_at);
        }

        return view('pages.page-config', [
            'menus' => $menus,
            'admin' => $user,
        ]);
    }

    public function inicio(Request $request)
    {
        $menus = OuvidoriaConfiguracao::orderBy('created_at', 'desc')->get()->all();

        return view('pages.page-inicio', [
            'menus' => $menus,
        ]);
    }
}