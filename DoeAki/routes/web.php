<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EventoController;

//Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');



Route::get('/dashboard', [EmpresaController::class, 'index']) -> name('empresa.dashboard');

Route::get('/eventos', [EventoController::class, 'lista']) -> name('empresa.evento.lista');

Route::get('/gerenciar', [EventoController::class, 'gerenciar']) -> name('empresa.evento.gerenciar');

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
