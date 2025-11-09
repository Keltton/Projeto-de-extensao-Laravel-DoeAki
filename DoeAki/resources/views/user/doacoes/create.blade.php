@extends('layouts.app')

@section('title', 'Nova Doação')

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
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">
                            <i class="fas fa-home me-2"></i>Voltar para Home
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">
                    <i class="fas fa-hand-holding-heart me-2"></i>Nova Doação
                </h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('user.doacoes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Voltar
                    </a>
                </div>
            </div>

            @if(!$user->cadastro_completo)
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Complete seu cadastro!</strong> Para fazer doações, complete seu perfil primeiro.
                    <a href="{{ route('user.perfil') }}" class="alert-link">Completar cadastro</a>
                </div>
            @endif

            <!-- Mensagens -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Erros encontrados:</strong>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card shadow">
                <div class="card-body">
                    <form method="POST" action="{{ route('user.doacoes.store') }}" id="doacaoForm">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <!-- Seleção do Item -->
                                <div class="mb-3">
                                    <label for="item_id" class="form-label">
                                        <i class="fas fa-box me-1"></i>Item para Doação *
                                    </label>
                                    <select class="form-select @error('item_id') is-invalid @enderror" 
                                            id="item_id" name="item_id" required
                                            {{ !$user->cadastro_completo ? 'disabled' : '' }}>
                                        <option value="">Selecione um item...</option>
                                        @foreach($itens as $item)
                                            <option value="{{ $item->id }}" 
                                                    {{ old('item_id') == $item->id ? 'selected' : '' }}
                                                    data-categoria="{{ $item->categoria->nome ?? 'Sem categoria' }}">
                                                {{ $item->nome }} 
                                                @if($item->categoria)
                                                    - {{ $item->categoria->nome }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('item_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Quantidade -->
                                <div class="mb-3">
                                    <label for="quantidade" class="form-label">
                                        <i class="fas fa-hashtag me-1"></i>Quantidade *
                                    </label>
                                    <input type="number" 
                                           class="form-control @error('quantidade') is-invalid @enderror" 
                                           id="quantidade" name="quantidade" 
                                           value="{{ old('quantidade', 1) }}" 
                                           min="1" max="100" 
                                           required
                                           {{ !$user->cadastro_completo ? 'disabled' : '' }}>
                                    @error('quantidade')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Quantidade de unidades que deseja doar.</div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Condição do Item -->
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-star me-1"></i>Condição do Item *
                                    </label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="condicao" 
                                               id="condicao_novo" value="novo" 
                                               {{ old('condicao') == 'novo' ? 'checked' : '' }}
                                               {{ !$user->cadastro_completo ? 'disabled' : '' }} required>
                                        <label class="form-check-label" for="condicao_novo">
                                            Novo (selado/ nunca usado)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="condicao" 
                                               id="condicao_seminovo" value="seminovo" 
                                               {{ old('condicao') == 'seminovo' ? 'checked' : '' }}
                                               {{ !$user->cadastro_completo ? 'disabled' : '' }}>
                                        <label class="form-check-label" for="condicao_seminovo">
                                            Seminovo (pouco uso)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="condicao" 
                                               id="condicao_usado" value="usado" 
                                               {{ old('condicao') == 'usado' ? 'checked' : '' }}
                                               {{ !$user->cadastro_completo ? 'disabled' : '' }}>
                                        <label class="form-check-label" for="condicao_usado">
                                            Usado (em bom estado)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="condicao" 
                                               id="condicao_reparo" value="precisa_reparo" 
                                               {{ old('condicao') == 'precisa_reparo' ? 'checked' : '' }}
                                               {{ !$user->cadastro_completo ? 'disabled' : '' }}>
                                        <label class="form-check-label" for="condicao_reparo">
                                            Precisa de reparos
                                        </label>
                                    </div>
                                    @error('condicao')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Descrição -->
                        <div class="mb-3">
                            <label for="descricao" class="form-label">
                                <i class="fas fa-align-left me-1"></i>Descrição da Doação
                            </label>
                            <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                      id="descricao" name="descricao" rows="3"
                                      placeholder="Descreva o item, marca, modelo, ou qualquer informação relevante..."
                                      {{ !$user->cadastro_completo ? 'disabled' : '' }}>{{ old('descricao') }}</textarea>
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Máximo 500 caracteres.</div>
                        </div>

                        <!-- Botões -->
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('user.doacoes.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-success" 
                                    {{ !$user->cadastro_completo ? 'disabled' : '' }}>
                                <i class="fas fa-check me-1"></i> Registrar Doação
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Informações sobre doações -->
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informações Importantes
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="mb-0">
                        <li>Todas as doações passam por uma análise antes da aprovação</li>
                        <li>Itens devem estar em condições adequadas para uso</li>
                        <li>Você será notificado sobre o status da sua doação</li>
                        <li>Doações aprovadas serão disponibilizadas para eventos</li>
                    </ul>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('doacaoForm');
    const cadastroCompleto = {{ $user->cadastro_completo ? 'true' : 'false' }};

    if (!cadastroCompleto) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Complete seu cadastro antes de fazer uma doação.');
            window.location.href = "{{ route('user.perfil') }}";
        });
    }

    // Validação em tempo real
    const quantidadeInput = document.getElementById('quantidade');
    if (quantidadeInput) {
        quantidadeInput.addEventListener('input', function() {
            if (this.value < 1) this.value = 1;
            if (this.value > 100) this.value = 100;
        });
    }
});
</script>
@endsection