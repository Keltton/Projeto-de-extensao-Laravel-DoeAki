@extends('layouts.app')

@section('title', 'Meus Eventos')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.perfil') ? 'active' : '' }}" href="{{ route('user.perfil') }}">
                            <i class="fas fa-user me-2"></i>Meu Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.doacoes.index') ? 'active' : '' }}" href="{{ route('user.doacoes.index') }}">
                            <i class="fas fa-hand-holding-heart me-2"></i>Minhas Doações
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.eventos.meus') ? 'active' : '' }}" href="{{ route('user.eventos.meus') }}">
                            <i class="fas fa-calendar-check me-2"></i>Meus Eventos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">
                            <i class="fas fa-home me-2"></i>Voltar para Home
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Conteúdo principal -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-calendar-check me-2"></i> Meus Eventos
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('eventos.index') }}" class="btn btn-outline-primary me-2">
                        <i class="fas fa-calendar me-1"></i> Ver Todos Eventos
                    </a>
                    <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Voltar ao Dashboard
                    </a>
                </div>
            </div>

            <!-- Mensagens -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($eventosPaginated->count() > 0)
                <div class="row">
                    @foreach($eventosPaginated as $evento)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card shadow-sm h-100">
                                @if($evento->imagem)
                                    <img src="{{ asset($evento->imagem) }}" 
                                         class="card-img-top" alt="{{ $evento->nome }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <i class="fas fa-calendar-alt fa-3x text-white"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title fw-bold text-primary">{{ $evento->nome }}</h5>
                                    <p class="card-text text-muted small mb-2">
                                        <i class="far fa-calendar me-1"></i>
                                        {{ $evento->data_evento->format('d/m/Y H:i') }}
                                    </p>
                                    <p class="card-text text-muted small mb-2">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ $evento->local }}
                                    </p>
                                    <p class="card-text">{{ \Illuminate\Support\Str::limit($evento->descricao, 100) }}</p>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-{{ $evento->status === 'ativo' ? 'success' : ($evento->status === 'inativo' ? 'secondary' : 'danger') }}">
                                            {{ ucfirst($evento->status) }}
                                        </span>
                                        <small class="text-muted">
                                            {{ $evento->data_evento->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                                <div class="card-footer bg-white">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('eventos.show', $evento->id) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye me-1"></i> Ver Detalhes
                                        </a>
                                        @if(in_array($evento->id, $userInscrito ?? []))
                                            <form method="POST" action="{{ route('user.eventos.cancelar', $evento->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger btn-sm w-100"
                                                        onclick="return confirm('Tem certeza que deseja cancelar sua inscrição?')">
                                                    <i class="fas fa-times me-1"></i> Cancelar Inscrição
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginação -->
                @if($eventosPaginated->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $eventosPaginated->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Você ainda não está inscrito em nenhum evento</h4>
                    <p class="text-muted mb-4">Explore os eventos disponíveis e faça sua inscrição.</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('eventos.index') }}" class="btn btn-primary">
                            <i class="fas fa-calendar me-1"></i> Explorar Eventos
                        </a>
                        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Voltar ao Dashboard
                        </a>
                    </div>
                </div>
            @endif
        </main>
    </div>
</div>
@endsection