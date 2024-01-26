<?php

namespace App\Http\Controllers;

use App\Models\Arquivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class IndexArquivo extends Controller
{
    // |> ARQUIVO
    public function index(Request $request, $id, $op = '')
    {
        if (strpos($id, '.') !== false)  $arquivo = Arquivo::where('nome_arquivo', $id)->get()->first();
        else $arquivo = Arquivo::where('arquivo', $id)->get()->first();
        if (!$arquivo) return "<p>Nenhuma arquivo encontrado.</p>";
        if ($arquivo->restrito) {
            // return "<p>Sem permissão para acessar este arquivo!</p>";
        }

        $pasta = $arquivo->pasta ? $arquivo->pasta . '/' : '';
        if ($arquivo->fonte == 'storage') {
            $caminho = ('uploads/' . $pasta . $arquivo->nome_arquivo);

            if (!Storage::exists($caminho))  return '<p style="display: flex;align-items: center;justify-content: center;font-family: \'Arial\';font-weight: 600;height: 300px;">Arquivo não encontrado! :(</p>';

            if ($op == 'base64') {
                $file = Storage::get($caminho);
                return "data:" . $arquivo->mime . ";base64," . base64_encode($file);
            } else {
                $file = Storage::get($caminho);
                $response = Response::make($file, 200);
                $response->header('Content-Type', $arquivo->mime);
                return $response;
            }
        } elseif ($arquivo->fonte == 'public') {
            $caminho = ('uploads/' . $pasta . $arquivo->nome_arquivo);

            if (!File::exists($caminho)) return '<p style="display: flex;align-items: center;justify-content: center;font-family: \'Arial\';font-weight: 600;height: 300px;">Arquivo não encontrado! :(</p>';
            if ($op == 'base64') {
                $file = File::get($caminho);
                return "data:" . $arquivo->mime . ";base64," . base64_encode($file);
            } else {
                $file = File::get($caminho);
                $response = Response::make($file, 200);
                $response->header('Content-Type', $arquivo->mime);
                return $response;
            }
        }
    }
}
