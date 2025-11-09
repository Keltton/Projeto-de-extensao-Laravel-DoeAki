<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos os Eventos - DoeAki</title>
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
                            <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('user.perfil') }}">Meu Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Sair</button>
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

    <main class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 fw-bold">Todos os Eventos</h1>
            <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Voltar para Home
            </a>
        </div>

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

        @if($eventos->count() > 0)
            <div class="row g-4">
                @foreach($eventos as $evento)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 evento-card">
                            @if($evento->imagem)
                                <img src="{{ asset('storage/' . $evento->imagem) }}" class="card-img-top" alt="{{ $evento->titulo }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="bi bi-calendar-event display-4"></i>
                                </div>
                            @endif
                            
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-{{ $evento->status == 'ativo' ? 'success' : 'warning' }}">
                                        {{ ucfirst($evento->status) }}
                                    </span>
                                    <small class="text-muted">{{ $evento->data_evento->diffForHumans() }}</small>
                                </div>

                                <h5 class="card-title">{{ $evento->titulo }}</h5>
                                <p class="text-muted small mb-1">
                                    <i class="bi bi-calendar me-1"></i>{{ $evento->data_evento->format('d/m/Y H:i') }}
                                </p>
                                <p class="text-muted small mb-2">
                                    <i class="bi bi-geo-alt me-1"></i>{{ $evento->local }}
                                </p>
                                <p class="card-text small">{{ \Illuminate\Support\Str::limit($evento->descricao, 100) }}</p>

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

                            <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                                <a class="btn btn-outline-secondary btn-sm" href="{{ route('eventos.show', $evento->id) }}">
                                    Detalhes
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

            @if($eventos->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $eventos->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-x display-1 text-muted"></i>
                <h4 class="text-muted mt-3">Nenhum evento disponível</h4>
                <p class="text-muted">Volte em breve para conferir novos eventos.</p>
            </div>
        @endif
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