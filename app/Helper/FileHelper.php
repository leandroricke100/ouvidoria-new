<?php

namespace App\Helper;

use App\Models\Arquivo;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class FileHelper
{

    public function upload($info)
    {
        $nome_arquivo = uniqid();
        $file = $info['file'];
        $pasta = $info['pasta'];
        $fonte = isset($info['fonte']) ? ($info['fonte'] == 'public' ? $info['fonte'] : 'storage') : 'storage';
        $usuario = session('usuario');

        if (!$file) return ['status' => false, 'msg' => "Arquivo não encontrado, tente novamente..."];

        $extensao = $file->getClientOriginalExtension(); // File extension
        $tamanho = $file->getSize();

        if ($tamanho > 524288000) return ['status' => false, 'msg' => "Tamanho máx. de arquivo permitido é de 500MB."];


        $fonte = 'public';
        // TODO: CORRIGIR ISSO FUTURAMENTE

        if ($fonte == 'storage') {
            $diretorio = Storage::path('uploads/' . $pasta);
            File::isDirectory($diretorio) or File::makeDirectory($diretorio, 0777, true, true);
            $caminho = 'uploads/' . $pasta;
            $nome_arquivo_ext = $nome_arquivo . '.' . $extensao;
            Storage::putFileAs($caminho, $file, $nome_arquivo_ext);
            $mime = Storage::mimeType($caminho . '/' . $nome_arquivo_ext);
        } else {
            $diretorio = public_path() . '/uploads/' . $pasta;
            File::isDirectory($diretorio) or File::makeDirectory($diretorio, 0777, true, true);
            $caminho = 'uploads/' . $pasta;
            $nome_arquivo_ext = $nome_arquivo . '.' . $extensao;
            $file->move($caminho, $nome_arquivo_ext); // Upload file
            $mime = File::mimeType($caminho . '/' . $nome_arquivo_ext);
        }

        $registro = new Arquivo();
        $registro->fonte = $fonte;
        $registro->nome = $info['nome'];
        $registro->pasta = $pasta;
        $registro->arquivo = $nome_arquivo;
        $registro->nome_arquivo = $nome_arquivo_ext;
        $registro->bytes = $tamanho;
        $registro->extensao = $extensao;
        $registro->mime = $mime;
        $registro->observacao = isset($info['observacao']) ? $info['observacao'] : null;
        $registro->temporario = isset($info['temporario']) ? ($info['temporario'] ? ($usuario ? $usuario->id : 0) : 0) : 0;
        $registro->restrito = isset($info['restrito']) ? ($info['restrito'] ? 1 : 0) : 0;
        $registro->created_by = $usuario ? $usuario->id : null;
        $registro->save();

        return [
            'status' => true,
            'msg' => "Upload realizado!",
            'id' => $registro->id,
            'nome_arquivo' => $nome_arquivo_ext,
        ];
    }

    public function delete($nome) {
        $arquivo = Arquivo::where('nome_arquivo', $nome)->orWhere('arquivo', $nome)->first();
        if (!$arquivo) return ['status' => false, 'msg' => "Arquivo não encontrado, tente novamente..."];


        if ($arquivo->fonte == 'storage') {
            Storage::delete('uploads/' . $arquivo->pasta . '/' . $arquivo->nome_arquivo);
        } else {
            File::delete(public_path() . '/uploads/' . $arquivo->pasta . '/' . $arquivo->nome_arquivo);
        }

        $arquivo->delete();

        return ['status' => true, 'msg' => "Arquivo deletado com sucesso!"];
    }
}
