@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Categorias</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">Nova Categoria</a>
</div>

@if($categories->count() > 0)
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Itens</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description ?? '-' }}</td>
                    <td>{{ $category->items->count() }}</td>
                    <td>
                        <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">Excluir</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="alert alert-info">
        Nenhuma categoria encontrada.
    </div>
@endif
@endsection
