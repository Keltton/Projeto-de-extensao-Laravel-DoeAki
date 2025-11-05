<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EventoController;

//Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');




Route::get('/dashboard', [EventoController::class, 'dashboard']) -> name('empresa.dashboard');

Route::get('/eventos/detalhes/{id}', [EventoController::class, 'detalhes']) -> name('evento.show');

Route::get('/eventos', [EventoController::class, 'lista']) -> name('empresa.evento.lista');

Route::get('/eventos/{id}/gerenciar', [EventoController::class, 'gerenciar']) -> name('empresa.evento.gerenciar');

Route::put('/eventos/update/{id}', [EventoController::class, 'update']) -> name('empresa.evento.update');

Route::get('/adicionar', [EventoController::class, 'adicionar']) -> name('empresa.evento.adicionar');

Route::post('/eventos/store', [EventoController::class, 'store']) -> name('empresa.evento.store');

Route::delete('/eventos/delete/{id}', [EventoController::class, 'destroy']) -> name('empresa.evento.destroy');