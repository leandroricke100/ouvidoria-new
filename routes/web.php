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

Route::get('/', function () {
    return view('pages.page-inicio');
});

Route::get('/login', function () {
    return view('pages.page-login');
});

Route::get('/cadastro', function () {
    return view('pages.page-cadastro');
});

Route::get('novo/atendimento', function () {
    if (!session('usuario')) {
        return redirect('/login');
    }
    return view('pages.page-novo-atendimento');
});


Route::get('/atendimento/{id}', [IndexController::class, 'atendimento'])->name('usuario-atendimento');

Route::get('atendimentos', [IndexController::class, 'atendimentos'])->name('usuario-atendimentos');

Route::get('/novasenha', function () {
    return view('pages.page-recuperarSenha');
});

Route::get('/ouvidoria/protocolo/{numero}', [IndexController::class, 'protocolo'])->name('usuario-protocolo');
