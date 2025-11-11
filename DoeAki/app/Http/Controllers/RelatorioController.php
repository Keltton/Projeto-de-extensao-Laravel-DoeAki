<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Categoria;
use App\Models\Evento;
use App\Models\Doacao;
use App\Models\Inscricao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class RelatorioController extends Controller
{
    /**
     * Página inicial de relatórios
     */
    public function index()
    {
        $estatisticas = $this->getEstatisticasGerais();
        return view('admin.relatorios.index', compact('estatisticas'));
    }

    /**
     * Dashboard de relatórios
     */
    public function dashboard()
    {
        $estatisticas = $this->getEstatisticasGerais();
        $estatisticasDoacoes = $this->getEstatisticasDoacoes();
        $estatisticasUsuarios = $this->getEstatisticasUsuarios();
        $estatisticasItens = $this->getEstatisticasItens();
        $estatisticasEventos = $this->getEstatisticasEventos();
        
        return view('admin.relatorios.dashboard', compact(
            'estatisticas', 
            'estatisticasDoacoes', 
            'estatisticasUsuarios', 
            'estatisticasItens', 
            'estatisticasEventos'
        ));
    }

    /**
     * Relatório de doações
     */
    public function doacoes(Request $request)
    {
        try {
            $query = Doacao::with(['user', 'item.categoria']);
            
            // Filtros
            if ($request->has('status') && $request->status != '') {
                if ($request->status === 'entregue') {
                    $query->where('entregue', true);
                } else {
                    $query->where('status', $request->status);
                }
            }
            
            if ($request->has('data_inicio') && $request->data_inicio != '') {
                $query->whereDate('created_at', '>=', $request->data_inicio);
            }
            
            if ($request->has('data_fim') && $request->data_fim != '') {
                $query->whereDate('created_at', '<=', $request->data_fim);
            }

            $doacoes = $query->orderBy('created_at', 'desc')->get();
            $estatisticas = $this->getEstatisticasDoacoes();

            return view('admin.relatorios.doacoes', compact('doacoes', 'estatisticas'));

        } catch (\Exception $e) {
            return redirect()->route('admin.relatorios.index')
                ->with('error', 'Erro ao carregar relatório de doações: ' . $e->getMessage());
        }
    }

    /**
     * Relatório de usuários
     */
    public function usuarios(Request $request)
    {
        try {
            $query = User::withCount(['doacoes', 'inscricoes']);
            
            if ($request->has('tipo') && $request->tipo != '') {
                $query->where('role', $request->tipo);
            }

            if ($request->has('status') && $request->status != '') {
                if ($request->status === 'completo') {
                    $query->where('cadastro_completo', true);
                } else {
                    $query->where('cadastro_completo', false);
                }
            }

            $usuarios = $query->orderBy('created_at', 'desc')->get();
            $estatisticas = $this->getEstatisticasUsuarios();

            return view('admin.relatorios.usuarios', compact('usuarios', 'estatisticas'));

        } catch (\Exception $e) {
            return redirect()->route('admin.relatorios.index')
                ->with('error', 'Erro ao carregar relatório de usuários: ' . $e->getMessage());
        }
    }

    /**
     * Relatório de itens
     */
    public function itens(Request $request)
    {
        try {
            $query = Item::with(['categoria']);
            
            if ($request->has('categoria_id') && $request->categoria_id != '') {
                $query->where('categoria_id', $request->categoria_id);
            }

            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }

            $itens = $query->withCount(['doacoes as total_doacoes'])
                ->withSum(['doacoes as quantidade_total' => function($query) {
                    $query->whereIn('status', ['aceita', 'aprovado']);
                }], 'quantidade')
                ->orderBy('nome')
                ->get();

            $categorias = Categoria::all();
            $estatisticas = $this->getEstatisticasItens();

            return view('admin.relatorios.itens', compact('itens', 'categorias', 'estatisticas'));

        } catch (\Exception $e) {
            return redirect()->route('admin.relatorios.index')
                ->with('error', 'Erro ao carregar relatório de itens: ' . $e->getMessage());
        }
    }

    /**
     * Relatório de eventos
     */
    public function eventos(Request $request)
    {
        try {
            $query = Evento::with(['user'])->withCount('inscricoes');
            
            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }

            if ($request->has('periodo') && $request->periodo != '') {
                if ($request->periodo === 'futuros') {
                    $query->where('data_evento', '>=', now());
                } elseif ($request->periodo === 'passados') {
                    $query->where('data_evento', '<', now());
                }
            }

            $eventos = $query->orderBy('data_evento', 'desc')->get();
            $estatisticas = $this->getEstatisticasEventos();

            return view('admin.relatorios.eventos', compact('eventos', 'estatisticas'));

        } catch (\Exception $e) {
            return redirect()->route('admin.relatorios.index')
                ->with('error', 'Erro ao carregar relatório de eventos: ' . $e->getMessage());
        }
    }

    /**
     * Exportar relatórios
     */
    public function exportar($tipo)
    {
        try {
            switch ($tipo) {
                case 'doacoes':
                    $data = Doacao::with(['user', 'item.categoria'])->get();
                    $fileName = 'relatorio_doacoes_' . date('Y-m-d') . '.csv';
                    break;
                    
                case 'usuarios':
                    $data = User::withCount(['doacoes', 'inscricoes'])->get();
                    $fileName = 'relatorio_usuarios_' . date('Y-m-d') . '.csv';
                    break;
                    
                case 'itens':
                    $data = Item::with(['categoria'])->get();
                    $fileName = 'relatorio_itens_' . date('Y-m-d') . '.csv';
                    break;
                    
                case 'eventos':
                    $data = Evento::with(['user'])->withCount('inscricoes')->get();
                    $fileName = 'relatorio_eventos_' . date('Y-m-d') . '.csv';
                    break;
                    
                default:
                    return redirect()->back()->with('error', 'Tipo de relatório não suportado');
            }

            $headers = [
                'Content-Type' => 'text/csv; charset=utf-8',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ];

            $callback = function () use ($data, $tipo) {
                $file = fopen('php://output', 'w');
                fwrite($file, "\xEF\xBB\xBF"); // UTF-8 BOM

                switch ($tipo) {
                    case 'doacoes':
                        fputcsv($file, ['Item', 'Doador', 'Categoria', 'Quantidade', 'Status', 'Data'], ';');
                        foreach ($data as $doacao) {
                            fputcsv($file, [
                                $doacao->item->nome ?? 'N/A',
                                $doacao->user->name,
                                $doacao->item->categoria->nome ?? 'N/A',
                                $doacao->quantidade,
                                $doacao->status,
                                $doacao->created_at->format('d/m/Y H:i')
                            ], ';');
                        }
                        break;
                        
                    case 'usuarios':
                        fputcsv($file, ['Nome', 'Email', 'Tipo', 'Doações', 'Inscrições', 'Data Cadastro'], ';');
                        foreach ($data as $usuario) {
                            fputcsv($file, [
                                $usuario->name,
                                $usuario->email,
                                $usuario->role,
                                $usuario->doacoes_count,
                                $usuario->inscricoes_count,
                                $usuario->created_at->format('d/m/Y')
                            ], ';');
                        }
                        break;
                        
                    case 'itens':
                        fputcsv($file, ['Nome', 'Categoria', 'Status', 'Quantidade Disponível', 'Data Criação'], ';');
                        foreach ($data as $item) {
                            fputcsv($file, [
                                $item->nome,
                                $item->categoria->nome ?? 'N/A',
                                $item->status,
                                $item->quantidade,
                                $item->created_at->format('d/m/Y')
                            ], ';');
                        }
                        break;
                        
                    case 'eventos':
                        fputcsv($file, ['Título', 'Organizador', 'Data Evento', 'Local', 'Status', 'Inscrições'], ';');
                        foreach ($data as $evento) {
                            fputcsv($file, [
                                $evento->titulo,
                                $evento->user->name,
                                $evento->data_evento->format('d/m/Y H:i'),
                                $evento->local,
                                $evento->status,
                                $evento->inscricoes_count
                            ], ';');
                        }
                        break;
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao exportar relatório: ' . $e->getMessage());
        }
    }

    /**
     * Métodos auxiliares para estatísticas
     */
    private function getEstatisticasGerais()
    {
        return [
            'total_usuarios' => User::count(),
            'total_doacoes' => Doacao::count(),
            'total_itens' => Item::count(),
            'total_eventos' => Evento::count(),
            'doacoes_hoje' => Doacao::whereDate('created_at', today())->count(),
            'novos_usuarios_hoje' => User::whereDate('created_at', today())->count(),
        ];
    }

    private function getEstatisticasDoacoes()
    {
        $hasEntregueColumn = Schema::hasColumn('doacoes', 'entregue');
        
        return [
            'total' => Doacao::count(),
            'aprovadas' => Doacao::whereIn('status', ['aceita', 'aprovado'])->count(),
            'pendentes' => Doacao::where('status', 'pendente')->count(),
            'rejeitadas' => Doacao::whereIn('status', ['rejeitada', 'rejeitado'])->count(),
            'entregues' => $hasEntregueColumn ? Doacao::where('entregue', true)->count() : 0,
            'doacoes_este_mes' => Doacao::whereMonth('created_at', now()->month)->count(),
            'doacoes_semana' => Doacao::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];
    }

    private function getEstatisticasUsuarios()
    {
        return [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'usuarios' => User::where('role', 'user')->count(),
            'cadastro_completo' => User::where('cadastro_completo', true)->count(),
            'novos_este_mes' => User::whereMonth('created_at', now()->month)->count(),
        ];
    }

    private function getEstatisticasItens()
    {
        $itensComDoacoes = Item::whereHas('doacoes', function($query) {
            $query->whereIn('status', ['aceita', 'aprovado']);
        })->count();

        $totalQuantidadeDoada = Doacao::whereIn('status', ['aceita', 'aprovado'])->sum('quantidade');

        return [
            'total_itens' => Item::count(),
            'itens_ativos' => Item::where('status', 'ativo')->count(),
            'itens_inativos' => Item::where('status', 'inativo')->count(),
            'categorias_count' => Categoria::count(),
            'itens_com_doacoes' => $itensComDoacoes,
            'total_quantidade_doada' => $totalQuantidadeDoada,
        ];
    }

    private function getEstatisticasEventos()
    {
        return [
            'total_eventos' => Evento::count(),
            'eventos_ativos' => Evento::where('status', 'ativo')->count(),
            'eventos_futuros' => Evento::where('data_evento', '>=', now())->count(),
            'eventos_passados' => Evento::where('data_evento', '<', now())->count(),
            'total_inscricoes' => Inscricao::count(),
        ];
    }
}