<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link rel="stylesheet" href=".\.\css\dashboard.css">
    @vite([ 'resources/js/app.js'])
</head>

<body>

    <!-- Eu sou horrivel com FrontEnd, então eu estou utilizando um exemplo para usar de base, o site que eu utilizei é o Codeply, oq não tem problema, melhor que GPT -->
    <!-- importante é entender (menos esses 50 css em cada div)-->

    <div class="container-fluid overflow-hidden">
        <div class="row vh-100 overflow-auto">
            <div class="col-12 col-sm-3 col-xl-2 px-sm-2 px-0 bg-dark d-flex sticky-top">
                <div class="d-flex flex-sm-column flex-row flex-grow-1 align-items-center align-items-sm-start px-3 pt-2 text-white">
                    <a href="/" class="d-flex align-items-center pb-sm-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5">D<span class="d-none d-sm-inline">oe</span>A<span class="d-none d-sm-inline">ki</span></span>
                    </a>

                    <!-- Sidebar começa aqui -->

                    <ul class="nav nav-pills flex-sm-column flex-row flex-nowrap flex-shrink-1 flex-sm-grow-0 flex-grow-1 mb-sm-auto mb-0 justify-content-center align-items-center align-items-sm-start" id="menu">

                        <!-- Cada Li é um item na sidebar -->

                        <li class="nav-item">
                            <a href="#" class="nav-link px-sm-0 px-2">
                                <i class="fs-5 bi-house"></i><span class="ms-1 d-none d-sm-inline">Tela inicial</span>
                            </a>
                        </li>

                        <!-- menu com dropdown de eventos na sidebar-->

                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle px-sm-0 px-1" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-calendar-event"></i>
                                <span class="ms-1 d-none d-sm-inline">Eventos</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown">
                                <li><a class="dropdown-item" href="#">Ver eventos</a></li>
                                <li><a class="dropdown-item" href="#">Novo evento</a></li>
                                <li><a class="dropdown-item" href="#">Gerenciar eventos</a></li>
                            </ul>
                        </li>

                        <!-- menu com dropdown de relatórios na sidebar-->

                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle px-sm-0 px-1" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-card-text"></i><span class="ms-1 d-none d-sm-inline">Relatórios</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown">
                                <li><a class="dropdown-item" href="#">Estoque</a></li>
                                <li><a class="dropdown-item" href="#">Doações</a></li>
                                <li><a class="dropdown-item" href="#">Recebidos</a></li>
                                <li><a class="dropdown-item" href="#">Geral</a></li>
                            </ul>
                        </li>
                    </ul>


                    <!--area do perfil na sidebar-->
                    <div class="dropdown py-sm-4 mt-sm-auto ms-auto ms-sm-0 flex-shrink-1">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://blog.agmar.com.br/wp-content/uploads/2018/07/Edif%C3%ADcio-Cristiane-Massud-Agmar.jpg" alt="hugenerd" width="28" height="28" class="rounded-circle">
                            <span class="d-none d-sm-inline mx-1">($NomeDaEmpresa)</span>
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
            </div>

            <div class="col d-flex flex-column h-sm-100">

                <!-- Aqui começa o conteudo da pagina -->

                <main class="row overflow-auto">

                    <div class="col pt-4">
                        <h1>Dashboard</h1>
                        <p>Bem vindo a sua dashboard! aqui voce pode gerenciar eventos, editar seu perfil e gerar relatórios!</p>
                    </div>


                    <!-- Graficos, o codigo de verdade está em js/app.js-->
                    <div class="card p-4 ">
                        <canvas id="eventosChart"></canvas>
                    </div>

                </main>

                <footer class="row bg-light py-4 mt-auto">
                    <div class="col"> Footer content here... </div>
                </footer>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>


</body>

</html>