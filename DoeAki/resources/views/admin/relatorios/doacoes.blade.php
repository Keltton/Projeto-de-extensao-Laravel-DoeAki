@extends('layouts.admin')

@section('title', 'Relatório de Doações - DoeAki')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>📊 Relatório de Doações</h1>
        <a href="{{ route('admin.relatorios.index') }}" class="btn btn-secondary">
            Voltar aos Relatórios
        </a>
    </div>

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <!-- Estatísticas -->
    <div class="row mb-4">
        <div class="col-md-2 col-6">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <i data-lucide="gift" class="mb-2" style="width: 24px; height: 24px;"></i>
                    <h4>{{ $estatisticas['total'] ?? 0 }}</h4>
                    <small>Total de Doações</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <i data-lucide="check-circle" class="mb-2" style="width: 24px; height: 24px;"></i>
                    <h4>{{ $estatisticas['aprovadas'] ?? 0 }}</h4>
                    <small>Aprovadas</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card bg-warning text-dark">
                <div class="card-body text-center">
                    <i data-lucide="clock" class="mb-2" style="width: 24px; height: 24px;"></i>
                    <h4>{{ $estatisticas['pendentes'] ?? 0 }}</h4>
                    <small>Pendentes</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card bg-danger text-white">
                <div class="card-body text-center">
                    <i data-lucide="x-circle" class="mb-2" style="width: 24px; height: 24px;"></i>
                    <h4>{{ $estatisticas['rejeitadas'] ?? 0 }}</h4>
                    <small>Rejeitadas</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <i data-lucide="truck" class="mb-2" style="width: 24px; height: 24px;"></i>
                    <h4>{{ $estatisticas['entregues'] ?? 0 }}</h4>
                    <small>Entregues</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card bg-secondary text-white">
                <div class="card-body text-center">
                    <i data-lucide="calendar" class="mb-2" style="width: 24px; height: 24px;"></i>
                    <h4>{{ $estatisticas['doacoes_este_mes'] ?? 0 }}</h4>
                    <small>Este Mês</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Doações -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">📋 Lista de Doações ({{ $doacoes->count() }})</h5>
        </div>
        <div class="card-body">
            @if($doacoes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
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
                                    @if($doacao->entregue)
                                        <span class="badge bg-success">Entregue</span>
                                    @else
                                        <span class="badge 
                                            @if($doacao->status == 'pendente') bg-warning
                                            @elseif($doacao->status == 'aceita' || $doacao->status == 'aprovado') bg-success
                                            @elseif($doacao->status == 'rejeitada' || $doacao->status == 'rejeitado') bg-danger
                                            @else bg-secondary @endif">
                                            {{ ucfirst($doacao->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $doacao->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Informação simples sobre os resultados -->
                <div class="mt-3">
                    <p class="text-muted mb-0">
                        Mostrando {{ $doacoes->count() }} doação(ões)
                    </p>
                </div>
            @else
                <div class="text-center py-4">
                    <i data-lucide="package" style="color: #ccc; width: 48px; height: 48px;"></i>
                    <p class="text-muted mt-2">Nenhuma doação encontrada</p>
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