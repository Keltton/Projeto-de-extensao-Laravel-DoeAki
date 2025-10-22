<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doador;
use App\Services\ViaCepService;

class DoadorController extends Controller
{
    protected $viaCepService;

    public function __construct(ViaCepService $viaCepService)
    {
        $this->viaCepService = $viaCepService;
    }

    // Mostrar formulário de cadastro
    public function create()
    {
        return view('doador.create'); // resources/views/doador/create.blade.php
    }

    // Salvar doador no banco
    public function store(Request $request)
    {
        // Normaliza o CEP removendo caracteres não numéricos
        $cep = preg_replace('/\D/', '', $request->cep);

        // Validação básica
        $validated = $request->validate([
            'nome' => 'required|string|max:255',
            'cep' => 'required|string|size:8',
            'numero' => 'required|string|max:20',
            'complemento' => 'nullable|string|max:100',
            'telefone' => 'required|string|max:20',
        ]);

        $validated['cep'] = $cep;

        // Consulta ViaCEP
        $endereco = $this->viaCepService->getEndereco($cep);

        if (isset($endereco['erro']) && $endereco['erro'] === true) {
            return back()->withErrors(['cep' => $endereco['mensagem']])->withInput();
        }

        // Preencher campos do endereço
        $validated['endereco'] = $endereco['logradouro'] ?? '';
        $validated['bairro'] = $endereco['bairro'] ?? '';
        $validated['cidade'] = $endereco['localidade'] ?? '';
        $validated['estado'] = $endereco['uf'] ?? '';
        $validated['pais'] = 'Brasil';

        // Salvar no banco - Ainda não vou salvar
        //Doador::create($validated);

        return redirect()->route('doador.create')->with('success', 'Doador cadastrado com sucesso!');
    }

    // Buscar endereço pelo CEP (para o botão de JS)
    public function buscarEndereco($cep)
    {
        $cep = preg_replace('/\D/', '', $cep);
        $endereco = $this->viaCepService->getEndereco($cep);

        return response()->json($endereco);
    }
}
