@extends('layouts.admin')

@section('title', 'Relatório de Itens - DoeAki')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>📦 Relatório de Itens</h1>
        <a href="{{ route('admin.relatorios.index') }}" class="btn btn-secondary">
            Voltar aos Relatórios
        </a>
    </div>

    <!-- Lista de Itens -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">📋 Lista de Itens ({{ $itens->count() }})</h5>
        </div>
        <div class="card-body">
            @if($itens->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Descrição</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($itens as $item)
                            <tr>
                                <td>{{ $item->nome }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $item->categoria->nome ?? 'N/A' }}</span>
                                </td>
                                <td>{{ Str::limit($item->descricao, 50) ?? '-' }}</td>
                                <td>
                                    <span class="badge 
                                        @if($item->status == 'ativo') bg-success
                                        @else bg-danger @endif">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i data-lucide="package" style="color: #ccc; width: 48px; height: 48px;"></i>
                    <p class="text-muted mt-2">Nenhum item encontrado</p>
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