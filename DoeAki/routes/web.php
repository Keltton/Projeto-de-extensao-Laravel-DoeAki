<?php
    
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonationController;

Route::view('/doacao', 'donations.create')->name('donations.create');
Route::view('/doacao/obrigado', 'donations.thanks')->name('donations.thanks');
Route::post('/doacao', [DonationController::class, 'store'])->name('donations.store');
