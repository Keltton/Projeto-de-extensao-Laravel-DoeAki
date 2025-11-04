<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Rota principal - Página inicial (Welcome)
Route::get('/', function () {
    return view('welcome'); 
});

// Rotas de Autenticação 
Route::get('/home', [AuthController::class, 'welcome'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Essa rota agrupa todas as rotas administrativas, garantindo que apenas usuários autenticados com a função de administrador possam acessá-las.
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function() {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('users', AdminController::class)->names('admin.users')->except('show'); // Rotas de gerenciamento de usuários
});


// Rotas para gerenciamento de usuários pelo Admin
Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users.index');
Route::get('/admin/users/create', [AdminController::class, 'create'])->name('admin.users.create');
Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.users.store');
Route::get('/admin/users/{user}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
Route::put('/admin/users/{user}', [AdminController::class, 'update'])->name('admin.users.update');
Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');


    // User Management
    Route::resource('users', AdminController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy'
    ]);



    
// Rotas de Usuário 
Route::middleware(['auth'])->group(function () {
Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
});

Route::prefix('admin/itens')->middleware(['auth', 'is_admin'])->name('admin.itens.')->group(function () {
    Route::get('/', [AdminController::class, 'indexItens'])->name('index');
    Route::get('/create', [AdminController::class, 'createItem'])->name('create');
    Route::post('/', [AdminController::class, 'storeItem'])->name('store');
    Route::get('/{item}/edit', [AdminController::class, 'editItem'])->name('edit');
    Route::put('/{item}', [AdminController::class, 'updateItem'])->name('update');
    Route::delete('/{item}', [AdminController::class, 'destroyItem'])->name('destroy');
});


