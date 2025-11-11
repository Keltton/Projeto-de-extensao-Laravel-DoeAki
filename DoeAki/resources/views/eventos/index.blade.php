@extends('layouts.app')

@section('title', 'Todos os Eventos')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 fw-bold">
            <i class="bi bi-calendar-event me-2"></i>Todos os Eventos
        </h1>
        <a href="{{ url('/') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Voltar para Home
        </a>
    </div>

    <!-- Filtros de Busca -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('eventos.index') }}" class="row g-3">
                <div class="col-md-6">
                    <label for="search" class="form-label">Buscar Eventos</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           placeholder="Buscar por nome, descrição ou local..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <label for="data" class="form-label">Filtrar por Data</label>
                    <input type="date" class="form-control" id="data" name="data" 
                           value="{{ request('data') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i> Filtrar
                    </button>
                </div>
                @if(request()->has('search') || request()->has('data'))
                <div class="col-12">
                    <a href="{{ route('eventos.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-x-circle me-1"></i> Limpar Filtros
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($eventos->count() > 0)
        <div class="row g-4">
            @foreach($eventos as $evento)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 evento-card">
                        @if($evento->imagem)
                            <img src="{{ asset($evento->imagem) }}" class="card-img-top" alt="{{ $evento->nome }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="bi bi-calendar-event display-4"></i>
                            </div>
                        @endif
                        
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-{{ $evento->status == 'ativo' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($evento->status) }}
                                </span>
                                <small class="text-muted">{{ $evento->data_evento->diffForHumans() }}</small>
                            </div>

                            <h5 class="card-title fw-bold text-dark">{{ $evento->nome }}</h5>
                            <p class="text-muted small mb-1">
                                <i class="bi bi-calendar me-1"></i>{{ $evento->data_evento->format('d/m/Y H:i') }}
                            </p>
                            <p class="text-muted small mb-2">
                                <i class="bi bi-geo-alt me-1"></i>{{ $evento->local }}
                            </p>
                            <p class="card-text small text-muted">{{ \Illuminate\Support\Str::limit($evento->descricao, 100) }}</p>

                            @if($evento->vagas_total && $evento->vagas_total > 0)
                                <div class="mb-2">
                                    <small class="text-muted">
                                        Vagas: {{ $evento->vagas_disponiveis ?? $evento->vagas_total }} / {{ $evento->vagas_total }}
                                    </small>
                                    <div class="progress" style="height: 5px;">
                                        @php
                                            $vagasDisponiveis = $evento->vagas_disponiveis ?? $evento->vagas_total;
                                            $percentualVagas = $vagasDisponiveis > 0 ? ($vagasDisponiveis / $evento->vagas_total) * 100 : 0;
                                            $corProgresso = $percentualVagas > 50 ? 'success' : ($percentualVagas > 20 ? 'warning' : 'danger');
                                        @endphp
                                        <div class="progress-bar bg-{{ $corProgresso }}" style="width: {{ $percentualVagas }}%"></div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                            <a class="btn btn-outline-primary btn-sm" href="{{ route('eventos.show', $evento->id) }}">
                                <i class="bi bi-eye me-1"></i>Detalhes
                            </a>
                            
                            @auth
                                @php
                                    $userInscrito = auth()->user()->inscricoes()
                                        ->where('evento_id', $evento->id)
                                        ->where('status', 'confirmada')
                                        ->exists();
                                    $vagasDisponiveis = $evento->vagas_disponiveis ?? $evento->vagas_total;
                                    $temVagas = $vagasDisponiveis === null || $vagasDisponiveis > 0;
                                @endphp
                                
                                @if($userInscrito)
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>Inscrito
                                    </span>
                                @else
                                    <form method="POST" action="{{ route('user.eventos.inscrever', $evento->id) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-primary btn-sm"
                                                {{ !$temVagas || $evento->status != 'ativo' ? 'disabled' : '' }}>
                                            <i class="bi bi-check-circle me-1"></i>
                                            @if(!$temVagas)
                                                Lotado
                                            @elseif($evento->status != 'ativo')
                                                Indisponível
                                            @else
                                                Inscrever
                                            @endif
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a class="btn btn-primary btn-sm" href="{{ route('login') }}">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>Inscrever
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginação -->
        @if($eventos->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $eventos->appends(request()->query())->links() }}
            </div>
        @endif
    @else
        <div class="text-center py-5">
            <i class="bi bi-calendar-x display-1 text-muted mb-3"></i>
            <h4 class="text-muted">
                @if(request()->has('search') || request()->has('data'))
                    Nenhum evento encontrado com os filtros aplicados
                @else
                    Nenhum evento disponível no momento
                @endif
            </h4>
            <p class="text-muted mb-4">
                @if(request()->has('search') || request()->has('data'))
                    Tente ajustar os filtros de busca.
                @else
                    Volte em breve para conferir novos eventos.
                @endif
            </p>
            @if(request()->has('search') || request()->has('data'))
                <a href="{{ route('eventos.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-clockwise me-1"></i> Ver Todos os Eventos
                </a>
            @endif
        </div>
    @endif
</div>

<style>
    .evento-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: 1px solid #dee2e6;
    }
    .evento-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }
</style>
@endsection