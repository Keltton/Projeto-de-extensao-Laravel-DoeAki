@extends('layouts.admin')

@section('title', 'Relatórios e Estatísticas - DoeAki')

@section('content')
<div class="container-fluid">
    <div class="page-header mb-4">
        <h1>📊 Relatórios e Estatísticas</h1>
        <p class="text-muted">Analise os dados e performance do sistema</p>
    </div>

    <div class="row">
        <!-- Card Dashboard -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="report-icon mx-auto mb-3" style="background: #f3e5f5; width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="bar-chart" style="color: #7b1fa2;"></i>
                    </div>
                    <h5 class="card-title">Dashboard Completo</h5>
                    <p class="card-text text-muted">Visão geral de todas as métricas do sistema</p>
                    <a href="{{ route('admin.relatorios.dashboard') }}" class="btn btn-primary">
                        Ver Dashboard <i data-lucide="arrow-right" class="ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card Doações -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="report-icon mx-auto mb-3" style="background: #e8f5e8; width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="gift" style="color: #2e7d32;"></i>
                    </div>
                    <h5 class="card-title">Doações</h5>
                    <p class="card-text text-muted">Relatório completo de doações, status e histórico</p>
                    <a href="{{ route('admin.relatorios.doacoes') }}" class="btn btn-success">
                        Ver Relatório <i data-lucide="arrow-right" class="ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card Usuários -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="report-icon mx-auto mb-3" style="background: #e3f2fd; width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="users" style="color: #1976d2;"></i>
                    </div>
                    <h5 class="card-title">Usuários</h5>
                    <p class="card-text text-muted">Estatísticas de usuários e atividades</p>
                    <a href="{{ route('admin.relatorios.usuarios') }}" class="btn btn-info">
                        Ver Relatório <i data-lucide="arrow-right" class="ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card Itens -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="report-icon mx-auto mb-3" style="background: #fff3e0; width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="package" style="color: #f57c00;"></i>
                    </div>
                    <h5 class="card-title">Itens</h5>
                    <p class="card-text text-muted">Relatório de itens disponíveis e categorias</p>
                    <a href="{{ route('admin.relatorios.itens') }}" class="btn btn-warning">
                        Ver Relatório <i data-lucide="arrow-right" class="ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card Eventos -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="report-icon mx-auto mb-3" style="background: #fce4ec; width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="calendar" style="color: #c2185b;"></i>
                    </div>
                    <h5 class="card-title">Eventos</h5>
                    <p class="card-text text-muted">Relatório de eventos e inscrições</p>
                    <a href="{{ route('admin.relatorios.eventos') }}" class="btn btn-danger">
                        Ver Relatório <i data-lucide="arrow-right" class="ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Card Exportar -->
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="report-icon mx-auto mb-3" style="background: #e8eaf6; width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="download" style="color: #303f9f;"></i>
                    </div>
                    <h5 class="card-title">Exportar Dados</h5>
                    <p class="card-text text-muted">Exporte relatórios em formato CSV</p>
                    <div class="btn-group-vertical w-100">
                        <a href="{{ route('admin.relatorios.exportar', 'doacoes') }}" class="btn btn-outline-primary btn-sm mb-1">Doações</a>
                        <a href="{{ route('admin.relatorios.exportar', 'usuarios') }}" class="btn btn-outline-success btn-sm mb-1">Usuários</a>
                        <a href="{{ route('admin.relatorios.exportar', 'itens') }}" class="btn btn-outline-info btn-sm mb-1">Itens</a>
                        <a href="{{ route('admin.relatorios.exportar', 'eventos') }}" class="btn btn-outline-warning btn-sm">Eventos</a>
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