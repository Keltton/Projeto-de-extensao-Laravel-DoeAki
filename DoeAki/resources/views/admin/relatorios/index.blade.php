@extends('layouts.admin')

@section('title', 'Relatórios - DoeAki')

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1>Relatórios e Estatísticas</h1>
            <p>Visualize dados e métricas do sistema</p>
        </div>
        <div class="periodo-selector">
            <select id="periodoSelect" class="form-select">
                <option value="7dias">Últimos 7 dias</option>
                <option value="30dias" selected>Últimos 30 dias</option>
                <option value="90dias">Últimos 90 dias</option>
                <option value="1ano">Último ano</option>
            </select>
        </div>
    </div>
</div>

<!-- Cards de Estatísticas -->
<div class="stats-grid" id="estatisticasGerais">
    <div class="stat-card">
        <div class="stat-icon" style="background: #e3f2fd;">
            <i data-lucide="users"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">0</span>
            <span class="stat-label">Total de Usuários</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: #e8f5e8;">
            <i data-lucide="package"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">0</span>
            <span class="stat-label">Itens Cadastrados</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: #fff3e0;">
            <i data-lucide="folder"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">0</span>
            <span class="stat-label">Categorias</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: #fce4ec;">
            <i data-lucide="calendar"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">0</span>
            <span class="stat-label">Eventos Ativos</span>
        </div>
    </div>
</div>

<!-- Gráficos e Relatórios -->
<div class="charts-grid">
    <!-- Gráfico de Itens por Categoria -->
    <div class="chart-card">
        <div class="chart-header">
            <h3>Itens por Categoria</h3>
        </div>
        <div class="chart-container">
            <canvas id="itensPorCategoriaChart"></canvas>
        </div>
    </div>

    <!-- Gráfico de Eventos por Mês -->
    <div class="chart-card">
        <div class="chart-header">
            <h3>Eventos por Mês</h3>
        </div>
        <div class="chart-container">
            <canvas id="eventosPorMesChart"></canvas>
        </div>
    </div>

    <!-- Gráfico de Usuários por Mês -->
    <div class="chart-card">
        <div class="chart-header">
            <h3>Usuários por Mês</h3>
        </div>
        <div class="chart-container">
            <canvas id="usuariosPorMesChart"></canvas>
        </div>
    </div>

    <!-- Gráfico de Itens por Mês -->
    <div class="chart-card">
        <div class="chart-header">
            <h3>Itens por Mês</h3>
        </div>
        <div class="chart-container">
            <canvas id="itensPorMesChart"></canvas>
        </div>
    </div>
</div>

<!-- Tabelas de Dados -->
<div class="tables-grid">
    <!-- Top Categorias -->
    <div class="table-card">
        <div class="table-header">
            <h3>Top 5 Categorias</h3>
        </div>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Quantidade de Itens</th>
                    </tr>
                </thead>
                <tbody id="topCategoriasTable">
                    <!-- Dados serão preenchidos via JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Próximos Eventos -->
    <div class="table-card">
        <div class="table-header">
            <h3>Próximos Eventos</h3>
        </div>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Evento</th>
                        <th>Data</th>
                        <th>Local</th>
                    </tr>
                </thead>
                <tbody id="eventosProximosTable">
                    <!-- Dados serão preenchidos via JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Loading Spinner -->
<div id="loadingSpinner" class="loading-spinner">
    <div class="spinner"></div>
    <p>Carregando dados...</p>
</div>

<style>
    .periodo-selector {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-select {
        padding: 0.5rem;
        border: 2px solid #e9ecef;
        border-radius: 5px;
        background: white;
    }

    .charts-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .chart-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .chart-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e9ecef;
        background: #f8f9fa;
    }

    .chart-header h3 {
        margin: 0;
        color: #333;
        font-size: 1.1rem;
    }

    .chart-container {
        padding: 1.5rem;
        height: 300px;
    }

    .tables-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    .table-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .table-header {
        padding: 1.5rem;
        border-bottom: 1px solid #e9ecef;
        background: #f8f9fa;
    }

    .table-header h3 {
        margin: 0;
        color: #333;
        font-size: 1.1rem;
    }

    .table-container {
        padding: 1.5rem;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th,
    .table td {
        padding: 0.75rem;
        text-align: left;
        border-bottom: 1px solid #e9ecef;
    }

    .table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #333;
    }

    .loading-spinner {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.9);
        z-index: 9999;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #667eea;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @media (max-width: 768px) {
        .charts-grid,
        .tables-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    let charts = {};

    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
        carregarDados('30dias');
        
        // Event listener para mudança de período
        document.getElementById('periodoSelect').addEventListener('change', function() {
            carregarDados(this.value);
        });
    });

    function carregarDados(periodo) {
        mostrarLoading();
        
        fetch(`/admin/relatorios/dados?periodo=${periodo}`)
            .then(response => response.json())
            .then(data => {
                atualizarEstatisticasGerais(data.estatisticas_gerais);
                atualizarGraficoItensPorCategoria(data.itens_por_categoria);
                atualizarGraficoEventosPorMes(data.eventos_por_mes);
                atualizarGraficoUsuariosPorMes(data.usuarios_por_mes);
                atualizarGraficoItensPorMes(data.itens_por_mes);
                atualizarTopCategorias(data.top_categorias);
                atualizarEventosProximos(data.eventos_proximos);
                esconderLoading();
            })
            .catch(error => {
                console.error('Erro ao carregar dados:', error);
                esconderLoading();
            });
    }

    function atualizarEstatisticasGerais(estatisticas) {
        document.querySelectorAll('#estatisticasGerais .stat-number')[0].textContent = estatisticas.total_usuarios;
        document.querySelectorAll('#estatisticasGerais .stat-number')[1].textContent = estatisticas.total_itens;
        document.querySelectorAll('#estatisticasGerais .stat-number')[2].textContent = estatisticas.total_categorias;
        document.querySelectorAll('#estatisticasGerais .stat-number')[3].textContent = estatisticas.eventos_ativos;
    }

    function atualizarGraficoItensPorCategoria(dados) {
        const ctx = document.getElementById('itensPorCategoriaChart').getContext('2d');
        
        if (charts.itensPorCategoria) {
            charts.itensPorCategoria.destroy();
        }

        const categorias = dados.map(item => item.categoria);
        const quantidades = dados.map(item => item.quantidade);

        // Cores para o gráfico
        const cores = [
            '#667eea', '#764ba2', '#f093fb', '#f5576c',
            '#4facfe', '#00f2fe', '#43e97b', '#38f9d7',
            '#fa709a', '#fee140'
        ];

        charts.itensPorCategoria = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: categorias,
                datasets: [{
                    data: quantidades,
                    backgroundColor: cores,
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });
    }

    function atualizarGraficoEventosPorMes(dados) {
        const ctx = document.getElementById('eventosPorMesChart').getContext('2d');
        
        if (charts.eventosPorMes) {
            charts.eventosPorMes.destroy();
        }

        const meses = dados.map(item => item.mes);
        const quantidades = dados.map(item => item.quantidade);

        charts.eventosPorMes = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: meses,
                datasets: [{
                    label: 'Eventos',
                    data: quantidades,
                    backgroundColor: '#667eea',
                    borderColor: '#764ba2',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    function atualizarGraficoUsuariosPorMes(dados) {
        const ctx = document.getElementById('usuariosPorMesChart').getContext('2d');
        
        if (charts.usuariosPorMes) {
            charts.usuariosPorMes.destroy();
        }

        const meses = dados.map(item => item.mes);
        const quantidades = dados.map(item => item.quantidade);

        charts.usuariosPorMes = new Chart(ctx, {
            type: 'line',
            data: {
                labels: meses,
                datasets: [{
                    label: 'Usuários',
                    data: quantidades,
                    borderColor: '#43e97b',
                    backgroundColor: 'rgba(67, 233, 123, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function atualizarGraficoItensPorMes(dados) {
        const ctx = document.getElementById('itensPorMesChart').getContext('2d');
        
        if (charts.itensPorMes) {
            charts.itensPorMes.destroy();
        }

        const meses = dados.map(item => item.mes);
        const quantidades = dados.map(item => item.quantidade);

        charts.itensPorMes = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: meses,
                datasets: [{
                    label: 'Itens',
                    data: quantidades,
                    backgroundColor: '#fa709a',
                    borderColor: '#fee140',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function atualizarTopCategorias(dados) {
        const tbody = document.getElementById('topCategoriasTable');
        tbody.innerHTML = '';

        dados.forEach(categoria => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${categoria.nome}</td>
                <td>${categoria.quantidade_itens}</td>
            `;
            tbody.appendChild(tr);
        });
    }

    function atualizarEventosProximos(dados) {
        const tbody = document.getElementById('eventosProximosTable');
        tbody.innerHTML = '';

        dados.forEach(evento => {
            const data = new Date(evento.data_evento);
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${evento.nome}</td>
                <td>${data.toLocaleDateString('pt-BR')}</td>
                <td>${evento.local}</td>
            `;
            tbody.appendChild(tr);
        });
    }

    function mostrarLoading() {
        document.getElementById('loadingSpinner').style.display = 'flex';
    }

    function esconderLoading() {
        document.getElementById('loadingSpinner').style.display = 'none';
    }
</script>
@endsection