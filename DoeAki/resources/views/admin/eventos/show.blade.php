@extends('layouts.admin')

@section('title', $evento->nome . ' - Detalhes do Evento')

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1>Detalhes do Evento</h1>
            <p>Informações completas sobre o evento</p>
        </div>
        <a href="{{ route('admin.eventos.index') }}" class="btn btn-secondary">
            <i data-lucide="arrow-left"></i> Voltar
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">{{ $evento->nome }}</h3>
                <span class="badge bg-{{ $evento->status == 'ativo' ? 'success' : ($evento->status == 'inativo' ? 'warning' : 'danger') }}">
                    {{ $evento->status == 'ativo' ? 'Ativo' : ($evento->status == 'inativo' ? 'Inativo' : 'Cancelado') }}
                </span>
            </div>
            <div class="card-body">

                {{-- Imagem do evento --}}
                @if(!empty($evento->imagem) && file_exists(public_path('storage/' . $evento->imagem)))
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $evento->imagem) }}" 
                             alt="{{ $evento->nome }}" 
                             class="img-fluid rounded shadow-sm evento-img">
                    </div>
                @endif

                {{-- Data e local --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong><i data-lucide="calendar" class="me-2"></i>Data e Hora:</strong>
                        <p class="mb-0">{{ $evento->data_evento->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong><i data-lucide="map-pin" class="me-2"></i>Local:</strong>
                        <p class="mb-0">{{ $evento->local }}</p>
                    </div>
                </div>

                {{-- Endereço --}}
                @if($evento->endereco || $evento->cidade)
                <div class="row mb-3">
                    <div class="col-12">
                        <strong><i data-lucide="navigation" class="me-2"></i>Endereço:</strong>
                        <p class="mb-0">
                            {{ $evento->endereco }}
                            @if($evento->cidade)
                                <br>{{ $evento->cidade }}/{{ $evento->estado }}
                                @if($evento->cep)
                                    - CEP: {{ $evento->cep }}
                                @endif
                            @endif
                        </p>
                    </div>
                </div>
                @endif

                {{-- Descrição --}}
                @if($evento->descricao)
                <div class="mb-3">
                    <strong><i data-lucide="file-text" class="me-2"></i>Descrição:</strong>
                    <p class="mb-0">{{ $evento->descricao }}</p>
                </div>
                @endif

                {{-- Vagas e Inscrições --}}
                <div class="row">
                    <div class="col-md-6">
                        <strong><i data-lucide="users" class="me-2"></i>Vagas:</strong>
                        <p class="mb-0">
                            @if($evento->vagas_total)
                                {{ $evento->vagas_disponiveis }} de {{ $evento->vagas_total }} disponíveis
                            @else
                                Vagas ilimitadas
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <strong><i data-lucide="user-check" class="me-2"></i>Inscrições:</strong>
                        <p class="mb-0">{{ $evento->inscricoes->count() }} inscritos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Painel lateral de ações --}}
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Ações</h4>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.eventos.edit', $evento->id) }}" class="btn btn-warning">
                        <i data-lucide="edit"></i> Editar Evento
                    </a>
                    
                    <a href="{{ route('admin.eventos.inscricoes', $evento->id) }}" class="btn btn-info">
                        <i data-lucide="users"></i> Ver Inscrições
                    </a>
                    
                    <form action="{{ route('admin.eventos.toggle-status', $evento->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-{{ $evento->status == 'ativo' ? 'warning' : 'success' }} w-100">
                            <i data-lucide="{{ $evento->status == 'ativo' ? 'pause' : 'play' }}"></i>
                            {{ $evento->status == 'ativo' ? 'Desativar' : 'Ativar' }} Evento
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.eventos.destroy', $evento->id) }}" method="POST"
                          onsubmit="return confirm('Tem certeza que deseja excluir este evento?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i data-lucide="trash-2"></i> Excluir Evento
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Informações do criador --}}
        <div class="card mt-3 shadow-sm">
            <div class="card-header">
                <h4 class="mb-0">Informações do Criador</h4>
            </div>
            <div class="card-body">
                <p><strong>Nome:</strong> {{ $evento->user->name ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $evento->user->email ?? 'N/A' }}</p>
                <p><strong>Criado em:</strong> {{ $evento->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>

{{-- CSS para corrigir imagem e ícones --}}
<style>
    .evento-img {
        max-height: 300px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 15px;
    }

    svg.lucide {
        width: 1em;
        height: 1em;
        vertical-align: middle;
        flex-shrink: 0;
    }
</style>

{{-- Renderizar ícones apenas após tudo carregar --}}
<script>
    window.addEventListener("load", function() {
        lucide.createIcons();
    });
</script>
@endsection
