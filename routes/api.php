<?php

use App\Http\Controllers\OuvidoriaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/OuvidoriaCadastro', [OuvidoriaController::class, 'cadastro']);