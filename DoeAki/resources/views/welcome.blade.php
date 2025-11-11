<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DoeAki — Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .evento-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .evento-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .badge-status {
            font-size: 0.7rem;
        }
    </style>
</head>

<body class="bg-light">

    <header class="bg-white border-bottom">
        <nav class="container navbar navbar-expand py-3">
            <a class="navbar-brand fw-bold text-danger" href="{{ url('/') }}">
                <i class="bi bi-heart-fill me-1"></i>DoeAki
            </a>
            <div class="ms-auto">
                <a class="nav-link d-inline px-2" href="{{ url('/') }}">Início</a>
                <a class="nav-link d-inline px-2" href="{{ route('sobre') }}">Sobre</a>
                @auth
                    <div class="dropdown d-inline">
                        <a class="btn btn-outline-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('user.perfil') }}">
                                <i class="bi bi-person me-2"></i>Meu Perfil
                            </a></li>
                            
                            <li><hr class="dropdown-divider"></li>
                            <li><h6 class="dropdown-header">Eventos</h6></li>
                            <li><a class="dropdown-item" href="{{ route('user.eventos.meus') }}">
                                <i class="bi bi-calendar-check me-2"></i>Meus Eventos
                            </a></li>
                            <li><a class="dropdown-item" href="{{ route('eventos.index') }}">
                                <i class="bi bi-calendar-event me-2"></i>Explorar Eventos
                            </a></li>
                            
                            @if(Route::has('user.doacoes.index'))
                            <li><hr class="dropdown-divider"></li>
                            <li><h6 class="dropdown-header">Doações</h6></li>
                            <li><a class="dropdown-item" href="{{ route('user.doacoes.index') }}">
                                <i class="bi bi-gift me-2"></i>Minhas Doações
                            </a></li>
                            @endif
                            
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Sair
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a class="btn btn-outline-primary me-2" href="{{ route('login') }}">Login</a>
                    <a class="btn btn-primary" href="{{ route('register') }}">Cadastrar</a>
                @endauth
            </div>
        </nav>
    </header>

    <section class="bg-dark text-white">
        <div class="container py-5">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <h1 class="h2 fw-bold mb-2">Eventos de caridade</h1>
                    <p class="text-white-50 mb-3">Veja as campanhas ativas e faça login para participar com sua doação.</p>
                    @auth
                        <a class="btn btn-primary me-2" href="{{ route('user.doacoes.create') }}">Fazer Doação</a>
                    @else
                        <a class="btn btn-primary me-2" href="{{ route('register') }}">Quero doar</a>
                    @endauth
                    <a class="btn btn-outline-light" href="#eventos">Ver eventos</a>
                </div>
                <div class="col-lg-6">
                    <img class="img-fluid rounded" src="{{ asset('img/doacaoCaridade.png') }}" alt="Banner DoeAki">
                </div>
            </div>
        </div>
    </section>

    <main class="container my-5">
        <h2 id="eventos" class="h4 fw-bold mb-4">Eventos em Destaque</h2>

        {{-- Mensagens de sucesso/erro --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Verifica se $eventos existe e tem dados --}}
        @isset($eventos)
            @if($eventos->count() > 0)
                <div class="row g-4">
                    @foreach($eventos->take(3) as $evento)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 evento-card">
                                {{-- Imagem do evento --}}
                                @if($evento->imagem && file_exists(public_path($evento->imagem)))
                                    <img src="{{ asset($evento->imagem) }}" class="card-img-top" alt="{{ $evento->nome }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                                        <div class="text-center">
                                            <i class="bi bi-calendar-event display-4"></i>
                                            <p class="mt-2 small">Sem imagem</p>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="card-body">
                                    {{-- Status do evento --}}
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge bg-{{ $evento->status == 'ativo' ? 'success' : ($evento->status == 'inativo' ? 'warning' : 'danger') }} badge-status">
                                            {{ ucfirst($evento->status) }}
                                        </span>
                                        @if($evento->data_evento > now())
                                            <small class="text-muted">{{ $evento->data_evento->diffForHumans() }}</small>
                                        @endif
                                    </div>

                                    {{-- Título e descrição --}}
                                    <h3 class="h6 card-title mb-2">{{ $evento->nome }}</h3>
                                    <p class="text-muted small mb-1">
                                        <i class="bi bi-calendar me-1"></i>{{ $evento->data_evento->format('d/m/Y H:i') }}
                                    </p>
                                    <p class="text-muted small mb-2">
                                        <i class="bi bi-geo-alt me-1"></i>{{ $evento->local }}
                                    </p>
                                    <p class="card-text small">{{ Str::limit($evento->descricao, 100) }}</p>

                                    {{-- Vagas disponíveis --}}
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
                                                <div class="progress-bar bg-{{ $corProgresso }}" 
                                                    style="width: {{ $percentualVagas }}%">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                {{-- APENAS BOTÃO DETALHES --}}
                                <div class="card-footer bg-white text-center">
                                    <a class="btn btn-primary btn-sm" 
                                       href="{{ route('eventos.show', $evento->id) }}">
                                        <i class="bi bi-eye me-1"></i>Ver Detalhes
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Link para ver todos os eventos --}}
                <div class="text-center mt-4">
                    <a href="{{ route('eventos.index') }}" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-list-ul me-2"></i>Ver Todos os {{ $eventos->count() }} Eventos
                    </a>
                </div>

            @else
                {{-- Se não há eventos --}}
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="bi bi-calendar-x display-1 text-muted"></i>
                        <h4 class="text-muted mt-3">Nenhum evento disponível no momento</h4>
                        <p class="text-muted">Volte em breve para conferir novas oportunidades de doação.</p>
                        @auth
                            <a href="{{ route('eventos.index') }}" class="btn btn-primary mt-3">
                                Ver Todos os Eventos
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        @else
            {{-- Se $eventos não foi definida --}}
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="bi bi-exclamation-triangle display-1 text-warning"></i>
                    <h4 class="text-muted mt-3">Sistema em configuração</h4>
                    <p class="text-muted">Os eventos estarão disponíveis em breve.</p>
                </div>
            </div>
        @endisset
    </main>

    <footer class="border-top bg-white mt-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="fw-bold">DoeAki</h5>
                    <p class="text-muted small">Conectando doadores e instituições para um mundo mais solidário.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-muted">© {{ date('Y') }} DoeAki — Todos os direitos reservados.</small>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>