<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // Mostra o formulário
    public function create()
    {
        return view('clientes.create');
    }

    // Recebe os dados do formulário
    public function store(Request $request)
    {
        // Salvar no banco, por exemplo:
        // Cliente::create($request->all());

        return redirect()->route('clientes.create')->with('success', 'Doador cadastrado com sucesso!');
    }
}
