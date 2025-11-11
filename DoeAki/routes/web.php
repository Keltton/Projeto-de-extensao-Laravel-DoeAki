<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoacaoController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Rotas Públicas
|--------------------------------------------------------------------------
*/

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Página Sobre
Route::get('/sobre', function () {
    return view('sobre');
})->name('sobre');

// Rotas públicas de eventos
Route::get('/eventos', [EventoController::class, 'index'])->name('eventos.index');
Route::get('/eventos/{id}', [EventoController::class, 'show'])->name('eventos.show');

// Autenticação
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Painel do Usuário (Apenas usuários logados)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('user')->name('user.')->group(function () {

    // 📌 Dashboard
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    // 📌 Perfil do Usuário
    Route::get('/perfil', [UserController::class, 'perfil'])->name('perfil');
    Route::post('/perfil/atualizar', [UserController::class, 'atualizarPerfil'])->name('perfil.atualizar');
    Route::post('/perfil/senha', [UserController::class, 'atualizarSenha'])->name('perfil.senha');

    // 📌 Doações
    Route::prefix('doacoes')->name('doacoes.')->group(function () {
        Route::get('/', [DoacaoController::class, 'index'])->name('index');
        Route::get('/nova', [DoacaoController::class, 'create'])->name('create');
        Route::post('/', [DoacaoController::class, 'store'])->name('store');
        Route::get('/{id}', [DoacaoController::class, 'show'])->name('show');
        Route::delete('/{id}', [DoacaoController::class, 'destroy'])->name('destroy');
    });

    // 📌 Eventos do Usuário
    Route::prefix('eventos')->name('eventos.')->group(function () {
        Route::get('/meus', [EventoController::class, 'meusEventos'])->name('meus');
        Route::post('/{evento}/inscrever', [EventoController::class, 'inscrever'])->name('inscrever');
        Route::post('/{evento}/cancelar', [EventoController::class, 'cancelarInscricao'])->name('cancelar');
    });
});

/*
|--------------------------------------------------------------------------
| Painel do Admin (Apenas administradores)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // 📌 Gestão de Usuários
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminController::class, 'gerenciarUsuarios'])->name('index');
        Route::get('/create', [AdminController::class, 'criarUsuario'])->name('create');
        Route::post('/', [AdminController::class, 'salvarUsuario'])->name('store');
        Route::get('/{user}/edit', [AdminController::class, 'editarUsuario'])->name('edit');
        Route::put('/{user}', [AdminController::class, 'atualizarUsuario'])->name('update');
        Route::delete('/{user}', [AdminController::class, 'excluirUsuario'])->name('destroy');
        Route::post('/{user}/reset-password', [AdminController::class, 'resetarSenha'])->name('reset-password');
    });

    // 📌 Gestão de Itens
    Route::prefix('itens')->name('itens.')->group(function () {
        Route::get('/', [ItemController::class, 'index'])->name('index');
        Route::get('/create', [ItemController::class, 'create'])->name('create');
        Route::post('/', [ItemController::class, 'store'])->name('store');
        Route::get('/{item}/edit', [ItemController::class, 'edit'])->name('edit');
        Route::put('/{item}', [ItemController::class, 'update'])->name('update');
        Route::delete('/{item}', [ItemController::class, 'destroy'])->name('destroy');
    });

    // 📌 Gestão de Categorias
    Route::prefix('categorias')->name('categorias.')->group(function () {
        Route::get('/', [CategoriaController::class, 'index'])->name('index');
        Route::get('/create', [CategoriaController::class, 'create'])->name('create');
        Route::post('/', [CategoriaController::class, 'store'])->name('store');
        Route::get('/{categoria}/edit', [CategoriaController::class, 'edit'])->name('edit');
        Route::put('/{categoria}', [CategoriaController::class, 'update'])->name('update');
        Route::delete('/{categoria}', [CategoriaController::class, 'destroy'])->name('destroy');
    });

    // 📌 Gestão de Eventos
    Route::prefix('eventos')->name('eventos.')->group(function () {
        Route::get('/', [EventoController::class, 'adminIndex'])->name('index');
        Route::get('/create', [EventoController::class, 'create'])->name('create');
        Route::post('/', [EventoController::class, 'store'])->name('store');
        Route::get('/{id}', [EventoController::class, 'adminShow'])->name('show');
        Route::get('/{id}/edit', [EventoController::class, 'edit'])->name('edit');
        Route::put('/{id}', [EventoController::class, 'update'])->name('update');
        Route::delete('/{id}', [EventoController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/inscricoes', [EventoController::class, 'inscricoes'])->name('inscricoes');
        Route::post('/{id}/toggle-status', [EventoController::class, 'toggleStatus'])->name('toggle-status');
        Route::get('/{id}/exportar-inscricoes', [EventoController::class, 'exportarInscricoes'])->name('exportar-inscricoes');
    });

    // 📌 Gestão de Doações
    Route::prefix('doacoes')->name('doacoes.')->group(function () {
        Route::get('/gerenciar', [AdminController::class, 'gerenciarDoacoes'])->name('gerenciar');
        Route::post('/{id}/aprovar', [AdminController::class, 'aprovarDoacao'])->name('aprovar');
        Route::post('/{id}/rejeitar', [AdminController::class, 'rejeitarDoacao'])->name('rejeitar');
        Route::post('/{id}/entregue', [AdminController::class, 'marcarEntregue'])->name('entregue');
        Route::get('/relatorio', [AdminController::class, 'relatorioDoacoes'])->name('relatorio');
        Route::get('/{id}', [AdminController::class, 'showDoacao'])->name('show');
    });

    // 📌 Relatórios (Sistema Centralizado)
    Route::prefix('relatorios')->name('relatorios.')->group(function () {
        Route::get('/', [RelatorioController::class, 'index'])->name('index');
        Route::get('/dashboard', [RelatorioController::class, 'dashboard'])->name('dashboard');
        Route::get('/doacoes', [RelatorioController::class, 'doacoes'])->name('doacoes');
        Route::get('/usuarios', [RelatorioController::class, 'usuarios'])->name('usuarios');
        Route::get('/itens', [RelatorioController::class, 'itens'])->name('itens');
        Route::get('/eventos', [RelatorioController::class, 'eventos'])->name('eventos');
        Route::get('/exportar/{tipo}', [RelatorioController::class, 'exportar'])->name('exportar');
    });

    // 📌 Calendário de Eventos
    Route::get('/calendario', [EventoController::class, 'calendario'])->name('calendario');
});

/*
|--------------------------------------------------------------------------
| Rotas de Fallback
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});