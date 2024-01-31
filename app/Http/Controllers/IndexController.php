<?php

namespace App\Http\Controllers;

use App\Models\OuvidoriaAtendimento;
use App\Models\OuvidoriaMensagem;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IndexController extends Controller
{
    public function atendimentos(Request $request)
    {
        if (!session('usuario')) return redirect('/');
        $atendimentos = OuvidoriaAtendimento::where('id_usuario', session('usuario')->id)->get()->all();
        $user = session('usuario');

        foreach ($atendimentos as $atendimento) {
            $atendimento->tempo_atras = $this->calcularTempoAtras($atendimento->created_at);
        }
        // Retorna a view com os atendimentos e a diferença de tempo
        return view('pages.page-atendimentos', [
            'atendimentos' => $atendimentos,
            'usuario' => $user,
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

        return view('pages.page-atendimento', [
            'atendimento' => $atendimento,
            'mensagens' => $mensagens,
            'user' => $user,
        ]);
    }

    public function protocolo(Request $request, $numero)
    {


        $protocolo = substr($numero, 0, 4) . '.' . substr($numero, 4, 3) . '.' . substr($numero, 7, 3);


        // if (!strlen($numero) == 8) return view('404', ['msg' => 'Página não encontrada']);

        $atendimento = OuvidoriaAtendimento::where('codigo', $protocolo)->get()->first();

        if (!$atendimento) return view('404', ['msg' => 'Página não encontrada']);

        $mensagens = OuvidoriaMensagem::where('id_atendimento', $atendimento->id)->orderBy('id')->get()->all();


        return view('pages.page-atendimento', [
            'atendimento' => $atendimento,
            'mensagens' => $mensagens
        ]);
    }
}
