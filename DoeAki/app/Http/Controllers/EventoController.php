<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EventoController extends Controller
{

    public function dashboard()
    {
        return view('empresa.dashboard');
    }

    public function lista()
    {

        $eventos = Evento::get();

        return view('empresa.evento.lista', [
            'Eventos' => $eventos
        ]);
    }

    public function detalhes(int $id)
    {
        $eventos = Evento::find($id);

        return view('empresa.evento.detalhes', [
            'Eventos' => $eventos
        ]);
    }

    public function adicionar()
    {
        return view('empresa.evento.adicionar');
    }


    public function gerenciar(int $id)
    {
        $eventos = Evento::find($id);

        return view('empresa.evento.gerenciar', [
            'Eventos' => $eventos
        ]);
    }

    public function update(Request $request, int $id)
    {
        $evento = Evento::find($id);

        if ($evento) {
            $request->validate([
                'img_path' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            ]);

            $eventos = $request->except('_token');

            $path = $request->file('img_path')->store('evento_images', 'public');

            $eventos['img_path'] = $path;

            $evento->update($eventos);
        }

        return redirect()->route('empresa.evento.lista');
    }

    public function destroy(int $id)
    {
        $evento = Evento::find($id);

        if ($evento) {
            $evento->delete();
        }

        return redirect()->route('empresa.evento.lista');
    }

    public function store(Request $request)
    {
        $eventos = $request->except('_token');

        $request->validate([
            'img_path' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $path = $request->file('img_path')->store('evento_images', 'public');


        $eventos['img_path'] = $path;

        Evento::create($eventos);


        return redirect()->route('empresa.evento.lista');
    }
}
