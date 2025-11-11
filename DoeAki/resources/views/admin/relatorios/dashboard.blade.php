@extends('layouts.admin')

@section('title', 'Dashboard de Relatórios - DoeAki')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>📊 Dashboard de Relatórios</h1>
        <div class="btn-group">
            <a href="{{ route('admin.relatorios.index') }}" class="btn btn-secondary">
                <i data-lucide="arrow-left"></i> Voltar
            </a>
        </div>
    </div>

    <!-- Estatísticas Principais -->
    <div class="row mb-4">
        <div class="col-md-2 col-6">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <i data-lucide="users" class="mb-2" style="width: 24px; height: 24px;"></i>
                    <h4>{{ $estatisticas['total_usuarios'] }}</h4>
                    <small>Total de Usuários</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <i data-lucide="gift" class="mb-2" style="width: 24px; height: 24px;"></i>
                    <h4>{{ $estatisticas['total_doacoes'] }}</h4>
                    <small>Total de Doações</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <i data-lucide="package" class="mb-2" style="width: 24px; height: 24px;"></i>
                    <h4>{{ $estatisticas['total_itens'] }}</h4>
                    <small>Itens Cadastrados</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card bg-warning text-dark">
                <div class="card-body text-center">
                    <i data-lucide="calendar" class="mb-2" style="width: 24px; height: 24px;"></i>
                    <h4>{{ $estatisticas['total_eventos'] }}</h4>
                    <small>Total de Eventos</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card bg-secondary text-white">
                <div class="card-body text-center">
                    <i data-lucide="trending-up" class="mb-2" style="width: 24px; height: 24px;"></i>
                    <h4>{{ $estatisticas['doacoes_hoje'] }}</h4>
                    <small>Doações Hoje</small>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6">
            <div class="card bg-dark text-white">
                <div class="card-body text-center">
                    <i data-lucide="user-plus" class="mb-2" style="width: 24px; height: 24px;"></i>
                    <h4>{{ $estatisticas['novos_usuarios_hoje'] }}</h4>
                    <small>Novos Usuários Hoje</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Links Rápidos para Relatórios -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">📈 Relatórios Detalhados</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('admin.relatorios.doacoes') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i data-lucide="gift" class="text-primary me-2"></i>
                                Relatório de Doações
                            </div>
                            <i data-lucide="arrow-right" class="text-muted"></i>
                        </a>
                        <a href="{{ route('admin.relatorios.usuarios') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i data-lucide="users" class="text-success me-2"></i>
                                Relatório de Usuários
                            </div>
                            <i data-lucide="arrow-right" class="text-muted"></i>
                        </a>
                        <a href="{{ route('admin.relatorios.itens') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i data-lucide="package" class="text-info me-2"></i>
                                Relatório de Itens
                            </div>
                            <i data-lucide="arrow-right" class="text-muted"></i>
                        </a>
                        <a href="{{ route('admin.relatorios.eventos') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i data-lucide="calendar" class="text-warning me-2"></i>
                                Relatório de Eventos
                            </div>
                            <i data-lucide="arrow-right" class="text-muted"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ações Rápidas -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">⚡ Ações Rápidas</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ route('admin.doacoes.gerenciar') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i data-lucide="check-circle" class="mb-2" style="width: 24px; height: 24px;"></i>
                                <small>Gerenciar Doações</small>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i data-lucide="users" class="mb-2" style="width: 24px; height: 24px;"></i>
                                <small>Gerenciar Usuários</small>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.eventos.index') }}" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i data-lucide="calendar" class="mb-2" style="width: 24px; height: 24px;"></i>
                                <small>Gerenciar Eventos</small>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center p-3">
                                <i data-lucide="layout-dashboard" class="mb-2" style="width: 24px; height: 24px;"></i>
                                <small>Dashboard Principal</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        lucide.createIcons();
    });
</script>
@endsection