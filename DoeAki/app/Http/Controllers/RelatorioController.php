<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Item;
use App\Models\Categoria;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RelatorioController extends Controller
{
    public function index()
    {
        return view('admin.relatorios.index');
    }

    public function dashboardData(Request $request)
    {
        $periodo = $request->get('periodo', '30dias'); // 7dias, 30dias, 90dias, 1ano

        $data = [
            'estatisticas_gerais' => $this->getEstatisticasGerais(),
            'itens_por_categoria' => $this->getItensPorCategoria(),
            'eventos_por_mes' => $this->getEventosPorMes($periodo),
            'usuarios_por_mes' => $this->getUsuariosPorMes($periodo),
            'itens_por_mes' => $this->getItensPorMes($periodo),
            'top_categorias' => $this->getTopCategorias(),
            'eventos_proximos' => $this->getEventosProximos(),
        ];

        return response()->json($data);
    }

    private function getEstatisticasGerais()
    {
        return [
            'total_usuarios' => User::count(),
            'total_itens' => Item::count(),
            'total_categorias' => Categoria::count(),
            'total_eventos' => Evento::count(),
            'itens_ativos' => Item::count(), // Adapte conforme sua lógica de ativo/inativo
            'eventos_ativos' => Evento::where('status', 'ativo')->count(),
        ];
    }

    private function getItensPorCategoria()
    {
        return Categoria::withCount('itens')
            ->orderBy('itens_count', 'desc')
            ->get()
            ->map(function ($categoria) {
                return [
                    'categoria' => $categoria->nome,
                    'quantidade' => $categoria->itens_count
                ];
            });
    }

    private function getEventosPorMes($periodo)
    {
        $dataInicio = $this->getDataInicioPorPeriodo($periodo);

        return Evento::select(
                DB::raw('MONTH(created_at) as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', $dataInicio)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->map(function ($item) {
                return [
                    'mes' => $this->getNomeMes($item->mes),
                    'quantidade' => $item->total
                ];
            });
    }

    private function getUsuariosPorMes($periodo)
    {
        $dataInicio = $this->getDataInicioPorPeriodo($periodo);

        return User::select(
                DB::raw('MONTH(created_at) as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', $dataInicio)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->map(function ($item) {
                return [
                    'mes' => $this->getNomeMes($item->mes),
                    'quantidade' => $item->total
                ];
            });
    }

    private function getItensPorMes($periodo)
    {
        $dataInicio = $this->getDataInicioPorPeriodo($periodo);

        return Item::select(
                DB::raw('MONTH(created_at) as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', $dataInicio)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->map(function ($item) {
                return [
                    'mes' => $this->getNomeMes($item->mes),
                    'quantidade' => $item->total
                ];
            });
    }

    private function getTopCategorias()
    {
        return Categoria::withCount('itens')
            ->orderBy('itens_count', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($categoria) {
                return [
                    'nome' => $categoria->nome,
                    'quantidade_itens' => $categoria->itens_count
                ];
            });
    }

    private function getEventosProximos()
    {
        return Evento::where('data_evento', '>=', now())
            ->where('status', 'ativo')
            ->orderBy('data_evento')
            ->limit(5)
            ->get(['nome', 'data_evento', 'local']);
    }

    private function getDataInicioPorPeriodo($periodo)
    {
        return match($periodo) {
            '7dias' => Carbon::now()->subDays(7),
            '30dias' => Carbon::now()->subDays(30),
            '90dias' => Carbon::now()->subDays(90),
            '1ano' => Carbon::now()->subYear(),
            default => Carbon::now()->subDays(30),
        };
    }

    private function getNomeMes($numeroMes)
    {
        $meses = [
            1 => 'Jan', 2 => 'Fev', 3 => 'Mar', 4 => 'Abr',
            5 => 'Mai', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
            9 => 'Set', 10 => 'Out', 11 => 'Nov', 12 => 'Dez'
        ];
        
        return $meses[$numeroMes] ?? 'Unknown';
    }
}