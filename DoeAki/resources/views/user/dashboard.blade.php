@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('user.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.perfil') }}">
                            <i class="fas fa-user me-2"></i>
                            Meu Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.doacoes.index') }}">
                            <i class="fas fa-hand-holding-heart me-2"></i>
                            Minhas Doações
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.eventos.meus') }}">
                            <i class="fas fa-calendar-check me-2"></i>
                            Meus Eventos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">
                            <i class="fas fa-home me-2"></i>
                            Voltar para Home
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('user.doacoes.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-1"></i> Nova Doação
                    </a>
                </div>
            </div>

            <!-- Alert para cadastro incompleto -->
            @if(!$user->cadastro_completo)
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Complete seu cadastro!</strong> Para fazer doações e se inscrever em eventos, complete seu perfil.
                    <a href="{{ route('user.perfil') }}" class="alert-link">Completar cadastro</a>
                </div>
            @endif

            <!-- Mensagens de sucesso/erro -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Cards de Estatísticas -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total de Doações
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDoacoes }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-hand-holding-heart fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Doações Aceitas
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $doacoesAceitas }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Eventos Inscritos
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $eventosInscritos }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Cadastro
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        {{ $user->cadastro_completo ? 'Completo' : 'Incompleto' }}
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-check fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Últimas Doações -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-history me-2"></i>
                                Minhas Últimas Doações
                            </h5>
                            <a href="{{ route('user.doacoes.index') }}" class="btn btn-sm btn-outline-primary">
                                Ver Todas
                            </a>
                        </div>
                        <div class="card-body">
                            @if($minhasDoacoes->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Quantidade</th>
                                                <th>Data</th>
                                                <th>Status</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($minhasDoacoes as $doacao)
                                                <tr>
                                                    <td>
                                                        <strong>{{ $doacao->item->nome }}</strong>
                                                        @if($doacao->item->categoria)
                                                            <br><small class="text-muted">{{ $doacao->item->categoria->nome }}</small>
                                                        @endif
                                                    </td>
                                                    <td>{{ $doacao->quantidade }}</td>
                                                    <td>{{ $doacao->created_at->format('d/m/Y H:i') }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $doacao->status === 'aceita' ? 'success' : ($doacao->status === 'pendente' ? 'warning' : 'danger') }}">
                                                            {{ ucfirst($doacao->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('user.doacoes.show', $doacao->id) }}" 
                                                           class="btn btn-sm btn-outline-info" title="Ver detalhes">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        @if($doacao->status === 'pendente')
                                                            <form action="{{ route('user.doacoes.destroy', $doacao->id) }}" 
                                                                  method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                        onclick="return confirm('Tem certeza que deseja cancelar esta doação?')"
                                                                        title="Cancelar doação">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-hand-holding-heart fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Nenhuma doação realizada ainda.</p>
                                    <a href="{{ route('user.doacoes.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i> Fazer Primeira Doação
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Eventos Disponíveis -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-calendar-alt me-2"></i>
                                Eventos Disponíveis
                            </h5>
                            <div>
                                <a href="{{ route('eventos.index') }}" class="btn btn-sm btn-outline-success me-2">
                                    <i class="fas fa-calendar me-1"></i>Ver Todos
                                </a>
                                <a href="{{ route('user.eventos.meus') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-calendar-check me-1"></i>Meus Eventos
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($eventosAtivos->count() > 0)
                                <div class="row">
                                    @foreach($eventosAtivos as $evento)
                                        <div class="col-md-6 col-lg-4 mb-4">
                                            <div class="card h-100 shadow-sm">
                                                @if($evento->imagem)
                                                    <img src="{{ asset($evento->imagem) }}" 
                                                         class="card-img-top" alt="{{ $evento->nome }}" style="height: 150px; object-fit: cover;">
                                                @else
                                                    <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 150px;">
                                                        <i class="fas fa-calendar-alt fa-3x text-white"></i>
                                                    </div>
                                                @endif
                                                <div class="card-body">
                                                    <h6 class="card-title text-primary">{{ $evento->nome }}</h6>
                                                    <p class="card-text small text-muted mb-2">
                                                        <i class="fas fa-calendar me-1"></i>
                                                        {{ $evento->data_evento->format('d/m/Y H:i') }}
                                                    </p>
                                                    <p class="card-text small mb-2">
                                                        <i class="fas fa-map-marker-alt me-1"></i>
                                                        {{ $evento->local }}
                                                    </p>
                                                    <p class="card-text small">{{ Str::limit($evento->descricao, 100) }}</p>

                                                    <div class="mt-3">
                                                        @if($evento->usuario_inscrito)
                                                            <span class="badge bg-success mb-2">
                                                                <i class="fas fa-check me-1"></i>Inscrito
                                                            </span>
                                                            <form method="POST" action="{{ route('user.eventos.cancelar', $evento->id) }}"
                                                                class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-outline-danger w-100"
                                                                        onclick="return confirm('Tem certeza que deseja cancelar sua inscrição?')">
                                                                    <i class="fas fa-times me-1"></i>Cancelar Inscrição
                                                                </button>
                                                            </form>
                                                        @else
                                                            <form method="POST" action="{{ route('user.eventos.inscrever', $evento->id) }}">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-primary w-100" 
                                                                        {{ !$user->cadastro_completo ? 'disabled' : '' }}
                                                                        title="{{ !$user->cadastro_completo ? 'Complete seu cadastro para se inscrever' : 'Inscrever-se no evento' }}">
                                                                    <i class="fas fa-user-plus me-1"></i>Inscrever-se
                                                                </button>
                                                            </form>
                                                            @if(!$user->cadastro_completo)
                                                                <small class="text-muted d-block mt-1">
                                                                    Complete seu cadastro para se inscrever
                                                                </small>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Nenhum evento disponível no momento.</p>
                                    <a href="{{ route('eventos.index') }}" class="btn btn-outline-primary">
                                        <i class="fas fa-calendar me-1"></i>Ver Todos os Eventos
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection