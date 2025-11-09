@extends('layouts.admin')

@section('title', 'Dashboard Admin - DoeAki')

@section('content')
<div class="page-header">
    <h1>Dashboard Administrativo</h1>
    <p>Bem-vindo, {{ Auth::user()->name }}! 👋</p>
</div>

<!-- Estatísticas Principais -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: #e3f2fd;">
            <i data-lucide="users" style="color: #1976d2;"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">{{ $totalUsers }}</span>
            <span class="stat-label">Total de Usuários</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: #e8f5e8;">
            <i data-lucide="package" style="color: #2e7d32;"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">{{ $totalItens }}</span>
            <span class="stat-label">Itens Cadastrados</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: #fff3e0;">
            <i data-lucide="folder" style="color: #f57c00;"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">{{ $totalCategorias }}</span>
            <span class="stat-label">Categorias</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: #fce4ec;">
            <i data-lucide="calendar" style="color: #c2185b;"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">{{ $totalEventos }}</span>
            <span class="stat-label">Eventos Ativos</span>
        </div>
    </div>
</div>

<!-- Estatísticas de Doações -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: #fff8e1;">
            <i data-lucide="gift" style="color: #ffa000;"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">{{ $totalDoacoes }}</span>
            <span class="stat-label">Total de Doações</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: #fff3e0;">
            <i data-lucide="clock" style="color: #ff9800;"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">{{ $doacoesPendentes }}</span>
            <span class="stat-label">Pendentes</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: #e8f5e8;">
            <i data-lucide="check-circle" style="color: #4caf50;"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">{{ $doacoesAceitas }}</span>
            <span class="stat-label">Aceitas</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: #ffebee;">
            <i data-lucide="x-circle" style="color: #f44336;"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">{{ $doacoesRejeitadas }}</span>
            <span class="stat-label">Rejeitadas</span>
        </div>
    </div>
</div>

<!-- Estatísticas de Estoque -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: #e8f5e8;">
            <i data-lucide="package" style="color: #2e7d32;"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">{{ $estoqueTotal }}</span>
            <span class="stat-label">Itens no Estoque</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: #e3f2fd;">
            <i data-lucide="tags" style="color: #1976d2;"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">{{ $itensUnicos }}</span>
            <span class="stat-label">Tipos de Itens</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: #f3e5f5;">
            <i data-lucide="trending-up" style="color: #7b1fa2;"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">{{ $aprovadasHoje }}</span>
            <span class="stat-label">Aprovadas Hoje</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: #e0f2f1;">
            <i data-lucide="truck" style="color: #00796b;"></i>
        </div>
        <div class="stat-info">
            <span class="stat-number">{{ $doacoesEntregues }}</span>
            <span class="stat-label">Entregues</span>
        </div>
    </div>
</div>

<div class="content-grid">
    <!-- Doações Pendentes -->
    <div class="dashboard-section">
        <div class="section-header">
            <h3>📦 Doações Pendentes de Aprovação</h3>
            @if($doacoesRecentes->count() > 0)
                <a href="{{ route('admin.doacoes.gerenciar') }}" class="view-all-btn">Ver Todas</a>
            @endif
        </div>
        
        @if($doacoesRecentes->count() > 0)
            <div class="doacoes-list">
                @foreach($doacoesRecentes as $doacao)
                <div class="doacao-item">
                    <div class="doacao-info">
                        <div class="doacao-header">
                            <strong>{{ $doacao->item->nome ?? 'Item não encontrado' }}</strong>
                            <span class="quantidade-badge">{{ $doacao->quantidade }} un.</span>
                        </div>
                        <div class="doacao-details">
                            <span class="doador">Por: {{ $doacao->user->name }}</span>
                            <span class="categoria">{{ $doacao->item->categoria->nome ?? 'Sem categoria' }}</span>
                        </div>
                        <div class="doacao-meta">
                            <span class="condicao-badge condicao-{{ $doacao->condicao }}">
                                {{ $doacao->condicao_label ?? $doacao->condicao }}
                            </span>
                            <span class="data">{{ $doacao->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                    <div class="doacao-actions">
                        <form action="{{ route('admin.doacoes.aprovar', $doacao->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn-aprovar" title="Aprovar doação">
                                <i data-lucide="check"></i>
                            </button>
                        </form>
                        <button class="btn-rejeitar" onclick="showRejeitarModal({{ $doacao->id }})" title="Rejeitar doação">
                            <i data-lucide="x"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i data-lucide="package" style="color: #ccc; width: 48px; height: 48px;"></i>
                <p>Nenhuma doação pendente</p>
            </div>
        @endif
    </div>
    
    <!-- Ações Rápidas -->
    <div class="dashboard-section">
        <h3>⚡ Ações Rápidas</h3>
        <div class="actions-grid">
            <a href="{{ route('admin.users.index') }}" class="quick-action-btn">
                <i data-lucide="users"></i>
                <span>Gerenciar Usuários</span>
            </a>
            <a href="{{ route('admin.doacoes.gerenciar') }}" class="quick-action-btn">
                <i data-lucide="gift"></i>
                <span>Gerenciar Doações</span>
            </a>
            <a href="{{ route('admin.itens.index') }}" class="quick-action-btn">
                <i data-lucide="package"></i>
                <span>Gerenciar Itens</span>
            </a>
            <a href="{{ route('admin.categorias.index') }}" class="quick-action-btn">
                <i data-lucide="folder"></i>
                <span>Categorias</span>
            </a>
            <a href="{{ route('admin.eventos.index') }}" class="quick-action-btn">
                <i data-lucide="calendar"></i>
                <span>Eventos</span>
            </a>
            <a href="{{ route('admin.doacoes.relatorio') }}" class="quick-action-btn">
                <i data-lucide="bar-chart"></i>
                <span>Relatórios</span>
            </a>
        </div>
    </div>
</div>

<!-- Modal para Rejeitar Doação -->
<div id="rejeitarModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h4>Rejeitar Doação</h4>
            <button type="button" class="close-modal" onclick="closeRejeitarModal()">
                <i data-lucide="x"></i>
            </button>
        </div>
        <form id="rejeitarForm" method="POST">
            @csrf
            <div class="modal-body">
                <p>Informe o motivo da rejeição:</p>
                <textarea name="motivo_rejeicao" rows="4" placeholder="Digite o motivo da rejeição..." required></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeRejeitarModal()">Cancelar</button>
                <button type="submit" class="btn-confirm">Confirmar Rejeição</button>
            </div>
        </form>
    </div>
</div>

<style>
    .page-header {
        margin-bottom: 2rem;
    }

    .page-header h1 {
        color: #333;
        margin-bottom: 0.5rem;
    }

    .page-header p {
        color: #666;
        margin: 0;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-info {
        flex: 1;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #333;
        display: block;
        line-height: 1;
    }

    .stat-label {
        color: #666;
        font-size: 0.9rem;
        margin-top: 0.25rem;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    .dashboard-section {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 0.5rem;
    }

    .section-header h3 {
        margin: 0;
        color: #333;
    }

    .view-all-btn {
        background: #667eea;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.8rem;
        transition: background 0.3s ease;
    }

    .view-all-btn:hover {
        background: #5a6fd8;
    }

    .doacoes-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .doacao-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #ffa000;
    }

    .doacao-info {
        flex: 1;
    }

    .doacao-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .quantidade-badge {
        background: #667eea;
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-size: 0.8rem;
    }

    .doacao-details {
        display: flex;
        gap: 1rem;
        margin-bottom: 0.5rem;
    }

    .doador, .categoria {
        font-size: 0.9rem;
        color: #666;
    }

    .doacao-meta {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .condicao-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .condicao-novo { background: #e8f5e8; color: #2e7d32; }
    .condicao-seminovo { background: #e3f2fd; color: #1976d2; }
    .condicao-usado { background: #fff3e0; color: #f57c00; }
    .condicao-precisa_reparo { background: #ffebee; color: #c62828; }

    .data {
        font-size: 0.8rem;
        color: #888;
    }

    .doacao-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-aprovar, .btn-rejeitar {
        padding: 0.5rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .btn-aprovar {
        background: #4caf50;
        color: white;
    }

    .btn-aprovar:hover {
        background: #45a049;
    }

    .btn-rejeitar {
        background: #f44336;
        color: white;
    }

    .btn-rejeitar:hover {
        background: #da190b;
    }

    .empty-state {
        text-align: center;
        padding: 2rem;
        color: #888;
    }

    .actions-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .quick-action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 1.5rem 1rem;
        background: #f8f9fa;
        border: 2px solid transparent;
        border-radius: 10px;
        text-decoration: none;
        color: #333;
        transition: all 0.3s ease;
        text-align: center;
    }

    .quick-action-btn:hover {
        background: white;
        border-color: #667eea;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
    }

    .quick-action-btn i {
        margin-bottom: 0.5rem;
        color: #667eea;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        width: 90%;
        max-width: 500px;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .close-modal {
        background: none;
        border: none;
        cursor: pointer;
        color: #666;
    }

    .modal-body textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        resize: vertical;
    }

    .modal-footer {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 1rem;
    }

    .btn-cancel, .btn-confirm {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .btn-cancel {
        background: #6c757d;
        color: white;
    }

    .btn-cancel:hover {
        background: #5a6268;
    }

    .btn-confirm {
        background: #dc3545;
        color: white;
    }

    .btn-confirm:hover {
        background: #c82333;
    }

    @media (max-width: 768px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .actions-grid {
            grid-template-columns: 1fr;
        }
        
        .doacao-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .doacao-actions {
            align-self: flex-end;
        }
        
        .doacao-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        lucide.createIcons();
    });

    function showRejeitarModal(doacaoId) {
        const modal = document.getElementById('rejeitarModal');
        const form = document.getElementById('rejeitarForm');
        
        form.action = `/admin/doacoes/${doacaoId}/rejeitar`;
        modal.style.display = 'flex';
    }

    function closeRejeitarModal() {
        const modal = document.getElementById('rejeitarModal');
        modal.style.display = 'none';
        
        // Limpar formulário
        const form = document.getElementById('rejeitarForm');
        form.reset();
    }

    // Fechar modal ao clicar fora
    document.getElementById('rejeitarModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeRejeitarModal();
        }
    });
</script>
@endsection