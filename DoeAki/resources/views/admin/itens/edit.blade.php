@extends('layouts.admin')

@section('content')
<div class="main-content">
    <div class="page-header">
        <h1>Editar Item</h1>
        <p>Atualize as informações do item</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Informações do Item</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.itens.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group full-width">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome"
                               value="{{ old('nome', $item->nome) }}" required>
                    </div>

                    <div class="form-group full-width">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3">{{ old('descricao', $item->descricao) }}</textarea>
                    </div>

                    <div class="form-group full-width">
                        <label for="categoria_id" class="form-label">Categoria</label>
                        <select class="form-control" id="categoria_id" name="categoria_id" required>
                            <option value="">Selecione uma categoria</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}"
                                    {{ old('categoria_id', $item->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Atualizar Item</button>
                    <a href="{{ route('admin.itens.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection