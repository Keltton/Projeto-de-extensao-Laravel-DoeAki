<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DoeAki — Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <header class="bg-white border-bottom">
        <nav class="container navbar navbar-expand py-3">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">DoeAki</a>
            <div class="ms-auto">
                <a class="nav-link d-inline px-2" href="{{ route('home') }}">Início</a>
                <a class="btn btn-primary ms-2" href="/login">Login</a>
            </div>
        </nav>
    </header>

    <section class="bg-dark text-white">
        <div class="container py-5">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <h1 class="h2 fw-bold mb-2">Eventos de caridade</h1>
                    <p class="text-white-50 mb-3">Veja as campanhas ativas e faça login para participar com sua doação.</p>
                    <a class="btn btn-primary me-2" href="/login">Quero doar</a>
                    <a class="btn btn-outline-light" href="#eventos">Ver eventos</a>
                </div>
                <div class="col-lg-6">
                    <img class="img-fluid rounded" src="{{ asset('img/doacaoCaridade.png') }}" alt="Banner DoeAki">
                </div>
            </div>
        </div>
    </section>

    <main class="container my-5">
        <h2 id="eventos" class="h4 fw-bold mb-3">Doações disponíveis</h2>

        <div class="row g-4">
            {{-- CARD 1 --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100">
                    <img class="img-fluid rounded" src="{{ asset('img/agasalhos.png') }}" alt="Campanha de Agasalhos">
                    <div class="card-body">
                        <h3 class="h6 card-title mb-2">Campanha de Agasalhos</h3>
                        <p class="text-muted small mb-1">Data: 10/11/2025 • Local: Sede Central</p>
                        <p class="text-muted small mb-0">Traga casacos e cobertores para aquecer quem precisa.</p>
                    </div>
                    <div class="card-footer bg-white d-flex justify-content-end gap-2">
                        <a class="btn btn-outline-secondary btn-sm" href="/login">Detalhes</a>
                        <a class="btn btn-primary btn-sm" href="/login">Quero doar</a>
                    </div>
                </div>
            </div>

            {{-- CARD 2 --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100">
                    <img class="img-fluid rounded" src="{{ asset('img/brinquedos.png') }}" alt="Arrecadação de Brinquedos">
                    <div class="card-body">
                        <h3 class="h6 card-title mb-2">Arrecadação de Brinquedos</h3>
                        <p class="text-muted small mb-1">Data: 20/11/2025 • Local: Escola Comunitária</p>
                        <p class="text-muted small mb-0">Doe brinquedos em bom estado para alegrar crianças.</p>
                    </div>
                    <div class="card-footer bg-white d-flex justify-content-end gap-2">
                        <a class="btn btn-outline-secondary btn-sm" href="/login">Detalhes</a>
                        <a class="btn btn-primary btn-sm" href="/login">Quero doar</a>
                    </div>
                </div>
            </div>

            {{-- CARD 3 --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100">
                    <img class="img-fluid rounded" src="{{ asset('img/cestasBasicas.png') }}" alt="Mutirão Cestas Básicas">
                    <div class="card-body">
                        <h3 class="h6 card-title mb-2">Mutirão Cestas Básicas</h3>
                        <p class="text-muted small mb-1">Data: 05/12/2025 • Local: Centro Comunitário</p>
                        <p class="text-muted small mb-0">Ajude com alimentos não perecíveis para montagem de cestas.</p>
                    </div>
                    <div class="card-footer bg-white d-flex justify-content-end gap-2">
                        <a class="btn btn-outline-secondary btn-sm" href="/login">Detalhes</a>
                        <a class="btn btn-primary btn-sm" href="/login">Quero doar</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="border-top">
        <div class="container py-3">
            <small class="text-muted">© {{ date('Y') }} DoeAki — Conectando doadores e instituições.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>