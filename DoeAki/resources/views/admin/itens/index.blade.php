@extends('layouts.admin')

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1>Itens</h1>
            <p>Gerencie todos os Itens</p>
        </div>
        <a href="{{ route('admin.itens.create') }}" class="btn btn-primary">
            <i data-lucide="plus"></i> Novo Item
        </a>
    </div>
</div>

<div class="card p-4">
    <div class="table-responsive">
        <table class="table align-middle text-center">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Categoria</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($itens as $item)
                    <tr>
                        <td>{{ $item->nome }}</td>
                        <td>{{ $item->descricao }}</td>
                        <td>{{ $item->categoria->nome ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.itens.edit', $item) }}" class="btn btn-sm btn-warning me-1">Editar</a>
                            <form action="{{ route('admin.itens.destroy', $item) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Excluir este item?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
