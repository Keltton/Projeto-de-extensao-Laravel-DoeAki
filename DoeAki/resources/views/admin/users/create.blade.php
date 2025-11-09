@extends('layouts.admin')

@section('title', 'Cadastrar Usuário - DoeAki')

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1>Cadastrar Usuário</h1>
            <p>Adicione um novo usuário ao sistema</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i data-lucide="arrow-left"></i> Voltar
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label for="name" class="form-label">Nome Completo *</label>
                    <input type="text" name="name" id="name" class="form-control" 
                           value="{{ old('name') }}" required placeholder="Digite o nome completo">
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" name="email" id="email" class="form-control" 
                           value="{{ old('email') }}" required placeholder="exemplo@email.com">
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Senha *</label>
                    <input type="password" name="password" id="password" class="form-control" 
                           required placeholder="Mínimo 6 caracteres" minlength="6">
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <small class="form-text">A senha deve ter pelo menos 6 caracteres</small>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirmar Senha *</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="form-control" required placeholder="Digite a senha novamente">
                    <small class="form-text">Digite a mesma senha para confirmação</small>
                </div>

                <div class="form-group">
                    <label for="role" class="form-label">Tipo de Usuário *</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="">Selecione o tipo</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Usuário Comum</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                    </select>
                    @error('role')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    <small class="form-text">Administradores têm acesso total ao sistema</small>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="user-plus"></i> Cadastrar Usuário
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i data-lucide="x"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    /* Estilos específicos para o formulário de usuário */
    .password-strength {
        margin-top: 0.5rem;
        padding: 0.5rem;
        border-radius: 5px;
        font-size: 0.875rem;
        display: none;
    }

    .password-weak {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .password-medium {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    .password-strong {
        background: #d1edf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
    }

    .form-requirements {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        border-left: 4px solid #667eea;
    }

    .form-requirements h4 {
        margin: 0 0 0.5rem 0;
        color: #333;
        font-size: 0.9rem;
    }

    .form-requirements ul {
        margin: 0;
        padding-left: 1.2rem;
        color: #666;
        font-size: 0.875rem;
    }

    .form-requirements li {
        margin-bottom: 0.25rem;
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
    }

    @media (max-width: 576px) {
        .card-body {
            padding: 1rem;
        }
        
        .form-control {
            padding: 0.75rem;
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        lucide.createIcons();

        // Validação de força da senha
        const passwordInput = document.getElementById('password');
        const passwordConfirmInput = document.getElementById('password_confirmation');
        
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                validatePasswordStrength(this.value);
                validatePasswordMatch();
            });
        }

        if (passwordConfirmInput) {
            passwordConfirmInput.addEventListener('input', validatePasswordMatch);
        }

        function validatePasswordStrength(password) {
            let strength = 0;
            let feedback = '';
            
            if (password.length >= 6) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/\d/)) strength++;
            if (password.match(/[^a-zA-Z\d]/)) strength++;
            
            const strengthElement = document.getElementById('password-strength');
            if (!strengthElement) {
                const div = document.createElement('div');
                div.id = 'password-strength';
                div.className = 'password-strength';
                passwordInput.parentNode.appendChild(div);
            }
            
            const element = document.getElementById('password-strength');
            
            if (password.length === 0) {
                element.style.display = 'none';
                return;
            }
            
            element.style.display = 'block';
            
            switch(strength) {
                case 0:
                case 1:
                    element.className = 'password-strength password-weak';
                    element.textContent = 'Senha fraca';
                    break;
                case 2:
                case 3:
                    element.className = 'password-strength password-medium';
                    element.textContent = 'Senha média';
                    break;
                case 4:
                    element.className = 'password-strength password-strong';
                    element.textContent = 'Senha forte';
                    break;
            }
        }

        function validatePasswordMatch() {
            const password = passwordInput.value;
            const confirmPassword = passwordConfirmInput.value;
            
            if (confirmPassword === '') return;
            
            if (password !== confirmPassword) {
                passwordConfirmInput.style.borderColor = '#dc3545';
                passwordConfirmInput.style.boxShadow = '0 0 0 0.2rem rgba(220, 53, 69, 0.25)';
            } else {
                passwordConfirmInput.style.borderColor = '#28a745';
                passwordConfirmInput.style.boxShadow = '0 0 0 0.2rem rgba(40, 167, 69, 0.25)';
            }
        }

        // Validação do formulário antes do envio
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const password = passwordInput.value;
            const confirmPassword = passwordConfirmInput.value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('As senhas não coincidem. Por favor, verifique.');
                passwordConfirmInput.focus();
            }
            
            if (password.length < 6) {
                e.preventDefault();
                alert('A senha deve ter pelo menos 6 caracteres.');
                passwordInput.focus();
            }
        });
    });
</script>
@endsection