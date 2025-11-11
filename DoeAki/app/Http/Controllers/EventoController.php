<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Inscricao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;

class EventoController extends Controller
{
    /**
     * Listar todos os eventos públicos (para home e página de eventos)
     */
    public function index(Request $request)
    {
        $query = Evento::where('status', 'ativo');

        // Filtro de busca
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->search . '%')
                    ->orWhere('descricao', 'like', '%' . $request->search . '%')
                    ->orWhere('local', 'like', '%' . $request->search . '%');
            });
        }

        // Filtro por data
        if ($request->has('data') && $request->data) {
            $query->whereDate('data_evento', $request->data);
        }

        $eventos = $query->orderBy('data_evento', 'asc')
            ->paginate(9);

        return view('eventos.index', compact('eventos'));
    }

    /**
     * Mostrar detalhes de um evento (página pública)
     */
    public function show($id)
    {
        $evento = Evento::with(['user', 'inscricoes.user'])->findOrFail($id);

        // Verifica se usuário está inscrito
        $userInscrito = false;
        if (Auth::check()) {
            $userInscrito = Auth::user()->inscricoes()
                ->where('evento_id', $id)
                ->where('status', 'confirmada')
                ->exists();
        }

        return view('eventos.show', compact('evento', 'userInscrito'));
    }

    /**
     * Meus eventos inscritos (usuário logado)
     */
    public function meusEventos()
    {
        $user = Auth::user();

        // Buscar eventos que o usuário está inscrito
        $eventosInscritos = $user->inscricoes()
            ->with('evento')
            ->whereHas('evento', function ($query) {
                $query->where('status', 'ativo');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Extrair apenas os eventos da relação e manter a paginação
        $eventos = $eventosInscritos->getCollection()->map(function ($inscricao) {
            return $inscricao->evento;
        });

        // Criar um novo paginator com os eventos (para manter a paginação)
        $eventosPaginated = new LengthAwarePaginator(
            $eventos,
            $eventosInscritos->total(),
            $eventosInscritos->perPage(),
            $eventosInscritos->currentPage(),
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        // Verificar em quais eventos o usuário está inscrito (para o botão de cancelar)
        $userInscrito = $user->inscricoes()
            ->pluck('evento_id')
            ->toArray();

        return view('user.eventos.meus', compact('eventosPaginated', 'userInscrito', 'eventosInscritos'));
    }

    /**
     * Inscrever usuário em um evento
     */
    public function inscrever(Request $request, $id)
    {
        $user = Auth::user();
        $evento = Evento::where('status', 'ativo')->findOrFail($id);

        // Verificar se já está inscrito
        if ($user->inscricoes()->where('evento_id', $id)->exists()) {
            return redirect()->back()->with('error', 'Você já está inscrito neste evento.');
        }

        // Verificar vagas disponíveis (se houver limite)
        if ($evento->vagas_disponiveis !== null && $evento->vagas_disponiveis <= 0) {
            return redirect()->back()->with('error', 'Não há vagas disponíveis para este evento.');
        }

        // Fazer a inscrição
        $inscricao = $user->inscricoes()->create([
            'evento_id' => $id,
            'data_inscricao' => now(),
            'status' => 'confirmada'
        ]);

        // Atualizar vagas disponíveis (se aplicável)
        if ($evento->vagas_disponiveis !== null) {
            $evento->decrement('vagas_disponiveis');
        }

        return redirect()->route('user.eventos.meus')
            ->with('success', 'Inscrição realizada com sucesso!');
    }

    /**
     * Cancelar inscrição em um evento
     */
    public function cancelarInscricao($eventoId)
    {
        try {
            $user = Auth::user();
            $evento = Evento::findOrFail($eventoId);

            // Encontrar a inscrição do usuário no evento
            $inscricao = Inscricao::where('user_id', $user->id)
                ->where('evento_id', $eventoId)
                ->first();

            if (!$inscricao) {
                return redirect()->back()->with('error', 'Você não está inscrito neste evento.');
            }

            // Deletar a inscrição
            $inscricao->delete();

            // Atualizar vagas disponíveis (se aplicável)
            if ($evento->vagas_disponiveis !== null) {
                $evento->increment('vagas_disponiveis');
            }

            return redirect()->back()->with('success', 'Inscrição cancelada com sucesso!');

        } catch (\Exception $e) {
            \Log::error('Erro ao cancelar inscrição: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erro ao cancelar inscrição: ' . $e->getMessage());
        }
    }

    /**
     * Listar eventos (Admin)
     */
    public function adminIndex(Request $request)
    {
        $query = Evento::with(['user', 'inscricoes']);

        // Filtros
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->search . '%')
                    ->orWhere('descricao', 'like', '%' . $request->search . '%')
                    ->orWhere('local', 'like', '%' . $request->search . '%');
            });
        }

        $eventos = $query->orderBy('data_evento', 'desc')
            ->paginate(10);

        return view('admin.eventos.index', compact('eventos'));
    }

    /**
     * Mostrar detalhes de um evento no painel admin
     */
    public function adminShow($id)
    {
        $evento = Evento::with(['user', 'inscricoes.user'])->findOrFail($id);

        $inscricoesCount = $evento->inscricoes()->count();
        $inscricoesRecent = $evento->inscricoes()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.eventos.show', compact('evento', 'inscricoesCount', 'inscricoesRecent'));
    }

    /**
     * Show the form for creating a new resource (Admin)
     */
    public function create()
    {
        return view('admin.eventos.create');
    }

    /**
     * Store a newly created resource in storage (Admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data_evento' => 'required|date',
            'local' => 'required|string|max:255',
            'endereco' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:2',
            'cep' => 'nullable|string|max:9',
            'vagas_total' => 'nullable|integer|min:0',
            'status' => 'required|in:ativo,inativo,cancelado',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $dados = $request->all();
            $dados['user_id'] = auth()->id();

            // Definir status padrão
            if (!$request->has('status') || !$request->status) {
                $dados['status'] = 'ativo';
            }

            // Definir vagas disponíveis
            if ($request->vagas_total && !$request->has('vagas_disponiveis')) {
                $dados['vagas_disponiveis'] = $request->vagas_total;
            }

            // Upload da imagem - SALVAR NA PASTA PUBLIC/images/eventos
            if ($request->hasFile('imagem')) {
                $imagem = $request->file('imagem');
                $nomeImagem = 'evento_' . time() . '.' . $imagem->getClientOriginalExtension();

                // Criar diretório se não existir
                if (!file_exists(public_path('images/eventos'))) {
                    mkdir(public_path('images/eventos'), 0755, true);
                }

                // Salvar na pasta public/images/eventos
                $imagem->move(public_path('images/eventos'), $nomeImagem);
                $dados['imagem'] = 'images/eventos/' . $nomeImagem;
            }

            $evento = Evento::create($dados);

            return redirect()->route('admin.eventos.index')
                ->with('success', 'Evento criado com sucesso!');

        } catch (\Exception $e) {
            \Log::error('Erro ao criar evento: ' . $e->getMessage());
            return back()->with('error', 'Erro ao criar evento: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource (Admin)
     */
    public function edit($id)
    {
        $evento = Evento::findOrFail($id);
        return view('admin.eventos.edit', compact('evento'));
    }

    /**
     * Update the specified resource in storage (Admin)
     */
    public function update(Request $request, $id)
    {
        $evento = Evento::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data_evento' => 'required|date',
            'local' => 'required|string|max:255',
            'endereco' => 'nullable|string|max:255',
            'cidade' => 'nullable|string|max:100',
            'estado' => 'nullable|string|max:2',
            'cep' => 'nullable|string|max:9',
            'vagas_total' => 'nullable|integer|min:0',
            'vagas_disponiveis' => 'nullable|integer|min:0',
            'status' => 'required|in:ativo,inativo,cancelado',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $dados = $request->all();

            // Remover imagem se solicitado
            if ($request->has('remover_imagem')) {
                if ($evento->imagem && file_exists(public_path($evento->imagem))) {
                    unlink(public_path($evento->imagem));
                }
                $dados['imagem'] = null;
            }

            // Upload da nova imagem - SALVAR NA PASTA PUBLIC/images/eventos
            if ($request->hasFile('imagem')) {
                // Remove imagem antiga
                if ($evento->imagem && file_exists(public_path($evento->imagem))) {
                    unlink(public_path($evento->imagem));
                }

                $imagem = $request->file('imagem');
                $nomeImagem = 'evento_' . time() . '.' . $imagem->getClientOriginalExtension();

                // Criar diretório se não existir
                if (!file_exists(public_path('images/eventos'))) {
                    mkdir(public_path('images/eventos'), 0755, true);
                }

                // Salvar na pasta public/images/eventos
                $imagem->move(public_path('images/eventos'), $nomeImagem);
                $dados['imagem'] = 'images/eventos/' . $nomeImagem;
            }

            // Atualizar vagas_disponiveis se vagas_total foi alterado
            if ($request->has('vagas_total') && $request->vagas_total != $evento->vagas_total) {
                $diferenca = $request->vagas_total - $evento->vagas_total;
                $dados['vagas_disponiveis'] = $evento->vagas_disponiveis + $diferenca;

                if ($dados['vagas_disponiveis'] < 0) {
                    $dados['vagas_disponiveis'] = 0;
                }
            }

            $evento->update($dados);

            return redirect()->route('admin.eventos.index')
                ->with('success', 'Evento atualizado com sucesso!');

        } catch (\Exception $e) {
            \Log::error('Erro ao atualizar evento: ' . $e->getMessage());
            return back()->with('error', 'Erro ao atualizar evento: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage (Admin)
     */
    public function destroy($id)
    {
        try {
            $evento = Evento::findOrFail($id);

            // Remove todas as inscrições relacionadas
            $evento->inscricoes()->delete();

            // Remove imagem da pasta public
            if ($evento->imagem && file_exists(public_path($evento->imagem))) {
                unlink(public_path($evento->imagem));
            }

            $evento->delete();

            return redirect()->route('admin.eventos.index')
                ->with('success', 'Evento excluído com sucesso!');

        } catch (\Exception $e) {
            \Log::error('Erro ao excluir evento: ' . $e->getMessage());
            return back()->with('error', 'Erro ao excluir evento: ' . $e->getMessage());
        }
    }

    /**
     * Alternar status do evento (Admin)
     */
    public function toggleStatus($id)
    {
        try {
            $evento = Evento::findOrFail($id);

            $novoStatus = $evento->status == 'ativo' ? 'inativo' : 'ativo';
            $evento->update(['status' => $novoStatus]);

            $acao = $novoStatus == 'ativo' ? 'ativado' : 'desativado';

            return redirect()->back()
                ->with('success', "Evento {$acao} com sucesso!");

        } catch (\Exception $e) {
            \Log::error('Erro ao alternar status: ' . $e->getMessage());
            return back()->with('error', 'Erro ao alterar status: ' . $e->getMessage());
        }
    }

    /**
     * Listar inscrições de um evento (Admin)
     */
    public function inscricoes($id)
    {
        $evento = Evento::findOrFail($id);
        $inscricoes = $evento->inscricoes()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.eventos.inscricoes', compact('evento', 'inscricoes'));
    }

    /**
     * Exportar inscrições para CSV
     */
    public function exportarInscricoes($id)
    {
        try {
            $evento = Evento::findOrFail($id);
            $inscricoes = $evento->inscricoes()->with('user')->get();

            // Nome do arquivo seguro (sem caracteres especiais)
            $fileName = 'inscricoes_' . Str::slug($evento->nome) . '_' . date('Y-m-d') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv; charset=utf-8',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ];

            $callback = function () use ($inscricoes) {
                // Criar arquivo de output
                $file = fopen('php://output', 'w');

                // Adicionar BOM para UTF-8 (resolve problemas com acentos no Excel)
                fwrite($file, "\xEF\xBB\xBF");

                // Cabeçalho do CSV
                fputcsv($file, [
                    'Nome',
                    'Email',
                    'Telefone',
                    'CPF',
                    'Cidade',
                    'Estado',
                    'Data de Inscrição',
                    'Status'
                ], ';'); // Usar ponto e vírgula como separador (melhor para Excel)

                // Dados
                foreach ($inscricoes as $inscricao) {
                    fputcsv($file, [
                        $inscricao->user->name,
                        $inscricao->user->email,
                        $inscricao->user->telefone ?? 'Não informado',
                        $inscricao->user->cpf ?? 'Não informado',
                        $inscricao->user->cidade ?? 'Não informado',
                        $inscricao->user->estado ?? 'Não informado',
                        $inscricao->created_at->format('d/m/Y H:i'),
                        'Inscrito'
                    ], ';');
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            \Log::error('Erro ao exportar inscrições: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Erro ao exportar inscrições: ' . $e->getMessage());
        }
    }

    /**
     * Dashboard de eventos (Admin)
     */
    public function dashboard()
    {
        $totalEventos = Evento::count();
        $eventosAtivos = Evento::where('status', 'ativo')->count();
        $eventosInativos = Evento::where('status', 'inativo')->count();
        $totalInscricoes = Inscricao::count();

        $eventosRecentes = Evento::withCount('inscricoes')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $eventosPopulares = Evento::withCount('inscricoes')
            ->orderBy('inscricoes_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.eventos.dashboard', compact(
            'totalEventos',
            'eventosAtivos',
            'eventosInativos',
            'totalInscricoes',
            'eventosRecentes',
            'eventosPopulares'
        ));
    }

    /**
     * Calendário de eventos (Admin)
     */
    public function calendario()
    {
        $eventos = Evento::where('status', 'ativo')
            ->where('data_evento', '>=', now())
            ->select('id', 'nome', 'data_evento', 'local')
            ->get()
            ->map(function ($evento) {
                return [
                    'id' => $evento->id,
                    'title' => $evento->nome,
                    'start' => $evento->data_evento->toIso8601String(),
                    'end' => $evento->data_evento->addHours(2)->toIso8601String(),
                    'local' => $evento->local,
                    'url' => route('admin.eventos.show', $evento->id)
                ];
            });

        return view('admin.eventos.calendario', compact('eventos'));
    }
}