@extends('layouts.admin')

@section('title', 'Relatório de Eventos - DoeAki')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>📅 Relatório de Eventos</h1>
        <a href="{{ route('admin.relatorios.index') }}" class="btn btn-secondary">
            Voltar aos Relatórios
        </a>
    </div>

    <!-- Lista de Eventos -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">📋 Lista de Eventos ({{ $eventos->count() }})</h5>
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
                                <th>Criador</th>
                                <th>Inscrições</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($eventos as $evento)
                            <tr>
                                <td>{{ $evento->nome }}</td>
                                <td>{{ $evento->data_evento->format('d/m/Y H:i') }}</td>
                                <td>{{ $evento->local }}</td>
                                <td>{{ $evento->user->name }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $evento->inscricoes_count }}</span>
                                </td>
                                <td>
                                    <span class="badge 
                                        @if($evento->status == 'ativo') bg-success
                                        @elseif($evento->status == 'inativo') bg-secondary
                                        @else bg-danger @endif">
                                        {{ ucfirst($evento->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i data-lucide="calendar" style="color: #ccc; width: 48px; height: 48px;"></i>
                    <p class="text-muted mt-2">Nenhum evento encontrado</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        lucide.createIcons();
    });
</script>
@endsection