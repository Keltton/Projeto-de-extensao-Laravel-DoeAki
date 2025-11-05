<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Support\Facades\Route;

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
