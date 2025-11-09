<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Evento - DoeAki</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Detalhes do Evento</h1>
        
        <div class="card">
            <div class="card-body">
                <h2>{{ $evento->nome }}</h2>
                <p><strong>Descrição:</strong> {{ $evento->descricao }}</p>
                <p><strong>Data:</strong> {{ $evento->data_evento->format('d/m/Y H:i') }}</p>
                <p><strong>Local:</strong> {{ $evento->local }}</p>
                <p><strong>Status:</strong> {{ $evento->status }}</p>
                
                @if($userInscrito)
                    <div class="alert alert-success">
                        Você está inscrito neste evento!
                    </div>
                    <form method="POST" action="{{ route('user.eventos.cancelar', $evento->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">Cancelar Inscrição</button>
                    </form>
                @else
                    <form method="POST" action="{{ route('user.eventos.inscrever', $evento->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">Inscrever-se</button>
                    </form>
                @endif
                
                <a href="{{ route('eventos.index') }}" class="btn btn-secondary mt-3">Voltar</a>
            </div>
        </div>
    </div>
</body>
</html>