@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.perfil') }}">
                            <i class="fas fa-user me-2"></i>Meu Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('user.doacoes.index') }}">
                            <i class="fas fa-hand-holding-heart me-2"></i>Minhas Doações
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.eventos.meus') }}">
                            <i class="fas fa-calendar-check me-2"></i>Meus Eventos
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-hand-holding-heart me-2"></i>Minhas Doações
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('user.doacoes.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-1"></i> Nova Doação
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($doacoes->count() > 0)
                <div class="card">
                    <div class="card-body">
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
                                    @foreach($doacoes as $doacao)
                                        <tr>
                                            <td>
                                                <strong>{{ $doacao->item->nome }}</strong>
                                                @if($doacao->item->categoria)
                                                    <br><small class="text-muted">{{ $doacao->item->categoria->nome }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $doacao->quantidade }}</td>
                                            <td>{{ $doacao->data_doacao->format('d/m/Y H:i') }}</td>
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
                        
                        <!-- Paginação -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $doacoes->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-hand-holding-heart fa-4x text-muted mb-4"></i>
                    <h4 class="text-muted">Nenhuma doação encontrada</h4>
                    <p class="text-muted mb-4">Você ainda não realizou nenhuma doação.</p>
                    <a href="{{ route('user.doacoes.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i> Fazer Primeira Doação
                    </a>
                </div>
            @endif
        </main>
    </div>
</div>
@endsection