<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function lista()
    {
        //$Eventos = Evento::get();

        return view('empresa.evento.lista');
    }

    public function adicionar()
    {
        return view('empresa.evento.adicionar');
    }

    public function gerenciar()
    {
        //$Eventos = Evento::find($id);

        return view('empresa.evento.gerenciar');
    }

    public function store(Request $request)
    {
        // $dados = $request->except('_token');

        // Evento::create($dados);

        // return redirect()->route('empresa.evento.lista');
    }

    public function edit(int $id)
    {
        //$evento =  Evento::find($id);

        // return view('eventos.edit',[
        //      'evento' => $evento
        // ]);
    }
}
