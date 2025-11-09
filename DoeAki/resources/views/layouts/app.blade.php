<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DoeAki - @yield('title', 'Home')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .navbar-brand {
            color: #dc3545 !important;
            font-weight: bold;
        }
        .sidebar {
            min-height: calc(100vh - 76px);
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .nav-link.active {
            background-color: #e9ecef;
            border-left: 4px solid #dc3545;
            font-weight: 600;
        }
        .card-border-left-primary { border-left: 4px solid #4e73df; }
        .card-border-left-success { border-left: 4px solid #1cc88a; }
        .card-border-left-info { border-left: 4px solid #36b9cc; }
        .card-border-left-warning { border-left: 4px solid #f6c23e; }
    </style>
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-white bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                <i class="bi bi-heart-fill me-2"></i>DoeAki
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                            <i class="bi bi-house me-1"></i>Início
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('eventos*') && !request()->is('user/eventos*') ? 'active' : '' }}" href="{{ route('eventos.index') }}">
                            <i class="bi bi-calendar-event me-1"></i>Eventos
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-2"></i>
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.perfil') }}">
                                        <i class="bi bi-person me-2"></i>Meu Perfil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.doacoes.index') }}">
                                        <i class="bi bi-gift me-2"></i>Minhas Doações
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('user.eventos.meus') }}">
                                        <i class="bi bi-calendar-check me-2"></i>Meus Eventos
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i>Sair
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Entrar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-primary ms-2" href="{{ route('register') }}">
                                <i class="bi bi-person-plus me-1"></i>Cadastrar
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-top mt-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="fw-bold text-danger">DoeAki</h5>
                    <p class="text-muted small mb-0">Conectando doadores e instituições para um mundo mais solidário.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-muted">© {{ date('Y') }} DoeAki — Todos os direitos reservados.</small>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Auto-dismiss alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                if (alert.classList.contains('show')) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 5000);
        });
    });
    </script>
    @yield('scripts')
</body>
</html>