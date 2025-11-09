@extends('layouts.admin')

@section('title', 'Editar Evento - Dashboard Admin')

@section('content')
<div class="page-header">
    <div class="header-content">
        <div>
            <h1>Editar Evento</h1>
            <p>Atualize as informações do evento</p>
        </div>
        <a href="{{ route('admin.eventos.index') }}" class="btn btn-secondary">
            <i data-lucide="arrow-left"></i> Voltar
        </a>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <div class="alert-content">
            <i data-lucide="alert-circle" class="alert-icon"></i>
            <div>
                <strong>Erro!</strong> Por favor, verifique os campos do formulário.
            </div>
        </div>
        <button type="button" class="alert-close" onclick="this.parentElement.style.display='none'">×</button>
    </div>
@endif

@if(session('success'))
    <div class="alert alert-success">
        <div class="alert-content">
            <i data-lucide="check-circle" class="alert-icon"></i>
            <div>{{ session('success') }}</div>
        </div>
        <button type="button" class="alert-close" onclick="this.parentElement.style.display='none'">×</button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.eventos.update', $evento->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label for="nome" class="form-label">Nome do Evento *</label>
                    <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror" 
                           value="{{ old('nome', $evento->nome) }}" required maxlength="255">
                    @error('nome')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="data_evento" class="form-label">Data e Hora do Evento *</label>
                    <input type="datetime-local" name="data_evento" id="data_evento" 
                           class="form-control @error('data_evento') is-invalid @enderror" 
                           value="{{ old('data_evento', $evento->data_evento->format('Y-m-d\TH:i')) }}" required>
                    @error('data_evento')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="local" class="form-label">Local *</label>
                    <input type="text" name="local" id="local" class="form-control @error('local') is-invalid @enderror" 
                           value="{{ old('local', $evento->local) }}" required maxlength="255">
                    @error('local')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Status *</label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="ativo" {{ old('status', $evento->status) == 'ativo' ? 'selected' : '' }}>Ativo</option>
                        <option value="inativo" {{ old('status', $evento->status) == 'inativo' ? 'selected' : '' }}>Inativo</option>
                        <option value="cancelado" {{ old('status', $evento->status) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                    @error('status')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label for="descricao" class="form-label">Descrição</label>
                    <textarea name="descricao" id="descricao" class="form-control @error('descricao') is-invalid @enderror" 
                              rows="4" maxlength="1000">{{ old('descricao', $evento->descricao) }}</textarea>
                    <small class="form-text">Máximo 1000 caracteres</small>
                    @error('descricao')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="endereco" class="form-label">Endereço Completo</label>
                    <input type="text" name="endereco" id="endereco" class="form-control @error('endereco') is-invalid @enderror" 
                           value="{{ old('endereco', $evento->endereco) }}" maxlength="255">
                    @error('endereco')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input type="text" name="cidade" id="cidade" class="form-control @error('cidade') is-invalid @enderror" 
                           value="{{ old('cidade', $evento->cidade) }}" maxlength="100">
                    @error('cidade')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="estado" class="form-label">Estado</label>
                    <select name="estado" id="estado" class="form-control @error('estado') is-invalid @enderror">
                        <option value="">Selecione um estado</option>
                        <option value="AC" {{ old('estado', $evento->estado) == 'AC' ? 'selected' : '' }}>Acre</option>
                        <option value="AL" {{ old('estado', $evento->estado) == 'AL' ? 'selected' : '' }}>Alagoas</option>
                        <option value="AP" {{ old('estado', $evento->estado) == 'AP' ? 'selected' : '' }}>Amapá</option>
                        <option value="AM" {{ old('estado', $evento->estado) == 'AM' ? 'selected' : '' }}>Amazonas</option>
                        <option value="BA" {{ old('estado', $evento->estado) == 'BA' ? 'selected' : '' }}>Bahia</option>
                        <option value="CE" {{ old('estado', $evento->estado) == 'CE' ? 'selected' : '' }}>Ceará</option>
                        <option value="DF" {{ old('estado', $evento->estado) == 'DF' ? 'selected' : '' }}>Distrito Federal</option>
                        <option value="ES" {{ old('estado', $evento->estado) == 'ES' ? 'selected' : '' }}>Espírito Santo</option>
                        <option value="GO" {{ old('estado', $evento->estado) == 'GO' ? 'selected' : '' }}>Goiás</option>
                        <option value="MA" {{ old('estado', $evento->estado) == 'MA' ? 'selected' : '' }}>Maranhão</option>
                        <option value="MT" {{ old('estado', $evento->estado) == 'MT' ? 'selected' : '' }}>Mato Grosso</option>
                        <option value="MS" {{ old('estado', $evento->estado) == 'MS' ? 'selected' : '' }}>Mato Grosso do Sul</option>
                        <option value="MG" {{ old('estado', $evento->estado) == 'MG' ? 'selected' : '' }}>Minas Gerais</option>
                        <option value="PA" {{ old('estado', $evento->estado) == 'PA' ? 'selected' : '' }}>Pará</option>
                        <option value="PB" {{ old('estado', $evento->estado) == 'PB' ? 'selected' : '' }}>Paraíba</option>
                        <option value="PR" {{ old('estado', $evento->estado) == 'PR' ? 'selected' : '' }}>Paraná</option>
                        <option value="PE" {{ old('estado', $evento->estado) == 'PE' ? 'selected' : '' }}>Pernambuco</option>
                        <option value="PI" {{ old('estado', $evento->estado) == 'PI' ? 'selected' : '' }}>Piauí</option>
                        <option value="RJ" {{ old('estado', $evento->estado) == 'RJ' ? 'selected' : '' }}>Rio de Janeiro</option>
                        <option value="RN" {{ old('estado', $evento->estado) == 'RN' ? 'selected' : '' }}>Rio Grande do Norte</option>
                        <option value="RS" {{ old('estado', $evento->estado) == 'RS' ? 'selected' : '' }}>Rio Grande do Sul</option>
                        <option value="RO" {{ old('estado', $evento->estado) == 'RO' ? 'selected' : '' }}>Rondônia</option>
                        <option value="RR" {{ old('estado', $evento->estado) == 'RR' ? 'selected' : '' }}>Roraima</option>
                        <option value="SC" {{ old('estado', $evento->estado) == 'SC' ? 'selected' : '' }}>Santa Catarina</option>
                        <option value="SP" {{ old('estado', $evento->estado) == 'SP' ? 'selected' : '' }}>São Paulo</option>
                        <option value="SE" {{ old('estado', $evento->estado) == 'SE' ? 'selected' : '' }}>Sergipe</option>
                        <option value="TO" {{ old('estado', $evento->estado) == 'TO' ? 'selected' : '' }}>Tocantins</option>
                    </select>
                    @error('estado')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="cep" class="form-label">CEP</label>
                    <input type="text" name="cep" id="cep" class="form-control @error('cep') is-invalid @enderror" 
                           value="{{ old('cep', $evento->cep) }}" maxlength="9">
                    @error('cep')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="vagas_total" class="form-label">Total de Vagas</label>
                    <input type="number" name="vagas_total" id="vagas_total" class="form-control @error('vagas_total') is-invalid @enderror" 
                           value="{{ old('vagas_total', $evento->vagas_total) }}" min="0" placeholder="Deixe em branco para ilimitado">
                    @error('vagas_total')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="vagas_disponiveis" class="form-label">Vagas Disponíveis</label>
                    <input type="number" name="vagas_disponiveis" id="vagas_disponiveis" class="form-control @error('vagas_disponiveis') is-invalid @enderror" 
                           value="{{ old('vagas_disponiveis', $evento->vagas_disponiveis) }}" min="0">
                    @error('vagas_disponiveis')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label class="form-label">Imagem Atual</label>
                    <div class="current-image">
                        @if($evento->imagem)
                            <img src="{{ asset('storage/' . $evento->imagem) }}" 
                                 alt="{{ $evento->nome }}" 
                                 class="image-preview">
                            <div class="image-actions">
                                <label class="checkbox-label">
                                    <input type="checkbox" name="remover_imagem" id="remover_imagem" class="checkbox-input">
                                    <span class="checkbox-text">Remover imagem atual</span>
                                </label>
                            </div>
                        @else
                            <div class="no-image">
                                <i data-lucide="image" class="no-image-icon"></i>
                                <p class="no-image-text">Nenhuma imagem definida</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group full-width">
                    <label for="imagem" class="form-label">Nova Imagem do Evento</label>
                    <input type="file" name="imagem" id="imagem" class="form-control @error('imagem') is-invalid @enderror" 
                           accept="image/*" onchange="previewNewImage(this)">
                    <small class="form-text">Formatos: JPEG, PNG, JPG, GIF (Max: 2MB)</small>
                    @error('imagem')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                    
                    <div id="newImagePreview" class="image-preview-container" style="display: none;">
                        <img id="newPreview" src="#" alt="Preview" class="image-preview-new">
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="save"></i> Atualizar Evento
                </button>
                <a href="{{ route('admin.eventos.index') }}" class="btn btn-secondary">
                    <i data-lucide="x"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<style>
/* Page Header */
.page-header {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.page-header h1 {
    margin: 0;
    color: #2d3748;
    font-size: 1.875rem;
    font-weight: 700;
}

.page-header p {
    margin: 0.5rem 0 0 0;
    color: #718096;
    font-size: 1rem;
}

/* Alerts */
.alert {
    padding: 1rem 1.5rem;
    border-radius: 8px;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border: 1px solid transparent;
}

.alert-danger {
    background-color: #fed7d7;
    border-color: #feb2b2;
    color: #c53030;
}

.alert-success {
    background-color: #c6f6d5;
    border-color: #9ae6b4;
    color: #276749;
}

.alert-content {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.alert-icon {
    width: 20px;
    height: 20px;
}

.alert-close {
    background: none;
    border: none;
    font-size: 1.25rem;
    cursor: pointer;
    color: inherit;
    opacity: 0.7;
}

.alert-close:hover {
    opacity: 1;
}

/* Card */
.card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}

.card-body {
    padding: 2rem;
}

/* Form Grid */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.full-width {
    grid-column: 1 / -1;
}

.form-label {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #2d3748;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.form-control {
    padding: 0.75rem 1rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.form-control.is-invalid {
    border-color: #fc8181;
}

textarea.form-control {
    resize: vertical;
    min-height: 120px;
    line-height: 1.5;
}

.form-text {
    color: #718096;
    font-size: 0.875rem;
    margin-top: 0.5rem;
}

.error-message {
    color: #e53e3e;
    font-size: 0.875rem;
    margin-top: 0.5rem;
    font-weight: 500;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
}

.btn-secondary {
    background: #718096;
    color: white;
}

.btn-secondary:hover {
    background: #4a5568;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(113, 128, 150, 0.3);
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-start;
    border-top: 1px solid #e2e8f0;
    padding-top: 2rem;
    margin-top: 1rem;
}

/* Image Styles */
.current-image {
    text-align: center;
}

.image-preview {
    max-width: 300px;
    max-height: 200px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.no-image {
    background: #f7fafc;
    padding: 3rem 2rem;
    border-radius: 8px;
    border: 2px dashed #cbd5e0;
    text-align: center;
}

.no-image-icon {
    width: 48px;
    height: 48px;
    color: #a0aec0;
    margin-bottom: 1rem;
}

.no-image-text {
    color: #718096;
    margin: 0;
    font-size: 0.875rem;
}

.image-actions {
    margin-top: 1rem;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
}

.checkbox-input {
    width: 16px;
    height: 16px;
}

.checkbox-text {
    color: #4a5568;
    font-size: 0.875rem;
}

.image-preview-container {
    margin-top: 1rem;
    text-align: center;
}

.image-preview-new {
    max-width: 300px;
    max-height: 200px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* Responsive */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .header-content {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .page-header {
        padding: 1.5rem;
    }
}

/* Select Styles */
select.form-control {
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 0.5rem center;
    background-repeat: no-repeat;
    background-size: 1.5em 1.5em;
    padding-right: 2.5rem;
}

/* File Input */
input[type="file"].form-control {
    padding: 0.5rem;
}

input[type="file"].form-control::file-selector-button {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 4px;
    background: #edf2f7;
    color: #4a5568;
    cursor: pointer;
    margin-right: 1rem;
    transition: background 0.3s ease;
}

input[type="file"].form-control::file-selector-button:hover {
    background: #e2e8f0;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    lucide.createIcons();
    
    // Set min datetime for event date
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    document.getElementById('data_evento').min = now.toISOString().slice(0, 16);
});

function previewNewImage(input) {
    const preview = document.getElementById('newPreview');
    const previewContainer = document.getElementById('newImagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewContainer.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        previewContainer.style.display = 'none';
    }
}

// Auto-calculate available seats when total seats change
document.getElementById('vagas_total')?.addEventListener('change', function() {
    const vagasTotal = parseInt(this.value) || 0;
    const vagasDisponiveis = document.getElementById('vagas_disponiveis');
    
    if (vagasDisponiveis && (!vagasDisponiveis.value || vagasDisponiveis.value === '0')) {
        vagasDisponiveis.value = vagasTotal;
    }
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const requiredFields = this.querySelectorAll('[required]');
    let valid = true;

    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            valid = false;
            field.classList.add('is-invalid');
        } else {
            field.classList.remove('is-invalid');
        }
    });

    if (!valid) {
        e.preventDefault();
        alert('Por favor, preencha todos os campos obrigatórios.');
    }
});
</script>
@endsection