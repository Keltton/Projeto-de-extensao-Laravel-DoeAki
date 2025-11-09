<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // Eventos ativos com paginação
            $eventos = Evento::where('status', 'ativo')
                ->where('data_evento', '>=', now())
                ->orderBy('data_evento', 'asc')
                ->paginate(6);
        } catch (\Exception $e) {
            // Se houver erro (tabela não existe), retorna array vazio
            $eventos = collect([]);
        }

        return view('welcome', compact('eventos'));
    }
}