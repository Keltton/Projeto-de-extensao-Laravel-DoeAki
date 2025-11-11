@extends('layouts.admin')

@section('title', 'Eventos - Dashboard Admin')

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1>Gerenciar Eventos</h1>
            <p>Gerencie todos os eventos do sistema</p>
        </div>
        <a href="{{ route('admin.eventos.create') }}" class="btn btn-primary">
            <i data-lucide="plus"></i> Novo Evento
        </a>
    </div>
</div>


<div class="card">
    <div class="card-header">
        <div class="filters" style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
            <form method="GET" action="{{ route('admin.eventos.index') }}" style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                <div class="form-group" style="margin: 0;">
                    <input type="text" name="search" class="form-control" placeholder="Buscar eventos..." 
                           value="{{ request('search') }}" style="min-width: 250px;">
                </div>
                
                <div class="form-group" style="margin: 0;">
                    <select name="status" class="form-control" onchange="this.form.submit()">
                        <option value="">Todos os status</option>
                        <option value="ativo" {{ request('status') == 'ativo' ? 'selected' : '' }}>Ativos</option>
                        <option value="inativo" {{ request('status') == 'inativo' ? 'selected' : '' }}>Inativos</option>
                        <option value="cancelado" {{ request('status') == 'cancelado' ? 'selected' : '' }}>Cancelados</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-secondary">
                    <i data-lucide="search"></i> Buscar
                </button>
                
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.eventos.index') }}" class="btn btn-outline-secondary">
                        <i data-lucide="x"></i> Limpar
                    </a>
                @endif
            </form>
        </div>
    </div>

    <div class="card-body">
        @if($eventos->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Data</th>
                            <th>Local</th>
                            <th>Inscrições</th>
                            <th>Status</th>
                            <th>Criado por</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($eventos as $evento)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    @if($evento->imagem)
                                        <img src="{{ asset('storage/' . $evento->imagem) }}" 
                                             alt="{{ $evento->nome }}" 
                                             style="width: 40px; height: 40px; border-radius: 4px; object-fit: cover;">
                                    @else
                                        <div style="width: 40px; height: 40px; background: #f8f9fa; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                            <i data-lucide="calendar" style="width: 20px; height: 20px; color: #6c757d;"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <strong>{{ $evento->nome }}</strong>
                                        @if($evento->descricao && strlen($evento->descricao) > 100)
                                            <br><small class="text-muted">{{ substr($evento->descricao, 0, 100) }}...</small>
                                        @elseif($evento->descricao)
                                            <br><small class="text-muted">{{ $evento->descricao }}</small>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>
                                <strong>{{ $evento->data_evento->format('d/m/Y') }}</strong>
                                <br>
                                <small class="text-muted">{{ $evento->data_evento->format('H:i') }}</small>
                            </td>
                            <td>
                                {{ $evento->local }}
                                @if($evento->cidade)
                                    <br><small class="text-muted">{{ $evento->cidade }}/{{ $evento->estado }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $evento->inscricoes->count() }}</span>
                                @if($evento->vagas_total)
                                    <br><small class="text-muted">{{ $evento->vagas_disponiveis }} vagas restantes</small>
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusClasses = [
                                        'ativo' => 'bg-success',
                                        'inativo' => 'bg-warning',
                                        'cancelado' => 'bg-danger'
                                    ];
                                    $statusTexts = [
                                        'ativo' => 'Ativo',
                                        'inativo' => 'Inativo',
                                        'cancelado' => 'Cancelado'
                                    ];
                                @endphp
                                <span class="badge {{ $statusClasses[$evento->status] ?? 'bg-secondary' }}">
                                    {{ $statusTexts[$evento->status] ?? $evento->status }}
                                </span>
                            </td>
                            <td>
                                <small>{{ $evento->user->name ?? 'N/A' }}</small>
                                <br>
                                <small class="text-muted">{{ $evento->created_at->format('d/m/Y') }}</small>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.25rem; flex-wrap: wrap;">
                                    <a href="{{ route('admin.eventos.show', $evento->id) }}" 
                                       class="btn btn-sm btn-info" 
                                       title="Ver detalhes">
                                        <i data-lucide="eye"></i>
                                    </a>
                                    
                                    <a href="{{ route('admin.eventos.edit', $evento->id) }}" 
                                       class="btn btn-sm btn-warning" 
                                       title="Editar">
                                        <i data-lucide="edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.eventos.destroy', $evento->id) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Tem certeza que deseja excluir este evento? Todas as inscrições serão perdidas.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Excluir">
                                            <i data-lucide="trash-2"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <p class="mb-0">Mostrando {{ $eventos->firstItem() }} a {{ $eventos->lastItem() }} de {{ $eventos->total() }} eventos</p>
                </div>
                <div>
                    {{ $eventos->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i data-lucide="calendar" style="width: 64px; height: 64px; color: #6c757d; margin-bottom: 1rem;"></i>
                <h4>Nenhum evento encontrado</h4>
                <p class="text-muted">Não há eventos cadastrados no sistema.</p>
                <a href="{{ route('admin.eventos.create') }}" class="btn btn-primary">
                    <i data-lucide="plus"></i> Criar Primeiro Evento
                </a>
            </div>
        @endif
    </div>
</div>

<style>
.table th {
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
}

.badge {
    font-size: 0.75em;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.table-responsive {
    border-radius: 8px;
    overflow: hidden;
}

.alert {
    border: none;
    border-radius: 8px;
    margin-bottom: 1.5rem;
}
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        lucide.createIcons();
    });
</script>
@endsection