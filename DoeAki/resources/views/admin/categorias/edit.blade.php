@extends('layouts.admin')

@section('content')
    <div class="main-content">
        <div class="page-header">
            <h1>Editar Categoria</h1>
            <p>Atualize as informações da categoria</p>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Informações da Categoria</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categorias.update', $categoria->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="titulo" class="form-label">Nome do Evento *</label>
                        <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo') }}"
                            required>
                        @error('titulo')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao"
                            rows="3">{{ old('descricao', $categoria->descricao) }}</textarea>
                    </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Atualizar Categoria</button>
                <a href="{{ route('admin.categorias.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
            </form>
        </div>
    </div>
    </div>
@endsection