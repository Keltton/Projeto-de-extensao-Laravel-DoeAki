@extends('layouts.app')

@section('title', 'Cadastro de Doador')

@section('content')
<div class="container py-4">
    <h1>Cadastro de Doador</h1>

    <!-- Mensagens de erro -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Mensagem de sucesso -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('doador.store') }}" method="POST" class="mt-4" id="form-doador">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nome:</label>
            <input type="text" name="nome" class="form-control" value="{{ old('nome') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">CEP:</label>
            <div class="input-group">
                <input type="text" name="cep" id="cep" class="form-control" maxlength="9" placeholder="00000-000" value="{{ old('cep') }}" required>
                <button type="button" class="btn btn-secondary" id="btn-consultar-cep">Consultar CEP</button>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Endereço:</label>
            <input type="text" name="endereco" id="endereco" class="form-control" value="{{ old('endereco') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Número:</label>
            <input type="text" name="numero" class="form-control" value="{{ old('numero') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Complemento:</label>
            <input type="text" name="complemento" class="form-control" value="{{ old('complemento') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Bairro:</label>
            <input type="text" name="bairro" id="bairro" class="form-control" value="{{ old('bairro') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Cidade:</label>
            <input type="text" name="cidade" id="cidade" class="form-control" value="{{ old('cidade') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Estado:</label>
            <input type="text" name="estado" id="estado" class="form-control" value="{{ old('estado') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">País:</label>
            <input type="text" name="pais" class="form-control" value="Brasil" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Telefone:</label>
            <input type="text" name="telefone" class="form-control" value="{{ old('telefone') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
</div>

<script>
document.getElementById('btn-consultar-cep').addEventListener('click', async function() {
    const cep = document.getElementById('cep').value.replace(/\D/g, '');
    if (cep.length !== 8) {
        alert('CEP inválido!');
        return;
    }

    const btn = document.getElementById('btn-consultar-cep');
    btn.disabled = true;
    btn.textContent = 'Consultando...';

    try {
        const response = await fetch(`/buscar-endereco/${cep}`);
        const data = await response.json();

        btn.disabled = false;
        btn.textContent = 'Consultar CEP';

        if (!data.erro) {
            document.getElementById('endereco').value = data.logradouro || '';
            document.getElementById('bairro').value = data.bairro || '';
            document.getElementById('cidade').value = data.localidade || '';
            document.getElementById('estado').value = data.uf || '';
        } else {
            alert(data.mensagem || 'CEP não encontrado.');
            document.getElementById('endereco').value = '';
            document.getElementById('bairro').value = '';
            document.getElementById('cidade').value = '';
            document.getElementById('estado').value = '';
        }
    } catch (error) {
        btn.disabled = false;
        btn.textContent = 'Consultar CEP';
        alert('Erro ao consultar o CEP.');
    }
});
</script>
@endsection
