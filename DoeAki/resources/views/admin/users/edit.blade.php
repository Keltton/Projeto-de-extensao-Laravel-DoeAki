@extends('layouts.admin')

@section('title', 'Editar Usuário - DoeAki')

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1>Editar Usuário</h1>
            <p>Atualize as informações do usuário</p>
        </div>
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i data-lucide="arrow-left"></i> Voltar
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label for="name" class="form-label">Nome Completo *</label>
                    <input type="text" name="name" id="name" class="form-control" 
                           value="{{ old('name', $user->name) }}" required placeholder="Digite o nome completo">
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" name="email" id="email" class="form-control" 
                           value="{{ old('email', $user->email) }}" required placeholder="exemplo@email.com">
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="role" class="form-label">Tipo de Usuário *</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="">Selecione o tipo</option>
                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Usuário Comum</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrador</option>
                    </select>
                    @error('role')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <small class="form-text">Administradores têm acesso total ao sistema</small>
                </div>

                <div class="form-group full-width">
                    <div class="form-requirements">
                        <h4>Informações do Usuário</h4>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                            <div>
                                <strong>Data de Criação:</strong><br>
                                {{ $user->created_at->format('d/m/Y H:i') }}
                            </div>
                            <div>
                                <strong>Última Atualização:</strong><br>
                                {{ $user->updated_at->format('d/m/Y H:i') }}
                            </div>
                            <div>
                                <strong>Status:</strong><br>
                                <span class="badge badge-success">Ativo</span>
                            </div>
                        </div>
                    </div>
                </div>

                @if(auth()->id() === $user->id)
                    <div class="form-group full-width">
                        <div class="alert alert-warning">
                            <div style="display: flex; align-items: flex-start; gap: 0.75rem;">
                                <i data-lucide="shield-alert" style="width: 20px; height: 20px; flex-shrink: 0;"></i>
                                <div>
                                    <strong>Editando seu próprio usuário</strong>
                                    <p style="margin: 0.25rem 0 0 0; font-size: 0.875rem;">
                                        Você está editando suas próprias informações. Tenha cuidado ao alterar as permissões.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="save"></i> Atualizar Usuário
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i data-lucide="x"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    .user-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .info-item {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        border-left: 4px solid #667eea;
    }

    .info-item strong {
        display: block;
        color: #333;
        margin-bottom: 0.25rem;
        font-size: 0.875rem;
    }

    .info-item span {
        color: #666;
        font-size: 0.875rem;
    }

    .form-requirements {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        border: 1px solid #e9ecef;
    }

    .form-requirements h4 {
        margin: 0 0 1rem 0;
        color: #333;
        font-size: 1rem;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 0.5rem;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }

        .user-info-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .card-body {
            padding: 1rem;
        }
        
        .form-control {
            padding: 0.75rem;
        }
        
        .form-requirements {
            padding: 1rem;
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        lucide.createIcons();

        // Validação do formulário
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            
            if (!email.includes('@')) {
                e.preventDefault();
                alert('Por favor, insira um email válido.');
                document.getElementById('email').focus();
            }
        });
    });
</script>
@endsection