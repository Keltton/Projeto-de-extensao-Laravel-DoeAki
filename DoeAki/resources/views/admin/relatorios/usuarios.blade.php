@extends('layouts.admin')

@section('title', 'Relatório de Usuários - DoeAki')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>👥 Relatório de Usuários</h1>
        <a href="{{ route('admin.relatorios.index') }}" class="btn btn-secondary">
            Voltar aos Relatórios
        </a>
    </div>

    <!-- Lista de Usuários -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">📋 Lista de Usuários ({{ $usuarios->count() }})</h5>
        </div>
        <div class="card-body">
            @if($usuarios->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Função</th>
                                <th>Doações</th>
                                <th>Data Registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->telefone ?? 'Não informado' }}</td>
                                <td>
                                    <span class="badge 
                                        @if($usuario->role == 'admin') bg-danger
                                        @else bg-primary @endif">
                                        {{ ucfirst($usuario->role) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $usuario->doacoes_count }}</span>
                                </td>
                                <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i data-lucide="users" style="color: #ccc; width: 48px; height: 48px;"></i>
                    <p class="text-muted mt-2">Nenhum usuário encontrado</p>
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