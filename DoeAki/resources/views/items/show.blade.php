@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-cube me-2"></i>Detalhes do Item</h1>
        <div class="btn-group">
            <a href="{{ route('items.edit', $item) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i>Editar
            </a>
            <a href="{{ route('items.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Voltar
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Informações do Item</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Nome:</th>
                                    <td>{{ $item->name }}</td>
                                </tr>
                                <tr>
                                    <th>Categoria:</th>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $item->category->name }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Preço:</th>
                                    <td>
                                        @if($item->price)
                                            <span class="text-success fw-bold">
                                                R$ {{ number_format($item->price, 2, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="text-muted">Não informado</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">ID:</th>
                                    <td>#{{ $item->id }}</td>
                                </tr>
                                <tr>
                                    <th>Criado em:</th>
                                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Atualizado em:</th>
                                    <td>{{ $item->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($item->description)
                    <div class="mt-3">
                        <h6>Descrição:</h6>
                        <div class="border p-3 rounded bg-light">
                            {{ $item->description }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">Ações</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('items.edit', $item) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i>Editar Item
                        </a>
                        <form action="{{ route('items.destroy', $item) }}" method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este item?')">
                                <i class="fas fa-trash me-1"></i>Excluir Item
                            </button>
                        </form>
                        <a href="{{ route('items.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Novo Item
                        </a>
                        <a href="{{ route('items.index') }}" class="btn btn-secondary">
                            <i class="fas fa-list me-1"></i>Ver Todos os Itens
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">Informações da Categoria</h5>
                </div>
                <div class="card-body">
                    <h6>{{ $item->category->name }}</h6>
                    @if($item->category->description)
                        <p class="text-muted small">{{ $item->category->description }}</p>
                    @else
                        <p class="text-muted small">Sem descrição</p>
                    @endif
                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>
                            Criada em: {{ $item->category->created_at->format('d/m/Y') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
