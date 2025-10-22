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

use App\Http\Controllers\ClienteController;

Route::get('/doador/criar', [ClienteController::class, 'create'])->name('doador.create');
Route::post('/doador', [ClienteController::class, 'store'])->name('doador.store');


use App\Http\Controllers\DoadorController;

Route::get('/buscar-endereco/{cep}', [DoadorController::class, 'buscarEndereco']);
Route::resource('doador', DoadorController::class);



