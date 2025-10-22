<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use App\Models\SeuModelo; 

class EmpresaController extends Controller
{
    public function index()
    {
        //$Eventos = Evento::get();

        return view('empresa.dashboard');
    }
}


/*$dadosPorMes = SeuModelo::select(DB::raw('MONTH(created_at) as mes'), DB::raw('COUNT(*) as total'))
    ->groupBy('mes')
    ->orderBy('mes')
    ->get();

// Para formatar e passar para a view
$labels = [];
$valores = [];
foreach ($dadosPorMes as $dado) {
    $labels[] = $dado->mes;
    $valores[] = $dado->total;
}

return view('sua-view', compact('labels', 'valores'));*/