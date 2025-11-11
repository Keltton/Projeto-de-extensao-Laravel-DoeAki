@extends('layouts.admin')

@section('title', 'Inscrições do Evento - ' . $evento->nome)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>📋 Inscrições do Evento</h1>
            <p class="text-muted mb-0">{{ $evento->nome }}</p>
            <small class="text-muted">
                Data: {{ $evento->data_evento->format('d/m/Y H:i') }} | 
                Local: {{ $evento->local }} |
                Total de inscritos: {{ $inscricoes->total() }}
            </small>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.eventos.show', $evento->id) }}" class="btn btn-secondary">
                <i data-lucide="arrow-left"></i> Voltar ao Evento
            </a>
            <a href="{{ route('admin.eventos.exportar-inscricoes', $evento->id) }}" class="btn btn-success">
                <i data-lucide="download"></i> Exportar CSV
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i data-lucide="check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i data-lucide="alert-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Card de Inscrições -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i data-lucide="users"></i> Lista de Inscritos
                <span class="badge bg-primary">{{ $inscricoes->total() }}</span>
            </h5>
        </div>
        <div class="card-body">
            @if($inscricoes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Usuário</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Data de Inscrição</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inscricoes as $inscricao)
                                <tr>
                                    <td>{{ $loop->iteration + ($inscricoes->currentPage() - 1) * $inscricoes->perPage() }}</td>
                                    <td>
                                        <strong>{{ $inscricao->user->name }}</strong>
                                        @if($inscricao->user->cadastro_completo)
                                            <span class="badge bg-success" title="Cadastro completo">✓</span>
                                        @endif
                                    </td>
                                    <td>{{ $inscricao->user->email }}</td>
                                    <td>
                                        @if($inscricao->user->telefone)
                                            {{ $inscricao->user->telefone }}
                                        @else
                                            <span class="text-muted">Não informado</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $inscricao->created_at->format('d/m/Y H:i') }}
                                        <br>
                                        <small class="text-muted">
                                            {{ $inscricao->created_at->diffForHumans() }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">Inscrito</span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="mailto:{{ $inscricao->user->email }}" 
                                               class="btn btn-outline-primary" 
                                               title="Enviar email">
                                                <i data-lucide="mail"></i>
                                            </a>
                                            <a href="{{ route('admin.users.edit', $inscricao->user->id) }}" 
                                               class="btn btn-outline-info" 
                                               title="Ver perfil">
                                                <i data-lucide="user"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        Mostrando {{ $inscricoes->firstItem() }} a {{ $inscricoes->lastItem() }} de {{ $inscricoes->total() }} inscrições
                    </div>
                    <div>
                        {{ $inscricoes->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i data-lucide="users" style="width: 64px; height: 64px; color: #ccc;"></i>
                    <h4 class="mt-3">Nenhuma inscrição encontrada</h4>
                    <p class="text-muted">Este evento ainda não possui inscrições.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Informações do Evento -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i data-lucide="info"></i> Informações do Evento</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Nome:</strong></td>
                            <td>{{ $evento->nome }}</td>
                        </tr>
                        <tr>
                            <td><strong>Data:</strong></td>
                            <td>{{ $evento->data_evento->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Local:</strong></td>
                            <td>{{ $evento->local }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                <span class="badge bg-{{ $evento->status === 'ativo' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($evento->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Vagas:</strong></td>
                            <td>
                                @if($evento->vagas)
                                    {{ $inscricoes->total() }} / {{ $evento->vagas }}
                                    @php
                                        $percentual = $evento->vagas > 0 ? ($inscricoes->total() / $evento->vagas) * 100 : 0;
                                    @endphp
                                    <div class="progress mt-1" style="height: 8px;">
                                        <div class="progress-bar {{ $percentual >= 100 ? 'bg-danger' : 'bg-success' }}" 
                                             style="width: {{ min($percentual, 100) }}%">
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ number_format($percentual, 1) }}% ocupado</small>
                                @else
                                    <span class="text-muted">Ilimitado</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i data-lucide="bar-chart"></i> Estatísticas</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <h3 class="text-primary mb-0">{{ $inscricoes->total() }}</h3>
                                <small class="text-muted">Total Inscritos</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <h3 class="text-success mb-0">
                                    {{ $evento->created_at->diffInDays(now()) }}
                                </h3>
                                <small class="text-muted">Dias desde criação</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table td {
        vertical-align: middle;
    }
    
    .progress {
        background-color: #e9ecef;
        border-radius: 4px;
    }
    
    .btn-group-sm .btn {
        margin-right: 2px;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        lucide.createIcons();
    });
</script>
@endsection