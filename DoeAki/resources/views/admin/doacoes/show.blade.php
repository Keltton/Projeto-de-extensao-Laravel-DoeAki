@extends('layouts.admin')

@section('title', 'Detalhes da Doação - ' . $doacao->id)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>📦 Detalhes da Doação #{{ $doacao->id }}</h1>
        <a href="{{ route('admin.doacoes.gerenciar') }}" class="btn btn-secondary">
            <i data-lucide="arrow-left"></i> Voltar
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Informações da Doação</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th width="200">ID:</th>
                            <td>#{{ $doacao->id }}</td>
                        </tr>
                        <tr>
                            <th>Usuário:</th>
                            <td>{{ $doacao->user->name }} ({{ $doacao->user->email }})</td>
                        </tr>
                        <tr>
                            <th>Item:</th>
                            <td>{{ $doacao->item->nome }} - {{ $doacao->item->categoria->nome }}</td>
                        </tr>
                        <tr>
                            <th>Quantidade:</th>
                            <td>{{ $doacao->quantidade }} unidades</td>
                        </tr>
                        <tr>
                            <th>Condição:</th>
                            <td>
                                <span class="badge bg-{{ $doacao->condicao_color }}">
                                    {{ $doacao->condicao_label }}
                                </span>
                            </td>
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
                            <th>Data de Criação:</th>
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
                        @if($doacao->motivo_rejeicao)
                        <tr>
                            <th>Motivo da Rejeição:</th>
                            <td>{{ $doacao->motivo_rejeicao }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Ações</h5>
                </div>
                <div class="card-body">
                    @if($doacao->status == 'pendente')
                        <form action="{{ route('admin.doacoes.aprovar', $doacao->id) }}" method="POST" class="mb-2">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i data-lucide="check"></i> Aprovar Doação
                            </button>
                        </form>
                        <button type="button" class="btn btn-danger w-100" onclick="showRejeitarModal({{ $doacao->id }})">
                            <i data-lucide="x"></i> Rejeitar Doação
                        </button>
                    @elseif(in_array($doacao->status, ['aceita', 'aprovado']) && $doacao->status != 'entregue')
                        <form action="{{ route('admin.doacoes.entregue', $doacao->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-info w-100">
                                <i data-lucide="truck"></i> Marcar como Entregue
                            </button>
                        </form>
                    @elseif($doacao->status == 'entregue')
                        <div class="alert alert-success">
                            <i data-lucide="check-circle"></i> Doação já foi entregue
                        </div>
                    @endif
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
            <form id="rejeitarForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Informe o motivo da rejeição:</p>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        lucide.createIcons();
    });

    function showRejeitarModal(doacaoId) {
        const form = document.getElementById('rejeitarForm');
        form.action = `/admin/doacoes/${doacaoId}/rejeitar`;
        const modal = new bootstrap.Modal(document.getElementById('rejeitarModal'));
        modal.show();
    }
</script>
@endsection