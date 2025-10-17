<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function(){
    return view('empresa.dashboard');
});

Route::get('/eventos', function () {
    return view('empresa.evento.lista');
})->name('empresa.evento.lista');

Route::get('/gerenciar', function () {
    return view('empresa.evento.gerenciar');
})->name('empresa.evento.gerenciar');

Route::get('/estoque', function () {
    return view('empresa.relatorios.estoque');
})->name('empresa.relatorios.estoque');

Route::get('/doacoes', function () {
    return view('empresa.relatorios.doacoes');
})->name('empresa.relatorios.doacoes');

Route::get('/recebido', function () {
    return view('empresa.relatorios.recebido');
})->name('empresa.relatorios.recebido');

Route::get('/geral', function () {
    return view('empresa.relatorios.geral');
})->name('empresa.relatorios.geral');
