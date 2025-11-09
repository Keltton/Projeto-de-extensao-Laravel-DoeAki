<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Painel Admin') - DoeAki</title>

    <!-- Ícones Lucide -->
    <script src="https://unpkg.com/lucide@latest" defer></script>
    
    <!-- CSS Centralizado -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Botão Mobile Menu -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle">
        <i data-lucide="menu"></i>
    </button>

    <aside class="sidebar" id="sidebar">
        <h2>DoeAki</h2>
        <p>{{ Auth::user()->name }}</p>

        <ul>
            <li>
                <a href="{{ route('admin.dashboard') }}" 
                   class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i data-lucide="home"></i> <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}" 
                   class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i data-lucide="users"></i> <span>Gerenciar Usuários</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categorias.index') }}" 
                   class="{{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}">
                    <i data-lucide="folder"></i> <span>Categorias</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.itens.index') }}" 
                   class="{{ request()->routeIs('admin.itens.*') ? 'active' : '' }}">
                    <i data-lucide="package"></i> <span>Itens</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.eventos.index') }}" 
                   class="{{ request()->routeIs('admin.eventos.*') ? 'active' : '' }}">
                    <i data-lucide="calendar"></i> <span>Eventos</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.relatorios.index') }}" 
                   class="{{ request()->routeIs('admin.relatorios.*') ? 'active' : '' }}">
                    <i data-lucide="bar-chart-3"></i> <span>Relatórios</span>
                </a>
            </li>
        </ul>

        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <i data-lucide="log-out"></i> <span>Sair</span>
            </button>
        </form>
    </aside>

    <main class="main-content" id="mainContent">
        @if(session('success'))
            <div class="alert alert-success" id="success-alert">
                {{ session('success') }}
            </div>
        @endif
        
        @yield('content')
    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            lucide.createIcons();

            // Mobile Menu Toggle
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');

            mobileMenuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('mobile-open');
                mainContent.classList.toggle('mobile-shift');
            });

            // Alert fade out após 3 segundos
            const alert = document.querySelector('.alert');
            if (alert) {
                setTimeout(() => {
                    alert.style.transition = "opacity 0.5s";
                    alert.style.opacity = 0;
                    setTimeout(() => alert.remove(), 500);
                }, 3000);
            }

            // Fechar menu ao clicar fora (mobile)
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(event.target) && !mobileMenuToggle.contains(event.target)) {
                        sidebar.classList.remove('mobile-open');
                        mainContent.classList.remove('mobile-shift');
                    }
                }
            });
        });

        // Atualizar ícones quando houver mudanças no DOM (para modais, etc.)
        document.addEventListener('DOMNodeInserted', function() {
            lucide.createIcons();
        });
    </script>

    <!-- Scripts específicos da página -->
    @stack('scripts')
</body>
</html>