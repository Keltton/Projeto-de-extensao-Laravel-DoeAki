@extends('layouts.app')

@section('title', 'Detalhes da Doação')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.perfil') }}">
                                <i class="fas fa-user me-2"></i>Meu Perfil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('user.doacoes.index') }}">
                                <i class="fas fa-hand-holding-heart me-2"></i>Minhas Doações
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.eventos.meus') }}">
                                <i class="fas fa-calendar-check me-2"></i>Meus Eventos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">
                                <i class="fas fa-home me-2"></i>Voltar para Home
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">
                        <i class="fas fa-hand-holding-heart me-2"></i>Detalhes da Doação
                    </h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="{{ route('user.doacoes.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Voltar
                        </a>
                    </div>
                </div>

                <!-- Mensagens -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-lg-8">
                        <!-- Card de Informações da Doação -->
                        <div class="card shadow mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Informações da Doação
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th width="40%">Item Doado:</th>
                                                <td>
                                                    <strong>{{ $doacao->item->nome }}</strong>
                                                    @if($doacao->item->categoria)
                                                        <br><small
                                                            class="text-muted">{{ $doacao->item->categoria->nome }}</small>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Quantidade:</th>
                                                <td>
                                                    <span class="badge bg-primary fs-6">{{ $doacao->quantidade }}
                                                        unidades</span>
                                                </td>
                                            </tr>
                                            <tr>
                                            <tr>
                                                <th>Condição:</th>
                                                <td>
                                                    <span class="badge bg-{{ $doacao->condicao_color }}">
                                                        {{ $doacao->condicao_label }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <th width="40%">Status:</th>
                                                <td>
                                                    @php
                                                        $statusColors = [
                                                            'pendente' => 'warning',
                                                            'aceita' => 'success',
                                                            'rejeitada' => 'danger',
                                                            'entregue' => 'info'
                                                        ];
                                                    @endphp
                                                    <span
                                                        class="badge bg-{{ $statusColors[$doacao->status] ?? 'secondary' }} fs-6">
                                                        {{ ucfirst($doacao->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Data da Doação:</th>
                                                <td>{{ $doacao->created_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Última Atualização:</th>
                                                <td>{{ $doacao->updated_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- Descrição -->
                                @if($doacao->descricao)
                                    <div class="mt-4">
                                        <h6 class="text-primary">
                                            <i class="fas fa-align-left me-2"></i>Descrição:
                                        </h6>
                                        <div class="border rounded p-3 bg-light">
                                            {{ $doacao->descricao }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Ações -->
                        @if($doacao->status === 'pendente')
                            <div class="card shadow">
                                <div class="card-header bg-warning">
                                    <h6 class="card-title mb-0 text-white">
                                        <i class="fas fa-exclamation-triangle me-2"></i>Ações Disponíveis
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p class="text-muted mb-3">
                                        Sua doação está aguardando análise. Você pode cancelá-la enquanto não for aprovada.
                                    </p>
                                    <form action="{{ route('user.doacoes.destroy', $doacao->id) }}" method="POST"
                                        onsubmit="return confirm('Tem certeza que deseja cancelar esta doação?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-times me-1"></i> Cancelar Doação
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-lg-4">
                        <!-- Status Timeline -->
                        <div class="card shadow mb-4">
                            <div class="card-header bg-info text-white">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-history me-2"></i>Status da Doação
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="timeline">
                                    @php
                                        $timeline = [
                                            'pendente' => ['icon' => 'clock', 'color' => 'warning', 'label' => 'Doação Registrada', 'active' => true],
                                            'aceita' => ['icon' => 'check', 'color' => 'success', 'label' => 'Doação Aprovada', 'active' => in_array($doacao->status, ['aceita', 'entregue'])],
                                            'entregue' => ['icon' => 'truck', 'color' => 'info', 'label' => 'Item Recebido', 'active' => $doacao->status === 'entregue']
                                        ];

                                        if ($doacao->status === 'rejeitada') {
                                            $timeline = [
                                                'pendente' => ['icon' => 'clock', 'color' => 'warning', 'label' => 'Doação Registrada', 'active' => true],
                                                'rejeitada' => ['icon' => 'times', 'color' => 'danger', 'label' => 'Doação Recusada', 'active' => true]
                                            ];
                                        }
                                    @endphp

                                    @foreach($timeline as $status => $info)
                                        <div class="timeline-item {{ $info['active'] ? 'active' : '' }}">
                                            <div class="timeline-marker bg-{{ $info['color'] }}">
                                                <i class="fas fa-{{ $info['icon'] }}"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <h6 class="mb-1">{{ $info['label'] }}</h6>
                                                @if($info['active'])
                                                    <small class="text-muted">Concluído</small>
                                                @else
                                                    <small class="text-muted">Pendente</small>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Informações de Contato -->
                        <div class="card shadow">
                            <div class="card-header bg-secondary text-white">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-phone me-2"></i>Precisa de Ajuda?
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="small text-muted mb-3">
                                    Em caso de dúvidas sobre sua doação, entre em contato conosco.
                                </p>
                                <div class="d-grid gap-2">
                                    <a href="mailto:felipepestanadev@gmail.com" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-envelope me-1"></i> Enviar Email
                                    </a>
                                    <a href="tel:+5511999999999" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-phone me-1"></i> Ligar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <style>
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }

        .timeline-item.active .timeline-marker {
            background-color: #28a745 !important;
        }

        .timeline-marker {
            position: absolute;
            left: -30px;
            top: 0;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 10px;
        }

        .timeline-content {
            padding-bottom: 10px;
        }

        .timeline-item:not(:last-child)::after {
            content: '';
            position: absolute;
            left: -21px;
            top: 20px;
            bottom: -10px;
            width: 2px;
            background-color: #dee2e6;
        }

        .timeline-item.active:not(:last-child)::after {
            background-color: #28a745;
        }
    </style>
@endsection