<?php

use App\Http\Controllers\IndexController;
use App\Http\Controllers\IndexArquivo;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/arquivo/{id}/{op?}', [IndexArquivo::class, 'index'])->name('pg-arquivo');

Route::get('/', [IndexController::class, 'inicio'])->name('inicio-menus');

Route::get('/login', function () {
    return view('pages.page-login');
});

Route::get('/cadastro', function () {
    return view('pages.page-cadastro');
});

Route::get('/transparencia', [IndexController::class, 'transparencia'])->name('page-transparencia');

Route::get('novo/atendimento', [IndexController::class, 'novoAtendimento'])->name('novo-atendimento');

Route::get('/configuracao', [IndexController::class, 'menus'])->name('admin-menus');

Route::get('/atendimento/{id}', [IndexController::class, 'atendimento'])->name('usuario-atendimento');

Route::get('atendimentos', [IndexController::class, 'atendimentos'])->name('usuario-atendimentos');

Route::get('/novasenha', function () {
    return view('pages.page-recuperarSenha');
});

Route::get('/ouvidoria/protocolo/{numero}', [IndexController::class, 'protocolo'])->name('usuario-protocolo');
