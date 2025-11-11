@extends('layouts.app')

@section('title', $evento->nome)

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('eventos.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Voltar para Eventos
        </a>
        
        {{-- Botão simplificado apenas para login --}}
        @guest
            <a class="btn btn-primary btn-lg" href="{{ route('login') }}">
                <i class="bi bi-box-arrow-in-right me-1"></i> Fazer Login
            </a>
        @endguest
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

    <div class="row">
        <!-- Conteúdo Principal -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                @if($evento->imagem && file_exists(public_path($evento->imagem)))
                    <img src="{{ asset($evento->imagem) }}" class="card-img-top" alt="{{ $evento->nome }}" style="height: 400px; object-fit: cover;">
                @else
                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 300px;">
                        <div class="text-center">
                            <i class="bi bi-calendar-event display-1"></i>
                            <p class="mt-2">Sem imagem</p>
                        </div>
                    </div>
                @endif
                
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge bg-{{ $evento->status == 'ativo' ? 'success' : 'secondary' }} fs-6">
                            {{ ucfirst($evento->status) }}
                        </span>
                        <small class="text-muted">{{ $evento->data_evento->diffForHumans() }}</small>
                    </div>

                    <h1 class="h2 fw-bold mb-3 text-dark">{{ $evento->nome }}</h1>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <i class="bi bi-calendar text-primary me-2"></i>
                                <strong>Data e Hora:</strong><br>
                                {{ $evento->data_evento->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <i class="bi bi-geo-alt text-primary me-2"></i>
                                <strong>Local:</strong><br>
                                {{ $evento->local }}
                            </p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">Descrição do Evento</h5>
                        <p class="lead text-muted">{{ $evento->descricao }}</p>
                    </div>

                    @if($evento->vagas_total && $evento->vagas_total > 0)
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">Vagas Disponíveis</h5>
                            <div class="d-flex align-items-center mb-2">
                                <small class="text-muted me-3">
                                    {{ $evento->vagas_disponiveis ?? $evento->vagas_total }} de {{ $evento->vagas_total }} vagas
                                </small>
                                @php
                                    $vagasDisponiveis = $evento->vagas_disponiveis ?? $evento->vagas_total;
                                    $percentualVagas = $vagasDisponiveis > 0 ? ($vagasDisponiveis / $evento->vagas_total) * 100 : 0;
                                    $corProgresso = $percentualVagas > 50 ? 'success' : ($percentualVagas > 20 ? 'warning' : 'danger');
                                @endphp
                                <span class="badge bg-{{ $corProgresso }}">
                                    @if($percentualVagas > 80) Muitas vagas
                                    @elseif($percentualVagas > 40) Vagas limitadas
                                    @elseif($percentualVagas > 0) Últimas vagas
                                    @else Esgotado
                                    @endif
                                </span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-{{ $corProgresso }}" style="width: {{ $percentualVagas }}%"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informações</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="fw-bold">Organizador</h6>
                        <p class="mb-1">{{ $evento->user->name }}</p>
                        <small class="text-muted">Desde {{ $evento->created_at->format('m/Y') }}</small>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold">Status do Evento</h6>
                        <span class="badge bg-{{ $evento->status == 'ativo' ? 'success' : 'secondary' }}">
                            {{ ucfirst($evento->status) }}
                        </span>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold">Data de Criação</h6>
                        <p class="mb-0">{{ $evento->created_at->format('d/m/Y') }}</p>
                    </div>

                    @if($evento->inscricoes->count() > 0)
                        <div class="mb-3">
                            <h6 class="fw-bold">Inscritos</h6>
                            <p class="mb-0">{{ $evento->inscricoes->where('status', 'confirmada')->count() }} pessoa(s)</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection