<?php

namespace App\Http\Controllers;

use App\Models\OuvidoriaAtendimento;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IndexController extends Controller
{
    public function atendimentos(Request $request)
    {

        $atendimentos = OuvidoriaAtendimento::where('id_usuario', 1)->get();


        $atendimentos->each(function ($atendimento) {
            $atendimento->tempo_atras = $this->calcularTempoAtras($atendimento->created_at);
        });


        // Retorna a view com os atendimentos e a diferença de tempo
        return view('pages.page-atendimentos', [
            'atendimentos' => $atendimentos,
        ]);
    }

    private function calcularTempoAtras($data)
    {
        $agora = Carbon::now();
        $dataAtendimento = Carbon::parse($data);
        $diferencaEmHoras = $agora->diffInHours($dataAtendimento);

        if ($diferencaEmHoras >= 24) {
            // Se a diferença for maior ou igual a 24 horas, exibe em dias
            $diferencaEmDias = $agora->diffInDays($dataAtendimento);
            return $diferencaEmDias . ' dia(s) atrás';
        }

        return $diferencaEmHoras . ' hora(s) atrás';
    }
}
