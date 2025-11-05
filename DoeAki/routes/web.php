<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\EventoController;

Route::view('/doacao', 'donations.create')->name('donations.create');
Route::view('/doacao/obrigado', 'donations.thanks')->name('donations.thanks');
Route::post('/doacao', [DonationController::class, 'store'])->name('donations.store');

Route::get('/', function () {
    $categoriesCount = Category::count();
    $itemsCount = Item::count();
    $totalValue = Item::sum('price');
    $avgItemsPerCategory = $categoriesCount > 0 ? round($itemsCount / $categoriesCount, 1) : 0;
    $recentItems = Item::with('category')->latest()->take(5)->get();

    return view('welcome', compact(
        'categoriesCount',
        'itemsCount',
        'totalValue',
        'avgItemsPerCategory',
        'recentItems'
    ));
});

Route::resource('categories', CategoryController::class);
Route::resource('items', ItemController::class);

Route::get('/dashboard', [EventoController::class, 'dashboard'])->name('empresa.dashboard');

Route::get('/eventos/detalhes/{id}', [EventoController::class, 'detalhes'])->name('evento.show');

Route::get('/eventos', [EventoController::class, 'lista'])->name('empresa.evento.lista');

Route::get('/eventos/{id}/gerenciar', [EventoController::class, 'gerenciar'])->name('empresa.evento.gerenciar');

Route::put('/eventos/update/{id}', [EventoController::class, 'update'])->name('empresa.evento.update');

Route::get('/adicionar', [EventoController::class, 'adicionar'])->name('empresa.evento.adicionar');

Route::post('/eventos/store', [EventoController::class, 'store'])->name('empresa.evento.store');

Route::delete('/eventos/delete/{id}', [EventoController::class, 'destroy'])->name('empresa.evento.destroy');
