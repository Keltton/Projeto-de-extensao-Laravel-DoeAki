@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
</div>

<div class="row">
    <!-- Estatísticas -->
    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $categoriesCount ?? 0 }}</h4>
                        <p class="card-text">Categorias</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-folder fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $itemsCount ?? 0 }}</h4>
                        <p class="card-text">Itens</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-cube fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">R$ {{ number_format($totalValue ?? 0, 2, ',', '.') }}</h4>
                        <p class="card-text">Valor Total</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-dollar-sign fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title">{{ $avgItemsPerCategory ?? 0 }}</h4>
                        <p class="card-text">Média Itens/Cat</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-chart-bar fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-rocket"></i> Ações Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('categories.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus-circle"></i> Nova Categoria
                    </a>
                    <a href="{{ route('items.create') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-plus-square"></i> Novo Item
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history"></i> Atividade Recente
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item">
                        <i class="fas fa-folder text-primary"></i>
                        <strong>Categorias cadastradas:</strong> {{ $categoriesCount ?? 0 }}
                    </div>
                    <div class="list-group-item">
                        <i class="fas fa-cube text-success"></i>
                        <strong>Itens cadastrados:</strong> {{ $itemsCount ?? 0 }}
                    </div>
                    @if($recentItems && $recentItems->count() > 0)
                        <div class="list-group-item">
                            <i class="fas fa-clock text-info"></i>
                            <strong>Último item:</strong> {{ $recentItems->first()->name }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
