@extends('layouts.admin')

@section('title', 'Detalhes da Doação - Admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i data-lucide="gift" class="me-2"></i>Detalhes da Doação
        </h1>
        <div>
            <a href="{{ route('admin.doacoes.gerenciar') }}" class="btn btn-secondary">
                <i data-lucide="arrow-left" class="me-1"></i> Voltar
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

    <div class="row">
        <!-- Informações da Doação -->
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i data-lucide="info" class="me-2"></i>Informações da Doação
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">ID da Doação:</th>
                                    <td>#{{ $doacao->id }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        <span class="badge bg-{{ $doacao->status_color }}">
                                            {{ $doacao->status_label }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Item Doado:</th>
                                    <td>
                                        <strong>{{ $doacao->item->nome }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            Categoria: {{ $doacao->item->categoria->nome }}
                                        </small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Quantidade:</th>
                                    <td>
                                        <span class="badge bg-primary fs-6">{{ $doacao->quantidade }} unidades</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Condição:</th>
                                    <td>
                                        <span class="badge bg-{{ $doacao->condicao_color }}">
                                            {{ $doacao->condicao_label }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Data da Doação:</th>
                                    <td>{{ $doacao->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @if($doacao->data_aprovacao)
                                <tr>
                                    <th>Data de Aprovação:</th>
                                    <td>{{ $doacao->data_aprovacao->format('d/m/Y H:i') }}</td>
                                </tr>
                                @endif
                                @if($doacao->data_entrega)
                                <tr>
                                    <th>Data de Entrega:</th>
                                    <td>{{ $doacao->data_entrega->format('d/m/Y H:i') }}</td>
                                </tr>
                                @endif
                                @if($doacao->aprovador)
                                <tr>
                                    <th>Aprovado por:</th>
                                    <td>{{ $doacao->aprovador->name }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <!-- Informações de Estoque -->
                    @if($doacao->status == 'aceita' || $doacao->status == 'entregue')
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <div class="d-flex align-items-center">
                                    <i data-lucide="package" class="me-2"></i>
                                    <div>
                                        <strong>Informações de Estoque:</strong>
                                        @if($doacao->adicionado_estoque)
                                            <span class="badge bg-success ms-2">Adicionado ao estoque</span>
                                            @if($doacao->data_entrada_estoque)
                                                <small class="text-muted d-block mt-1">
                                                    Entrou no estoque em: {{ $doacao->data_entrada_estoque->format('d/m/Y H:i') }}
                                                </small>
                                            @endif
                                        @else
                                            <span class="badge bg-warning ms-2">Não está no estoque</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($doacao->descricao)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6>Descrição Adicional:</h6>
                            <div class="border rounded p-3 bg-light">
                                {{ $doacao->descricao }}
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($doacao->motivo_rejeicao)
                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="text-danger">Motivo da Rejeição:</h6>
                            <div class="border border-danger rounded p-3 bg-light">
                                {{ $doacao->motivo_rejeicao }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Informações do Doador -->
            <div class="card shadow mt-4">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i data-lucide="user" class="me-2"></i>Informações do Doador
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Nome:</th>
                                    <td>{{ $doacao->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $doacao->user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Telefone:</th>
                                    <td>{{ $doacao->user->telefone ?? 'Não informado' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Data de Cadastro:</th>
                                    <td>{{ $doacao->user->created_at->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>CPF:</th>
                                    <td>{{ $doacao->user->cpf ?? 'Não informado' }}</td>
                                </tr>
                                <tr>
                                    <th>Cadastro Completo:</th>
                                    <td>
                                        @if($doacao->user->cadastro_completo)
                                            <span class="badge bg-success">Sim</span>
                                        @else
                                            <span class="badge bg-warning">Não</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ações e Status -->
        <div class="col-lg-4">
            <!-- Ações Rápidas -->
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i data-lucide="zap" class="me-2"></i>Ações Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    @if($doacao->status == 'pendente')
                        <div class="d-grid gap-2">
                            <form action="{{ route('admin.doacoes.aprovar', $doacao->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100 mb-2">
                                    <i data-lucide="check" class="me-1"></i> Aprovar Doação
                                </button>
                            </form>
                            <button type="button" class="btn btn-danger w-100" onclick="showRejeitarModal()">
                                <i data-lucide="x" class="me-1"></i> Rejeitar Doação
                            </button>
                        </div>
                    @elseif($doacao->status == 'aceita')
                        <div class="d-grid gap-2">
                            <form action="{{ route('admin.doacoes.entregue', $doacao->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-info w-100 mb-2">
                                    <i data-lucide="truck" class="me-1"></i> Marcar como Entregue
                                </button>
                            </form>
                            @if($doacao->adicionado_estoque)
                                <div class="alert alert-success text-center py-2 mb-0">
                                    <small>
                                        <i data-lucide="package" class="me-1"></i>
                                        No estoque desde {{ $doacao->data_entrada_estoque?->format('d/m/Y') }}
                                    </small>
                                </div>
                            @endif
                        </div>
                    @elseif($doacao->status == 'entregue')
                        <div class="alert alert-info text-center">
                            <i data-lucide="check-circle" class="me-1"></i>
                            Doação finalizada e entregue
                            <br>
                            <small class="text-muted">
                                Em {{ $doacao->data_entrega?->format('d/m/Y') }}
                            </small>
                        </div>
                    @elseif($doacao->status == 'rejeitada')
                        <div class="alert alert-danger text-center">
                            <i data-lucide="x-circle" class="me-1"></i>
                            Doação rejeitada
                            <br>
                            <small class="text-muted">
                                Em {{ $doacao->data_rejeicao?->format('d/m/Y') }}
                            </small>
                        </div>
                    @else
                        <p class="text-muted text-center">
                            <i data-lucide="info" class="me-1"></i>
                            Nenhuma ação disponível para este status.
                        </p>
                    @endif
                </div>
            </div>

            <!-- Timeline do Status -->
            <div class="card shadow mt-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="card-title mb-0">
                        <i data-lucide="clock" class="me-2"></i>Histórico da Doação
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <!-- Doação Registrada -->
                        <div class="timeline-item {{ in_array($doacao->status, ['aceita', 'rejeitada', 'entregue']) ? 'completed' : ($doacao->status == 'pendente' ? 'active' : '') }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6>Doação Registrada</h6>
                                <small>{{ $doacao->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                        
                        <!-- Aprovação -->
                        @if(in_array($doacao->status, ['aceita', 'entregue']))
                        <div class="timeline-item {{ $doacao->status == 'entregue' ? 'completed' : 'active' }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6>Doação Aprovada</h6>
                                <small>{{ $doacao->data_aprovacao ? $doacao->data_aprovacao->format('d/m/Y H:i') : 'Pendente' }}</small>
                                @if($doacao->aprovador)
                                <br>
                                <small class="text-muted">Por: {{ $doacao->aprovador->name }}</small>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Entrada no Estoque -->
                        @if($doacao->adicionado_estoque && $doacao->data_entrada_estoque)
                        <div class="timeline-item {{ $doacao->status == 'entregue' ? 'completed' : 'active' }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6>Adicionado ao Estoque</h6>
                                <small>{{ $doacao->data_entrada_estoque->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>
                        @endif

                        <!-- Entrega -->
                        @if($doacao->status == 'entregue')
                        <div class="timeline-item completed">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6>Item Entregue</h6>
                                <small>{{ $doacao->data_entrega ? $doacao->data_entrega->format('d/m/Y H:i') : 'Pendente' }}</small>
                            </div>
                        </div>
                        @endif

                        <!-- Rejeição -->
                        @if($doacao->status == 'rejeitada')
                        <div class="timeline-item rejected">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6>Doação Rejeitada</h6>
                                <small>{{ $doacao->data_rejeicao ? $doacao->data_rejeicao->format('d/m/Y H:i') : 'Pendente' }}</small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Informações Rápidas -->
            <div class="card shadow mt-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">
                        <i data-lucide="bar-chart" class="me-2"></i>Estatísticas do Item
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $totalAceitas = \App\Models\Doacao::where('item_id', $doacao->item_id)
                            ->where('status', 'aceita')
                            ->sum('quantidade');
                        
                        $totalEntregues = \App\Models\Doacao::where('item_id', $doacao->item_id)
                            ->where('status', 'entregue')
                            ->sum('quantidade');
                    @endphp
                    
                    <div class="mb-3">
                        <small class="text-muted">Total recebido deste item:</small>
                        <div class="fw-bold">{{ $totalAceitas + $totalEntregues }} unidades</div>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">Atualmente no estoque:</small>
                        <div class="fw-bold">{{ $totalAceitas }} unidades</div>
                    </div>
                    
                    <div>
                        <small class="text-muted">Já entregues:</small>
                        <div class="fw-bold">{{ $totalEntregues }} unidades</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Rejeitar Doação -->
<div class="modal fade" id="rejeitarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejeitar Doação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.doacoes.rejeitar', $doacao->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Informe o motivo da rejeição da doação <strong>#{{ $doacao->id }}</strong>:</p>
                    <textarea name="motivo_rejeicao" class="form-control" rows="4" placeholder="Digite o motivo da rejeição..." required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Confirmar Rejeição</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .badge.bg-pendente { background-color: #ffc107; color: #000; }
    .badge.bg-aceita { background-color: #198754; }
    .badge.bg-rejeitada { background-color: #dc3545; }
    .badge.bg-entregue { background-color: #0dcaf0; color: #000; }
    
    .badge.bg-novo { background-color: #198754; }
    .badge.bg-seminovo { background-color: #0dcaf0; color: #000; }
    .badge.bg-usado { background-color: #ffc107; color: #000; }
    .badge.bg-precisa_reparo { background-color: #dc3545; }

    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }

    .timeline-marker {
        position: absolute;
        left: -30px;
        top: 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #dee2e6;
        border: 3px solid #fff;
    }

    .timeline-item.completed .timeline-marker {
        background: #198754;
    }

    .timeline-item.active .timeline-marker {
        background: #0dcaf0;
    }

    .timeline-item.rejected .timeline-marker {
        background: #dc3545;
    }

    .timeline-content h6 {
        margin-bottom: 5px;
        font-weight: 600;
    }

    .timeline-content small {
        color: #6c757d;
    }

    .alert-info {
        border-left: 4px solid #0dcaf0;
    }

    .alert-success {
        border-left: 4px solid #198754;
    }

    .alert-danger {
        border-left: 4px solid #dc3545;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        lucide.createIcons();
    });

    function showRejeitarModal() {
        const modal = new bootstrap.Modal(document.getElementById('rejeitarModal'));
        modal.show();
    }
</script>
@endsection