@extends('layouts.admin')

@section('title', 'Gerenciar Usuários - DoeAki')

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1>Usuários</h1>
            <p>Gerencie todos os Usuários</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i data-lucide="plus"></i> Novo Usuário
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
@endif

<div class="card">
    <div class="card-body">
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Data de Criação</th>
                            <th>Permissão</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    {{ $user->name }}
                                </div>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="badge badge-{{ $user->role == 'admin' ? 'success' : 'info' }}">
                                    {{ $user->role == 'admin' ? 'Administrador' : 'Usuário' }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">
                                        <i data-lucide="edit"></i> Editar
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                                            <i data-lucide="trash-2"></i> Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Informações de paginação ou contagem -->
            <div style="margin-top: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 5px;">
                <small style="color: #666;">
                    Total de {{ $users->count() }} usuário{{ $users->count() !== 1 ? 's' : '' }} encontrado{{ $users->count() !== 1 ? 's' : '' }}
                </small>
            </div>
        @else
            <div style="text-align: center; padding: 3rem; color: #666;">
                <i data-lucide="users" style="width: 64px; height: 64px; color: #ccc; margin-bottom: 1rem;"></i>
                <h3 style="margin-bottom: 0.5rem;">Nenhum usuário encontrado</h3>
                <p style="margin-bottom: 1.5rem;">Comece criando o primeiro usuário!</p>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i data-lucide="user-plus"></i> Criar Primeiro Usuário
                </a>
            </div>
        @endif
    </div>
</div>

<style>
    /* Estilos específicos para a página de usuários */
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 0.875rem;
    }

    .table-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    /* Melhorias responsivas para a tabela */
    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.875rem;
        }
        
        .table th,
        .table td {
            padding: 0.75rem 0.5rem;
        }
        
        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.8rem;
        }
    }

    @media (max-width: 576px) {
        .table-responsive {
            font-size: 0.8rem;
        }
        
        .table th:nth-child(3),
        .table td:nth-child(3) {
            display: none;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        lucide.createIcons();
        
        // Adicionar confirmação para exclusão de usuários admin
        const deleteForms = document.querySelectorAll('form[action*="destroy"]');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                const userName = this.closest('tr').querySelector('td:first-child').textContent.trim();
                if (!confirm(`Tem certeza que deseja excluir o usuário "${userName}"? Esta ação não pode ser desfeita.`)) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endsection