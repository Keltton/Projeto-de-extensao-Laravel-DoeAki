<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    // Aplica middleware de admin
    public function __construct()
    {
        $this->middleware('isAdmin'); // Apenas admins podem acessar
    }

    /**
     * Listar todas as categorias
     */
    public function index()
    {
        $categorias = Categoria::all(); // ou paginate(15) se preferir paginação
        return view('admin.categorias.index', compact('categorias'));
    }

    /**
     * Mostrar formulário para criar nova categoria
     */
    public function create()
    {
        return view('admin.categorias.create');
    }

    /**
     * Salvar nova categoria
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:1000',
        ]);

        Categoria::create($request->only('nome', 'descricao'));

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoria criada com sucesso!');
    }

    /**
     * Mostrar formulário para editar categoria existente
     */
    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id);
        return view('admin.categorias.edit', compact('categoria'));
    }

    /**
     * Atualizar categoria
     */
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string|max:1000',
        ]);

        $categoria->update($request->only('nome', 'descricao'));

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoria atualizada com sucesso!');
    }

    /**
     * Excluir categoria
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoria excluída com sucesso!');
    }

    /**
     * Mostrar detalhes da categoria
     */
    public function show(Categoria $categoria)
    {
        return view('admin.categorias.show', compact('categoria'));
    }
}
