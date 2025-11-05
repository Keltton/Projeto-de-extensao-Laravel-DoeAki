    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <style>
            @import url('https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&display=swap');
        </style>
        @vite([ 'resources/css/empresa/style.css'])
        @vite([ 'resources/js/app.js'])
    </head>

    <body>

        <div class="sidebar">
            <a href="/" class="d-flex align-items-center mb-3 text-white text-decoration-none">
                <span class="fs-5">D<span class="d-none d-sm-inline">oe</span>A<span class="d-none d-sm-inline">ki</span></span>
            </a>

            <ul class="nav nav-pills flex-column mb-auto" id="menu">
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link text-white">
                        <i class="fs-5 bi-house"></i><span class="ms-2">Tela inicial</span>
                    </a>
                </li>

                <li class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle text-white" id="dropdown" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-calendar-event"></i><span class="ms-2">Eventos</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown">
                        <li><a class="dropdown-item" href="{{ route('empresa.evento.lista') }}">Ver eventos</a></li>
                        <li><a class="dropdown-item" href="{{ route('empresa.evento.adicionar') }}">Novo evento</a></li>
                        <li><a class="dropdown-item" href="{{ route('empresa.evento.lista') }}">Gerenciar eventos</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="nav-link dropdown-toggle text-white" id="dropdown" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-card-text"></i><span class="ms-2">Relatórios</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown">
                        <li><a class="dropdown-item" href="/estoque">Estoque</a></li>
                        <li><a class="dropdown-item" href="/doacoes">Doações</a></li>
                        <li><a class="dropdown-item" href="/recebido">Recebidos</a></li>
                        <li><a class="dropdown-item" href="/geral">Geral</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="/cadastro" class="nav-link text-white">
                        <i class="bi bi-plus-square"></i><span class="ms-2">Cadastro de itens</span>
                    </a>
                </li>
            </ul>

            <div class="dropdown mt-auto">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img
                        src="https://blog.agmar.com.br/wp-content/uploads/2018/07/Edif%C3%ADcio-Cristiane-Massud-Agmar.jpg"
                        alt="hugenerd" width="28" height="28" class="rounded-circle me-2">
                    <span>($NomeDaEmpresa)</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="#">Perfil</a></li>
                    <li><a class="dropdown-item" href="#">Configurações</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Sair</a></li>
                </ul>
            </div>
        </div>
        <div class="content">
            @yield('content')
        </div>
        </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        </script>


    </body>

    </html>