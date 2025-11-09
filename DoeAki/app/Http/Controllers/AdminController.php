<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Item;
use App\Models\Categoria;
use App\Models\Evento;
use App\Models\Doacao;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Estatísticas principais
        $stats = [
            'totalUsers' => User::count(),
            'totalItens' => $this->getItensCount(),
            'totalCategorias' => Categoria::count(),
            'totalEventos' => Evento::count(),
            'eventosRecentes' => Evento::with('user')->latest()->take(5)->get(),
        ];

        // Estatísticas de doações
        $statsDoacoes = [
            'totalDoacoes' => $this->getDoacoesCount(),
            'doacoesPendentes' => Doacao::where('status', 'pendente')->count(),
            'doacoesAceitas' => Doacao::where('status', 'aceita')->count(),
            'doacoesRejeitadas' => Doacao::where('status', 'rejeitada')->count(),
            'doacoesEntregues' => Doacao::where('status', 'entregue')->count(),
        ];

        // Estatísticas de estoque - com verificação segura
        $statsEstoque = [
            'estoqueTotal' => Doacao::where('status', 'aceita')->sum('quantidade'),
            'itensUnicos' => Doacao::where('status', 'aceita')
                ->distinct()
                ->count('item_id'),
            'aprovadasHoje' => $this->getAprovadasHojeCount(), // Método seguro
        ];

        // Doações recentes para aprovação
        $doacoesRecentes = Doacao::with(['user', 'item.categoria'])
            ->where('status', 'pendente')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', array_merge(
            $stats,
            $statsDoacoes,
            $statsEstoque,
            [
                'doacoesRecentes' => $doacoesRecentes
            ]
        ));
    }

    /**
     * Método seguro para contar doações aprovadas hoje
     */
    private function getAprovadasHojeCount()
    {
        try {
            // Verifica se a coluna existe antes de usar
            if (Schema::hasColumn('doacoes', 'data_aprovacao')) {
                return Doacao::where('status', 'aceita')
                    ->whereDate('data_aprovacao', today())
                    ->count();
            }
            return 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Método para contar itens de forma segura
     */
    private function getItensCount()
    {
        if (Schema::hasTable('itens')) {
            try {
                return DB::table('itens')->count();
            } catch (\Exception $e) {
                return 0;
            }
        }
        return 0;
    }

    /**
     * Método para contar doações de forma segura
     */
    private function getDoacoesCount()
    {
        if (Schema::hasTable('doacoes')) {
            try {
                return DB::table('doacoes')->count();
            } catch (\Exception $e) {
                return 0;
            }
        }
        return 0;
    }

    /**
     * =============================================
     * GERENCIAMENTO DE USUÁRIOS
     * =============================================
     */

    /**
     * Listagem de usuários
     */
    public function index()
    {
        $users = User::where('role', 'user')->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Formulário de criação de usuário
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Armazena novo usuário
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'telefone' => 'nullable|string|max:20',
            'cpf' => 'nullable|string|max:14',
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'telefone' => $request->telefone,
                'cpf' => $request->cpf,
                'role' => 'user',
                'cadastro_completo' => !empty($request->telefone) && !empty($request->cpf)
            ]);

            return redirect()->route('admin.users.index')
                ->with('success', 'Usuário criado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->route('admin.users.create')
                ->with('error', 'Erro ao criar usuário: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Formulário de edição de usuário
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Atualiza usuário
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telefone' => 'nullable|string|max:20',
            'cpf' => 'nullable|string|max:14',
            'role' => 'required|in:admin,user',
            'cadastro_completo' => 'boolean'
        ]);

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'telefone' => $request->telefone,
                'cpf' => $request->cpf,
                'role' => $request->role,
                'cadastro_completo' => $request->has('cadastro_completo')
            ]);

            return redirect()->route('admin.users.index')
                ->with('success', 'Usuário atualizado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->route('admin.users.edit', $user)
                ->with('error', 'Erro ao atualizar usuário: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Deleta usuário
     */
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Você não pode deletar sua própria conta!');
        }

        try {
            $user->delete();
            return redirect()->route('admin.users.index')
                ->with('success', 'Usuário deletado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Erro ao deletar usuário: ' . $e->getMessage());
        }
    }

    /**
     * Resetar senha do usuário
     */
    public function resetPassword(Request $request, User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Você não pode redefinir sua própria senha aqui.');
        }

        $request->validate([
            'new_password' => 'required|min:6|confirmed'
        ]);

        try {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            return redirect()->route('admin.users.edit', $user)
                ->with('success', 'Senha redefinida com sucesso!');

        } catch (\Exception $e) {
            return redirect()->route('admin.users.edit', $user)
                ->with('error', 'Erro ao redefinir senha: ' . $e->getMessage());
        }
    }

    /**
     * =============================================
     * GERENCIAMENTO DE DOAÇÕES
     * =============================================
     */

    /**
     * Gerenciar doações (sistema de aprovação)
     */
    public function gerenciarDoacoes()
    {
        $doacoes = Doacao::with(['user', 'item.categoria'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $estatisticas = [
            'pendentes' => Doacao::where('status', 'pendente')->count(),
            'aceitas' => Doacao::where('status', 'aceita')->count(),
            'rejeitadas' => Doacao::where('status', 'rejeitada')->count(),
            'entregues' => Doacao::where('status', 'entregue')->count(),
            'total' => Doacao::count()
        ];

        return view('admin.doacoes.index', compact('doacoes', 'estatisticas'));
    }

    /**
     * Aprovar doação
     */
    public function aprovarDoacao($id)
    {
        try {
            $doacao = Doacao::with(['item'])->findOrFail($id);

            // Verificar se o item existe e contar quantidades recebidas
            $quantidadeRecebida = 0;
            if ($doacao->item) {
                $quantidadeRecebida = Doacao::where('item_id', $doacao->item_id)
                    ->where('status', 'aceita')
                    ->sum('quantidade');
            }

            $doacao->update([
                'status' => 'aceita',
                'data_aprovacao' => now()
            ]);

            $novaQuantidade = $quantidadeRecebida + $doacao->quantidade;

            return redirect()->route('admin.doacoes.gerenciar')
                ->with('success', "Doação aprovada com sucesso! Total de {$novaQuantidade} unidades recebidas deste item.");

        } catch (\Exception $e) {
            return redirect()->route('admin.doacoes.gerenciar')
                ->with('error', 'Erro ao aprovar doação: ' . $e->getMessage());
        }
    }

    /**
     * Rejeitar doação
     */
    public function rejeitarDoacao(Request $request, $id)
    {
        $request->validate([
            'motivo_rejeicao' => 'required|string|max:500'
        ]);

        try {
            $doacao = Doacao::findOrFail($id);

            $doacao->update([
                'status' => 'rejeitada',
                'motivo_rejeicao' => $request->motivo_rejeicao,
                'data_rejeicao' => now()
            ]);

            return redirect()->route('admin.doacoes.gerenciar')
                ->with('success', 'Doação rejeitada com sucesso.');

        } catch (\Exception $e) {
            return redirect()->route('admin.doacoes.gerenciar')
                ->with('error', 'Erro ao rejeitar doação: ' . $e->getMessage());
        }
    }

    /**
     * Marcar como entregue
     */
    public function marcarEntregue($id)
    {
        try {
            $doacao = Doacao::findOrFail($id);

            $doacao->update([
                'status' => 'aceita', // Use 'aceita' temporariamente
                'data_entrega' => now(),
                'adicionado_estoque' => false // Marcar que saiu do estoque
            ]);

            return redirect()->route('admin.doacoes.gerenciar')
                ->with('success', 'Doação marcada como entregue.');

        } catch (\Exception $e) {
            return redirect()->route('admin.doacoes.gerenciar')
                ->with('error', 'Erro ao marcar como entregue: ' . $e->getMessage());
        }
    }

    /**
     * Relatório de itens recebidos
     */
    public function relatorioItens()
    {
        $itens = Item::with(['categoria'])
            ->withCount([
                'doacoes as total_doacoes' => function ($query) {
                    $query->where('status', 'aceita');
                }
            ])
            ->withSum([
                'doacoes as total_quantidade' => function ($query) {
                    $query->where('status', 'aceita');
                }
            ], 'quantidade')
            ->orderBy('total_quantidade', 'desc')
            ->get();

        // Estatísticas gerais
        $estatisticas = [
            'total_itens' => $itens->count(),
            'total_quantidade' => $itens->sum('total_quantidade'),
            'itens_com_doacoes' => $itens->where('total_quantidade', '>', 0)->count()
        ];

        return view('admin.doacoes.relatorio', compact('itens', 'estatisticas'));
    }

    /**
     * Detalhes de uma doação específica (admin)
     */
    public function showDoacao($id)
    {
        $doacao = Doacao::with(['user', 'item.categoria'])->findOrFail($id);
        return view('admin.doacoes.show', compact('doacao'));
    }



    /**
     * =============================================
     * RELATÓRIOS E ESTATÍSTICAS
     * =============================================
     */

    /**
     * Relatório geral do sistema
     */
    public function relatorioGeral()
    {
        $estatisticas = [
            // Usuários
            'total_usuarios' => User::count(),
            'usuarios_ativos' => User::where('cadastro_completo', true)->count(),
            'novos_usuarios_30_dias' => User::where('created_at', '>=', now()->subDays(30))->count(),

            // Doações
            'total_doacoes' => Doacao::count(),
            'doacoes_pendentes' => Doacao::where('status', 'pendente')->count(),
            'doacoes_aceitas' => Doacao::where('status', 'aceita')->count(),
            'doacoes_entregues' => Doacao::where('status', 'entregue')->count(),

            // Eventos
            'total_eventos' => Evento::count(),
            'eventos_ativos' => Evento::where('status', 'ativo')->count(),
            'eventos_futuros' => Evento::where('data_evento', '>=', now())->count(),

            // Itens mais doados
            'itens_mais_doados' => Item::with(['categoria'])
                ->withSum([
                    'doacoes as total_recebido' => function ($query) {
                        $query->where('status', 'aceita');
                    }
                ], 'quantidade')
                ->orderBy('total_recebido', 'desc')
                ->take(10)
                ->get()
        ];

        return view('admin.relatorios.geral', compact('estatisticas'));
    }
}