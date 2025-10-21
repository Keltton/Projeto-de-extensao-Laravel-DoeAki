<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>
<body>

<div class="container-fluid overflow-hidden">
    <div class="row vh-100 overflow-auto">
        <!-- Sidebar -->
        <div class="col-12 col-sm-3 col-xl-2 px-sm-2 px-0 bg-dark d-flex sticky-top">
            <div class="d-flex flex-sm-column flex-row flex-grow-1 align-items-center align-items-sm-start px-3 pt-2 text-white">
                <a href="/" class="d-flex align-items-center pb-sm-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5">D<span class="d-none d-sm-inline">oe</span>A<span class="d-none d-sm-inline">ki</span></span>
                </a>

                <!-- Menu da sidebar -->
                <ul class="nav nav-pills flex-sm-column flex-row flex-nowrap flex-shrink-1 flex-sm-grow-0 flex-grow-1 mb-sm-auto mb-0 justify-content-center align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                        <a href="/dashboard" class="nav-link px-sm-0 px-2">
                            <i class="fs-5 bi-house"></i><span class="ms-1 d-none d-sm-inline">Tela inicial</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="nav-link dropdown-toggle px-sm-0 px-1" data-bs-toggle="dropdown">
                            <i class="bi bi-calendar-event"></i>
                            <span class="ms-1 d-none d-sm-inline">Eventos</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                            <li><a class="dropdown-item" href="/eventos">Ver eventos</a></li>
                            <li><a class="dropdown-item" href="/gerenciar">Novo evento</a></li>
                            <li><a class="dropdown-item" href="/gerenciar">Gerenciar eventos</a></li>
                        </ul>
                    </li>
                </ul>


                <div class="dropdown py-sm-4 mt-sm-auto ms-auto ms-sm-0 flex-shrink-1">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="https://blog.agmar.com.br/wp-content/uploads/2018/07/Edif%C3%ADcio-Cristiane-Massud-Agmar.jpg" alt="perfil" width="28" height="28" class="rounded-circle">
                        <span class="d-none d-sm-inline mx-1">Empresa</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        <li><a class="dropdown-item" href="#">Perfil</a></li>
                        <li><a class="dropdown-item" href="#">Configurações</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Sair</a></li>
                    </ul>
                </div>

            </div>
        </div>


        <div class="col d-flex flex-column h-sm-100">
            <main class="row overflow-auto">
                @yield('content')
            </main>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
