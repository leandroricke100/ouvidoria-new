<?php

use App\Http\Controllers\OuvidoriaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/OuvidoriaCadastro', [OuvidoriaController::class, 'cadastro']);

Route::post('/OuvidoriaNovoAtendimento', [OuvidoriaController::class, 'novoAtendimento']);

Route::post('OuvidoriaAtendimento', [OuvidoriaController::class, 'atendimento']);

Route::post('/OuvidoriaAtendimentoAdmin', [OuvidoriaController::class, 'mensagemAdmin']);

Route::post('/OuvidoriaDeleteMensagem', [OuvidoriaController::class, 'deleteMsg']);
