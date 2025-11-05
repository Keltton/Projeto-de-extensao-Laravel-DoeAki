@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalhes da Categoria</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $category->name }}</h5>
            <p class="card-text">{{ $category->description ?? 'Sem descrição' }}</p>
            <p class="card-text"><small class="text-muted">Criado em: {{ $category->created_at->format('d/m/Y H:i') }}</small></p>
        </div>
    </div>

    <div class="mt-4">
        <h3>Itens nesta categoria ({{ $category->items->count() }})</h3>

        @if($category->items->count() > 0)
            <div class="list-group mt-3">
                @foreach($category->items as $item)
                <div class="list-group-item">
                    <h5>{{ $item->name }}</h5>
                    <p>{{ $item->description }}</p>
                    @if($item->price)
                        <span class="badge bg-success">R$ {{ number_format($item->price, 2, ',', '.') }}</span>
                    @endif
                </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info mt-3">
                Nenhum item nesta categoria.
            </div>
        @endif
    </div>

    <div class="mt-3">
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Voltar</a>
        <a href="{{ route('items.create') }}?category_id={{ $category->id }}" class="btn btn-primary">Adicionar Item</a>
    </div>
</div>
@endsection
