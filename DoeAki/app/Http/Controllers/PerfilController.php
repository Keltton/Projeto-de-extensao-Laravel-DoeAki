<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perfil;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    public function index()
    {
        $perfil = Perfil::where('user_id', Auth::id())->first();
        return view('user.perfil', compact('perfil'));
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $data['possui_empresa'] = $request->has('possui_empresa');

        Perfil::updateOrCreate(
            ['user_id' => Auth::id()],
            $data
        );

        return redirect()->route('user.perfil')->with('success', 'Perfil atualizado com sucesso!');
    }
}
