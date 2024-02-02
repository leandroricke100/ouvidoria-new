<?php

use App\Http\Controllers\OuvidoriaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/OuvidoriaCadastro', [OuvidoriaController::class, 'cadastro']);

Route::post('/OuvidoriaLogin', [OuvidoriaController::class, 'login']);

Route::post('/OuvidoriaVerificarEmail', [OuvidoriaController::class, 'verificarEmail']);

Route::post('/OuvidoriaNovoAtendimento', [OuvidoriaController::class, 'novoAtendimento']);

Route::post('OuvidoriaAtendimento', [OuvidoriaController::class, 'atendimento']);

Route::post('/OuvidoriaBuscarProtocolo', [OuvidoriaController::class, 'codigo']);

Route::post('/OuvidoriaDeleteMensagem', [OuvidoriaController::class, 'deleteMsg']);

Route::post('/OuvidoriaInputAdmin', [OuvidoriaController::class, 'inputAdmin']);

Route::post('/OuvidoriaRecuperarSenha', [OuvidoriaController::class, 'recuperarSenha']);

Route::post('/OuvidoriaNovaSenha', [OuvidoriaController::class, 'salvarNovaSenha']);

Route::post('/OuvidoriaNovoMenu', [OuvidoriaController::class, 'novoMenu']);

Route::post('/OuvidoriaDeleteMenu', [OuvidoriaController::class, 'deleteMenu']);

Route::post('/OuvidoriaEditMenu', [OuvidoriaController::class, 'EditMenu']);