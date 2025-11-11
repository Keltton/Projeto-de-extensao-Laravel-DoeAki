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
    /**
     * Dashboard administrativo
     */
    public function dashboard()
    {
        try {
            // Estatísticas principais
            $data = [
                'totalUsers' => User::count(),
                'totalItens' => $this->getItensCount(),
                'totalCategorias' => Categoria::count(),
                'totalEventos' => Evento::count(),
                'eventosRecentes' => Evento::with('user')->latest()->take(5)->get(),

                // Estatísticas de doações
                'totalDoacoes' => $this->getDoacoesCount(),
                'doacoesPendentes' => Doacao::where('status', 'pendente')->count(),
                'doacoesAceitas' => Doacao::where('status', 'aceita')->count(),
                'doacoesRejeitadas' => Doacao::whereIn('status', ['rejeitada', 'rejeitado'])->count(),
                'doacoesEntregues' => Doacao::where('status', 'entregue')->count(),

                // Estatísticas de estoque
                'estoqueTotal' => Doacao::whereIn('status', ['aceita', 'aprovado'])->sum('quantidade'),
                'itensUnicos' => Doacao::whereIn('status', ['aceita', 'aprovado'])
                    ->distinct()
                    ->count('item_id'),
                'aprovadasHoje' => $this->getAprovadasHojeCount(),

                // Doações recentes para aprovação
                'doacoesRecentes' => Doacao::with(['user', 'item.categoria'])
                    ->where('status', 'pendente')
                    ->latest()
                    ->take(5)
                    ->get()
            ];

            return view('admin.dashboard', $data);

        } catch (\Exception $e) {
            \Log::error('Erro no dashboard admin: ' . $e->getMessage());

            // Retorna dados básicos em caso de erro
            return view('admin.dashboard', [
                'totalUsers' => 0,
                'totalItens' => 0,
                'totalCategorias' => 0,
                'totalEventos' => 0,
                'totalDoacoes' => 0,
                'doacoesPendentes' => 0,
                'doacoesAceitas' => 0,
                'doacoesRejeitadas' => 0,
                'doacoesEntregues' => 0,
                'estoqueTotal' => 0,
                'itensUnicos' => 0,
                'aprovadasHoje' => 0,
                'doacoesRecentes' => collect(),
                'eventosRecentes' => collect()
            ])->with('error', 'Erro ao carregar dashboard: ' . $e->getMessage());
        }
    }

    /**
     * Método seguro para contar doações aprovadas hoje
     */
    private function getAprovadasHojeCount()
    {
        try {
            if (Schema::hasColumn('doacoes', 'data_aprovacao')) {
                return Doacao::where('status', 'aceita')
                    ->whereDate('data_aprovacao', today())
                    ->count();
            }
            return Doacao::whereIn('status', ['aceita', 'aprovado'])
                ->whereDate('created_at', today())
                ->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Método para contar itens de forma segura
     */
    private function getItensCount()
    {
        try {
            return Item::count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Método para contar doações de forma segura
     */
    private function getDoacoesCount()
    {
        try {
            return Doacao::count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * =============================================
     * GERENCIAMENTO DE USUÁRIOS
     * =============================================
     */

    /**
     * Listagem de usuários (compatibilidade com rotas)
     */
    public function index()
    {
        return $this->gerenciarUsuarios();
    }

    /**
     * Gerenciar usuários (lista completa)
     */
    public function gerenciarUsuarios()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);

        $estatisticas = [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'users' => User::where('role', 'user')->count(),
            'cadastro_completo' => User::where('cadastro_completo', true)->count(),
            'novos_este_mes' => User::whereMonth('created_at', now()->month)->count(),
        ];

        return view('admin.users.index', compact('users', 'estatisticas'));
    }

    /**
     * Formulário de criação de usuário (compatibilidade)
     */
    public function create()
    {
        return $this->criarUsuario();
    }

    /**
     * Formulário de criação de usuário
     */
    public function criarUsuario()
    {
        return view('admin.users.create');
    }

    /**
     * Armazena novo usuário (compatibilidade)
     */
    public function store(Request $request)
    {
        return $this->salvarUsuario($request);
    }

    /**
     * Salvar novo usuário
     */
    public function salvarUsuario(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'telefone' => 'nullable|string|max:20',
            'cpf' => 'nullable|string|max:14',
            'role' => 'required|in:admin,user',
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'telefone' => $request->telefone,
                'cpf' => $request->cpf,
                'role' => $request->role,
                'cadastro_completo' => !empty($request->telefone) && !empty($request->cpf),
                'email_verified_at' => now()
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
     * Formulário de edição de usuário (compatibilidade)
     */
    public function edit(User $user)
    {
        return $this->editarUsuario($user->id);
    }

    /**
     * Exibir formulário de edição de usuário
     */
    public function editarUsuario($id)
    {
        try {
            $user = User::findOrFail($id);
            return view('admin.users.edit', compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Usuário não encontrado: ' . $e->getMessage());
        }
    }

    /**
     * Atualiza usuário (compatibilidade)
     */
    public function update(Request $request, User $user)
    {
        return $this->atualizarUsuario($request, $user->id);
    }

    /**
     * Atualizar usuário
     */
    public function atualizarUsuario(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'telefone' => 'nullable|string|max:20',
                'cpf' => 'nullable|string|max:14|unique:users,cpf,' . $user->id,
                'endereco' => 'nullable|string|max:255',
                'cidade' => 'nullable|string|max:100',
                'estado' => 'nullable|string|max:2',
                'cep' => 'nullable|string|max:9',
                'sobre' => 'nullable|string',
                'role' => 'required|in:user,admin',
                'cadastro_completo' => 'boolean',
            ]);

            $user->update($validated);

            return redirect()->route('admin.users.index')
                ->with('success', 'Usuário atualizado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao atualizar usuário: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Deleta usuário (compatibilidade)
     */
    public function destroy(User $user)
    {
        return $this->excluirUsuario($user->id);
    }

    /**
     * Excluir usuário
     */
    public function excluirUsuario($id)
    {
        try {
            $user = User::findOrFail($id);

            // Impedir que o admin exclua a si mesmo
            if ($user->id === auth()->id()) {
                return redirect()->back()
                    ->with('error', 'Você não pode excluir sua própria conta!');
            }

            $user->delete();

            return redirect()->route('admin.users.index')
                ->with('success', 'Usuário excluído com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao excluir usuário: ' . $e->getMessage());
        }
    }

    /**
     * Resetar senha do usuário (compatibilidade)
     */
    public function resetPassword(Request $request, User $user)
    {
        return $this->resetarSenha($user->id);
    }

    /**
     * Resetar senha do usuário
     */
    public function resetarSenha($id)
    {
        try {
            $user = User::findOrFail($id);

            // Gerar uma senha temporária
            $tempPassword = '12345678';
            $user->update([
                'password' => Hash::make($tempPassword)
            ]);

            return redirect()->back()
                ->with('success', 'Senha resetada com sucesso! Nova senha: ' . $tempPassword);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao resetar senha: ' . $e->getMessage());
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
            'rejeitadas' => Doacao::whereIn('status', ['rejeitada', 'rejeitado'])->count(),
            'entregues' => Doacao::where('status', 'entregue')->count(),
            'total' => Doacao::count()
        ];

        return view('admin.doacoes.gerenciar', compact('doacoes', 'estatisticas'));
    }

    /**
     * Aprovar doação
     */
    public function aprovarDoacao($id)
    {
        try {
            $doacao = Doacao::findOrFail($id);

            // Usa o método do model
            if ($doacao->aprovar(auth()->id())) {
                return redirect()->back()
                    ->with('success', 'Doação aprovada com sucesso!');
            }

            return redirect()->back()
                ->with('error', 'Erro ao aprovar doação.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao aprovar doação: ' . $e->getMessage());
        }
    }

    /**
     * Rejeitar doação
     */
    public function rejeitarDoacao(Request $request, $id)
    {
        try {
            $doacao = Doacao::findOrFail($id);

            // Usa o método do model
            if ($doacao->rejeitar($request->motivo_rejeicao)) {
                return redirect()->back()
                    ->with('success', 'Doação rejeitada com sucesso!');
            }

            return redirect()->back()
                ->with('error', 'Erro ao rejeitar doação.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao rejeitar doação: ' . $e->getMessage());
        }
    }

    /**
     * Marcar doação como entregue
     */
    public function marcarEntregue($id)
    {
        try {
            $doacao = Doacao::findOrFail($id);

            // Usa o método do model
            if ($doacao->marcarEntregue()) {
                return redirect()->back()
                    ->with('success', 'Doação marcada como entregue com sucesso!');
            }

            return redirect()->back()
                ->with('error', 'Erro ao marcar doação como entregue.');

        } catch (\Exception $e) {
            \Log::error('Erro ao marcar doação como entregue: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erro ao marcar doação como entregue: ' . $e->getMessage());
        }
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
     * Relatório de itens recebidos
     */
    public function relatorioItens()
    {
        $itens = Item::with(['categoria'])
            ->withCount([
                'doacoes as total_doacoes' => function ($query) {
                    $query->whereIn('status', ['aceita', 'aprovado']);
                }
            ])
            ->withSum([
                'doacoes as total_quantidade' => function ($query) {
                    $query->whereIn('status', ['aceita', 'aprovado']);
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
     * Relatório de doações
     */
    public function relatorioDoacoes()
    {
        $doacoes = Doacao::with(['user', 'item.categoria'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $estatisticas = [
            'total' => Doacao::count(),
            'pendentes' => Doacao::where('status', 'pendente')->count(),
            'aceitas' => Doacao::whereIn('status', ['aceita', 'aprovado'])->count(),
            'rejeitadas' => Doacao::whereIn('status', ['rejeitada', 'rejeitado'])->count(),
            'entregues' => Doacao::where('status', 'entregue')->count(),
        ];

        return view('admin.relatorios.doacoes', compact('doacoes', 'estatisticas'));
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
            'doacoes_aceitas' => Doacao::whereIn('status', ['aceita', 'aprovado'])->count(),
            'doacoes_entregues' => Doacao::where('status', 'entregue')->count(),

            // Eventos
            'total_eventos' => Evento::count(),
            'eventos_ativos' => Evento::where('status', 'ativo')->count(),
            'eventos_futuros' => Evento::where('data_evento', '>=', now())->count(),

            // Itens mais doados
            'itens_mais_doados' => Item::with(['categoria'])
                ->withSum([
                    'doacoes as total_recebido' => function ($query) {
                        $query->whereIn('status', ['aceita', 'aprovado']);
                    }
                ], 'quantidade')
                ->orderBy('total_recebido', 'desc')
                ->take(10)
                ->get()
        ];

        return view('admin.relatorios.geral', compact('estatisticas'));
    }
}