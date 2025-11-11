<?php

namespace App\Http\Controllers;

use App\Models\Doacao;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoacaoController extends Controller
{
    /**
     * Exibir formulário para criar nova doação
     */
    public function create()
    {
        $user = Auth::user();
        $itens = Item::with('categoria')->where('status', 'ativo')->get();
        
        return view('user.doacoes.create', compact('user', 'itens'));
    }

    /**
     * Listar doações do usuário
     */
    public function index()
    {
        $user = Auth::user();
        $doacoes = Doacao::with(['item.categoria'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.doacoes.index', compact('user', 'doacoes'));
    }

    /**
     * Mostrar detalhes de uma doação
     */
    public function show($id)
    {
        $user = Auth::user();
        $doacao = Doacao::with(['item.categoria'])
            ->where('user_id', $user->id)
            ->findOrFail($id);

        return view('user.doacoes.show', compact('user', 'doacao'));
    }

    /**
     * Armazenar nova doação - MÉTODO CORRIGIDO
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Verificar se o cadastro está completo
        if (!$user->cadastro_completo) {
            return redirect()->route('user.doacoes.create')
                ->with('error', 'Complete seu cadastro antes de fazer uma doação.')
                ->withInput();
        }

        $request->validate([
            'item_id' => 'required|exists:itens,id',
            'quantidade' => 'required|integer|min:1|max:100',
            'descricao' => 'nullable|string|max:500',
            'condicao' => 'required|in:novo,seminovo,usado,precisa_reparo',
        ]);

        try {
            Doacao::create([
                'user_id' => $user->id,
                'item_id' => $request->item_id,
                'quantidade' => $request->quantidade,
                'descricao' => $request->descricao,
                'condicao' => $request->condicao,
                'status' => 'pendente',
                'data_doacao' => now(),
            ]);

            return redirect()->route('user.doacoes.index')
                ->with('success', 'Doação registrada com sucesso! Aguarde a aprovação.');

        } catch (\Exception $e) {
            \Log::error('Erro ao registrar doação: ' . $e->getMessage());
            
            return redirect()->route('user.doacoes.create')
                ->with('error', 'Erro ao registrar doação. Tente novamente.')
                ->withInput();
        }
    }

    /**
     * Cancelar/Excluir doação
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $doacao = Doacao::where('user_id', $user->id)
            ->where('status', 'pendente')
            ->findOrFail($id);

        try {
            $doacao->delete();

            return redirect()->route('user.doacoes.index')
                ->with('success', 'Doação cancelada com sucesso.');

        } catch (\Exception $e) {
            return redirect()->route('user.doacoes.index')
                ->with('error', 'Erro ao cancelar doação: ' . $e->getMessage());
        }
    }

    public function relatorio()
{
    try {
        $doacoes = Doacao::with(['user', 'item.categoria'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        $estatisticas = [
            'total_doacoes' => Doacao::count(),
            'doacoes_aprovadas' => Doacao::where('status', 'aprovado')->count(),
            'doacoes_pendentes' => Doacao::where('status', 'pendente')->count(),
            'doacoes_rejeitadas' => Doacao::where('status', 'rejeitado')->count(),
        ];
        
        return view('admin.doacoes.relatorio', compact('doacoes', 'estatisticas'));
        
    } catch (\Exception $e) {
        return redirect()->route('admin.dashboard')
            ->with('error', 'Erro ao carregar relatório: ' . $e->getMessage());
    }
}
}