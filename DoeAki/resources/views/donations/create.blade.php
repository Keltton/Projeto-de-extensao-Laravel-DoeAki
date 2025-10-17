<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Fazer uma Doação</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- Bootstrap 5 – CDN (rápido e prático) --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body { background: #f8fafc; }
    .brand { font-weight: 800; letter-spacing: .3px; }
    .card { border: 1px solid #e9eef5; border-radius: 14px; }
    .form-label { font-weight: 600; }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg bg-white border-bottom">
    <div class="container">
      <a class="navbar-brand brand" href="{{ url('/') }}">DoeAki</a>
    </div>
  </nav>

  <main class="container py-4">
    <div class="row justify-content-center">
      <div class="col-lg-8">

        <div class="text-center mb-4">
          <h1 class="fw-bold">Fazer uma Doação</h1>
          <p class="text-muted mb-0">Preencha as informações para registrar sua doação e ajudar quem precisa.</p>
        </div>

        @if ($errors->any())
          <div class="alert alert-danger">
            <strong>Ops!</strong> Corrija os campos abaixo.
            <ul class="mb-0">
              @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('donations.store') }}" method="POST" class="card shadow-sm">
          @csrf
          <div class="card-body p-4">
            <h5 class="mb-3">Sobre o item</h5>

            <div class="row g-3">
              <div class="col-md-8">
                <label class="form-label">Categoria do item *</label>
                <input type="text" name="item_category" class="form-control" placeholder="Roupas, Alimentos, Eletrônicos..." required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Quantidade *</label>
                <input type="number" min="1" value="1" name="quantity" class="form-control" required>
              </div>
            </div>

            <div class="mt-3">
              <label class="form-label">Condição</label>
              <input type="text" name="condition" class="form-control" placeholder="Novo, Usado, etc.">
            </div>

            <hr class="my-4">

            <h5 class="mb-3">Dados do doador</h5>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Nome *</label>
                <input type="text" name="donor_name" class="form-control" required>
              </div>
              <div class="col-md-3">
                <label class="form-label">E-mail</label>
                <input type="email" name="donor_email" class="form-control">
              </div>
              <div class="col-md-3">
                <label class="form-label">Telefone</label>
                <input type="text" name="donor_phone" class="form-control" placeholder="(xx) xxxxx-xxxx">
              </div>
            </div>

            <div class="form-check mt-3">
              <input class="form-check-input" type="checkbox" value="1" id="needs_pickup" name="needs_pickup">
              <label class="form-check-label" for="needs_pickup">
                Preciso que retirem a doação no meu endereço
              </label>
            </div>

            <div class="mt-2">
              <label class="form-label">Endereço para retirada</label>
              <textarea name="pickup_address" class="form-control" rows="2" placeholder="Rua, número, bairro, cidade"></textarea>
            </div>

            <div class="mt-3">
              <label class="form-label">Observações</label>
              <textarea name="notes" class="form-control" rows="3" placeholder="Tamanhos, horários disponíveis, detalhes do item..."></textarea>
            </div>

          </div>
          <div class="card-footer bg-white d-flex justify-content-end gap-2">
            <a href="{{ url('/') }}" class="btn btn-outline-secondary">Cancelar</a>
            <button class="btn btn-primary">Enviar Doação</button>
          </div>
        </form>
      </div>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
