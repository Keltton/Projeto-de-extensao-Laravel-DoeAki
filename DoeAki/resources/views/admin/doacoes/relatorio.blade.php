@extends('layouts.admin')

@section('title', 'Relatório de Doações - DoeAki')

@section('content')
<div class="page-header">
    <h1>📊 Relatório de Doações</h1>
    <p>Estatísticas e relatórios detalhados das doações</p>
</div>

<!-- Estatísticas Rápidas -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-number">{{ $estatisticas['total_doacoes'] }}</span>
            <span class="stat-label">Total de Doações</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-number">{{ $estatisticas['doacoes_aprovadas'] }}</span>
            <span class="stat-label">Aprovadas</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-number">{{ $estatisticas['doacoes_pendentes'] }}</span>
            <span class="stat-label">Pendentes</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-info">
            <span class="stat-number">{{ $estatisticas['doacoes_rejeitadas'] }}</span>
            <span class="stat-label">Rejeitadas</span>
        </div>
    </div>
</div>

<!-- Tabela de Doações -->
<div class="dashboard-section">
    <h3>📋 Lista de Doações</h3>
    
    @if($doacoes->count() > 0)
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Doador</th>
                        <th>Categoria</th>
                        <th>Quantidade</th>
                        <th>Status</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($doacoes as $doacao)
                    <tr>
                        <td>{{ $doacao->item->nome ?? 'N/A' }}</td>
                        <td>{{ $doacao->user->name }}</td>
                        <td>{{ $doacao->item->categoria->nome ?? 'N/A' }}</td>
                        <td>{{ $doacao->quantidade }}</td>
                        <td>
                            <span class="status-badge status-{{ $doacao->status }}">
                                {{ ucfirst($doacao->status) }}
                            </span>
                        </td>
                        <td>{{ $doacao->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <p>Nenhuma doação encontrada</p>
        </div>
    @endif
</div>

<style>
.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

.data-table th,
.data-table td {
    padding: 0.75rem;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.data-table th {
    background: #f8f9fa;
    font-weight: 600;
}

.status-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 500;
}

.status-aprovado { background: #e8f5e8; color: #2e7d32; }
.status-pendente { background: #fff3e0; color: #f57c00; }
.status-rejeitado { background: #ffebee; color: #c62828; }
</style>
@endsection