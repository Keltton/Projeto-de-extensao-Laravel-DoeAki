@extends('layouts.admin')

@section('title', 'Gerenciar Doações - Admin')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>📦 Gerenciar Doações</h1>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                <i data-lucide="arrow-left"></i> Voltar ao Dashboard
            </a>
        </div>

        <!-- Estatísticas -->
        <div class="row mb-4">
            <div class="col-md-2">
                <div class="card bg-warning text-dark">
                    <div class="card-body text-center">
                        <h5>Pendentes</h5>
                        <h3>{{ $estatisticas['pendentes'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h5>Aceitas</h5>
                        <h3>{{ $estatisticas['aceitas'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-danger text-white">
                    <div class="card-body text-center">
                        <h5>Rejeitadas</h5>
                        <h3>{{ $estatisticas['rejeitadas'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h5>Entregues</h5>
                        <h3>{{ $estatisticas['entregues'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h5>Total</h5>
                        <h3>{{ $estatisticas['total'] }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card bg-secondary text-white">
                    <div class="card-body text-center">
                        <h5>No Estoque</h5>
                        <h3>{{ $estatisticas['aceitas'] }}</h3>
                    </div>
                </div>
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

        <!-- Filtros -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="statusFilter" class="form-label">Filtrar por Status:</label>
                        <select class="form-select" id="statusFilter" onchange="filterDoacoes()">
                            <option value="">Todos os Status</option>
                            <option value="pendente">Pendentes</option>
                            <option value="aceita">Aceitas</option>
                            <option value="rejeitada">Rejeitadas</option>
                            <option value="entregue">Entregues</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="searchFilter" class="form-label">Buscar:</label>
                        <input type="text" class="form-control" id="searchFilter" placeholder="Item ou usuário..."
                            onkeyup="filterDoacoes()">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabela de Doações -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Lista de Doações</h5>
            </div>
            <div class="card-body">
                @if($doacoes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="doacoesTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Usuário</th>
                                    <th>Item</th>
                                    <th>Quantidade</th>
                                    <th>Condição</th>
                                    <th>Status</th>
                                    <th>Data</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($doacoes as $doacao)
                                    <tr data-status="{{ $doacao->status }}">
                                        <td>#{{ $doacao->id }}</td>
                                        <td>
                                            <strong>{{ $doacao->user->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $doacao->user->email }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ $doacao->item->nome }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $doacao->item->categoria->nome }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $doacao->quantidade }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $doacao->condicao_color }}">
                                                {{ $doacao->condicao_label }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $doacao->status_color }}">
                                                {{ $doacao->status_label }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $doacao->created_at->format('d/m/Y H:i') }}
                                            @if($doacao->data_aprovacao)
                                                <br>
                                                <small class="text-muted">
                                                    Aprovada: {{ $doacao->data_aprovacao->format('d/m/Y') }}
                                                </small>
                                            @endif
                                            @if($doacao->data_entrega)
                                                <br>
                                                <small class="text-muted">
                                                    Entregue: {{ $doacao->data_entrega->format('d/m/Y') }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                @if($doacao->status == 'pendente')
                                                    <form action="{{ route('admin.doacoes.aprovar', $doacao->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success" title="Aprovar doação">
                                                            <i data-lucide="check"></i> Aprovar
                                                        </button>
                                                    </form>
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="showRejeitarModal({{ $doacao->id }})" title="Rejeitar doação">
                                                        <i data-lucide="x"></i> Rejeitar
                                                    </button>
                                                @elseif(in_array($doacao->status, ['aceita', 'aprovado']) && $doacao->status != 'entregue')
                                                    <form action="{{ route('admin.doacoes.entregue', $doacao->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-info" title="Marcar como entregue">
                                                            <i data-lucide="truck"></i> Entregue
                                                        </button>
                                                    </form>
                                                @elseif($doacao->status == 'entregue')
                                                    <span class="badge bg-success">✓ Entregue</span>
                                                @endif

                                                <a href="{{ route('admin.doacoes.show', $doacao->id) }}"
                                                    class="btn btn-outline-primary" title="Ver detalhes">
                                                    <i data-lucide="eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginação -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Mostrando {{ $doacoes->firstItem() }} a {{ $doacoes->lastItem() }} de {{ $doacoes->total() }}
                            registros
                        </div>
                        <div>
                            {{ $doacoes->links() }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i data-lucide="package" style="width: 64px; height: 64px; color: #ccc;"></i>
                        <h4 class="mt-3">Nenhuma doação encontrada</h4>
                        <p class="text-muted">Não há doações cadastradas no sistema.</p>
                    </div>
                @endif
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
                        <textarea name="motivo_rejeicao" class="form-control" rows="4"
                            placeholder="Digite o motivo da rejeição..." required></textarea>
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
        .badge.bg-pendente {
            background-color: #ffc107;
            color: #000;
        }

        .badge.bg-aceita {
            background-color: #198754;
        }

        .badge.bg-rejeitada {
            background-color: #dc3545;
        }



        .badge.bg-aprovado {
            background-color: #198754;
        }



        .badge.bg-rejeitado {
            background-color: #dc3545;
        }

        .badge.bg-entregue {
            background-color: #0dcaf0;
            color: #000;
        }

        .table td {
            vertical-align: middle;
        }

        .btn-group-sm .btn {
            margin-right: 2px;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            lucide.createIcons();
        });

        let currentDoacaoId = null;

        function showRejeitarModal(doacaoId) {
            currentDoacaoId = doacaoId;
            const form = document.getElementById('rejeitarForm');
            form.action = `/admin/doacoes/${doacaoId}/rejeitar`;

            const modal = new bootstrap.Modal(document.getElementById('rejeitarModal'));
            modal.show();
        }

        function filterDoacoes() {
            const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
            const searchFilter = document.getElementById('searchFilter').value.toLowerCase();
            const rows = document.querySelectorAll('#doacoesTable tbody tr');

            rows.forEach(row => {
                const status = row.getAttribute('data-status');
                const text = row.textContent.toLowerCase();

                const statusMatch = !statusFilter || status === statusFilter;
                const searchMatch = !searchFilter || text.includes(searchFilter);

                row.style.display = statusMatch && searchMatch ? '' : 'none';
            });
        }

        // Fechar modal e limpar formulário quando fechar
        document.getElementById('rejeitarModal').addEventListener('hidden.bs.modal', function () {
            document.getElementById('rejeitarForm').reset();
            currentDoacaoId = null;
        });
    </script>
@endsection