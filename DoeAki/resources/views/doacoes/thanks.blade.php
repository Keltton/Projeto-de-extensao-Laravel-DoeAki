<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Obrigado!</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <main class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-7">
        <div class="card shadow-sm">
          <div class="card-body p-5 text-center">
            <h1 class="fw-bold">Obrigado pela sua doação! ❤️</h1>
            @if(session('success'))
              <p class="text-success mt-2">{{ session('success') }}</p>
            @endif
            <p class="text-muted">A instituição entrará em contato se necessário.</p>
            <a href="{{ url('/') }}" class="btn btn-primary mt-2">Voltar ao início</a>
          </div>
        </div>
      </div>
    </div>
  </main>
</body>
</html>
