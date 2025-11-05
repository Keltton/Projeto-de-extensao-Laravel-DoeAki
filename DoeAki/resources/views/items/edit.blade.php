@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-edit me-2"></i>Editar Item</h1>
        <a href="{{ route('items.show', $item) }}" class="btn btn-info">
            <i class="fas fa-eye me-1"></i>Ver Item
        </a>
    </div>

    <div class="card">
        <div class="card-header bg-warning text-white">
            <h5 class="card-title mb-0">Editar Informações do Item</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('items.update', $item) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome do Item *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $item->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Categoria *</label>
                            <select class="form-control @error('category_id') is-invalid @enderror"
                                    id="category_id" name="category_id" required>
                                <option value="">Selecione uma categoria</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="price" class="form-label">Preço (R$)</label>
                            <input type="number" step="0.01" min="0"
                                   class="form-control @error('price') is-invalid @enderror"
                                   id="price" name="price" value="{{ old('price', $item->price) }}"
                                   placeholder="0.00">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Deixe em branco se não houver preço.</div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                              id="description" name="description" rows="4"
                              placeholder="Descreva o item...">{{ old('description', $item->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-1"></i>Atualizar Item
                        </button>
                        <a href="{{ route('items.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('items.show', $item) }}" class="btn btn-outline-info">
                            <i class="fas fa-eye me-1"></i>Visualizar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Card de Informações Atuais -->
    <div class="card mt-4">
        <div class="card-header bg-light">
            <h5 class="card-title mb-0">Informações Atuais</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <strong>Nome:</strong><br>
                    {{ $item->name }}
                </div>
                <div class="col-md-3">
                    <strong>Categoria:</strong><br>
                    <span class="badge bg-info">{{ $item->category->name }}</span>
                </div>
                <div class="col-md-3">
                    <strong>Preço:</strong><br>
                    @if($item->price)
                        R$ {{ number_format($item->price, 2, ',', '.') }}
                    @else
                        <span class="text-muted">Não informado</span>
                    @endif
                </div>
                <div class="col-md-3">
                    <strong>Última atualização:</strong><br>
                    {{ $item->updated_at->format('d/m/Y H:i') }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Formatação do preço
    document.getElementById('price').addEventListener('blur', function(e) {
        let value = parseFloat(e.target.value);
        if (!isNaN(value) && value >= 0) {
            e.target.value = value.toFixed(2);
        }
    });
</script>
@endsection
