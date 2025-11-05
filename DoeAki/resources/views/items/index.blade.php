@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-cube me-2"></i>Itens</h1>
    <a href="{{ route('items.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Novo Item
    </a>
</div>

@if($items->count() > 0)
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Preço</th>
                            <th>Categoria</th>
                            <th>Criado em</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td>#{{ $item->id }}</td>
                            <td>
                                <strong>{{ $item->name }}</strong>
                            </td>
                            <td>
                                @if($item->description)
                                    {{ Str::limit($item->description, 50) }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($item->price)
                                    <span class="badge bg-success">
                                        R$ {{ number_format($item->price, 2, ',', '.') }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $item->category->name }}</span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $item->created_at->format('d/m/Y') }}
                                </small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('items.show', $item) }}" class="btn btn-info"
                                       title="Ver detalhes">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('items.edit', $item) }}" class="btn btn-warning"
                                       title="Editar item">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('items.destroy', $item) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Tem certeza que deseja excluir este item?')"
                                                title="Excluir item">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Estatísticas -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h4>{{ $items->count() }}</h4>
                    <p class="mb-0">Total de Itens</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h4>R$ {{ number_format($items->sum('price'), 2, ',', '.') }}</h4>
                    <p class="mb-0">Valor Total</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h4>{{ $items->groupBy('category_id')->count() }}</h4>
                    <p class="mb-0">Categorias com Itens</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h4>{{ $items->where('price', '>', 0)->count() }}</h4>
                    <p class="mb-0">Itens com Preço</p>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-cube fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Nenhum item encontrado</h4>
            <p class="text-muted mb-4">Comece adicionando seu primeiro item ao sistema.</p>
            <a href="{{ route('items.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus me-2"></i>Criar Primeiro Item
            </a>
        </div>
    </div>
@endif
@endsection
