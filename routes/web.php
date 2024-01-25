<?php

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
    return view('pages.page-novo-atendimento');
});

Route::get('/atendimento/{id}', function ($id = '') {
    return view('pages.page-atendimento');
});

Route::get('atendimentos', function () {
    return view('pages.page-atendimentos');
});
