@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Meu Perfil</h2>

    {{-- Mensagens de feedback --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('user.perfil.atualizar') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nome *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Email *</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Telefone</label>
                <input type="text" name="telefone" id="telefone" class="form-control" 
                       value="{{ old('telefone', $user->telefone) }}">
            </div>
            <div class="col-md-4 mb-3">
                <label>Data de Nascimento</label>
                <input type="date" name="data_nascimento" class="form-control" 
                       value="{{ old('data_nascimento', $user->perfil->data_nascimento ?? '') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label>CPF</label>
                <input type="text" name="cpf" id="cpf" class="form-control" 
                       value="{{ old('cpf', $user->cpf) }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label>CEP</label>
                <input type="text" name="cep" id="cep" class="form-control" 
                       value="{{ old('cep', $user->cep) }}">
            </div>
            <div class="col-md-8 mb-3">
                <label>Endereço</label>
                <input type="text" name="endereco" id="endereco" class="form-control" 
                       value="{{ old('endereco', $user->endereco) }}">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Cidade</label>
                <input type="text" name="cidade" id="cidade" class="form-control" 
                       value="{{ old('cidade', $user->cidade) }}">
            </div>
            <div class="col-md-6 mb-3">
                <label>Estado</label>
                <input type="text" name="estado" id="estado" class="form-control" 
                       value="{{ old('estado', $user->estado) }}">
            </div>
        </div>

        <div class="mb-3">
            <label>Sobre você</label>
            <textarea name="sobre" class="form-control" rows="3">{{ old('sobre', $user->sobre) }}</textarea>
        </div>

        <hr>

        <div class="mb-3 form-check">
            <input type="checkbox" name="possui_empresa" id="possui_empresa" value="1" class="form-check-input"
                {{ old('possui_empresa', $user->possui_empresa) ? 'checked' : '' }}>
            <label class="form-check-label" for="possui_empresa">
                Desejo cadastrar uma empresa com CNPJ
            </label>
        </div>

        <div id="empresa_fields" style="display: {{ $user->possui_empresa ? 'block' : 'none' }}">
            <div class="mb-3">
                <label>Razão Social</label>
                <input type="text" name="razao_social" class="form-control" 
                       value="{{ old('razao_social', $user->perfil->razao_social ?? $user->empresa_nome ?? '') }}">
            </div>
            <div class="mb-3">
                <label>CNPJ</label>
                <input type="text" name="cnpj" id="cnpj" class="form-control" 
                       value="{{ old('cnpj', $user->perfil->cnpj ?? $user->empresa_cnpj ?? '') }}">
            </div>
            <div class="mb-3">
                <label>Inscrição Estadual</label>
                <input type="text" name="inscricao_estadual" class="form-control" 
                       value="{{ old('inscricao_estadual', $user->perfil->inscricao_estadual ?? '') }}">
            </div>
            <div class="mb-3">
                <label>Endereço da Empresa</label>
                <input type="text" name="endereco_empresa" class="form-control" 
                       value="{{ old('endereco_empresa', $user->perfil->endereco_empresa ?? $user->empresa_endereco ?? '') }}">
            </div>
            <div class="mb-3">
                <label>Telefone da Empresa</label>
                <input type="text" name="telefone_empresa" class="form-control" 
                       value="{{ old('telefone_empresa', $user->perfil->telefone_empresa ?? '') }}">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
<script>
$(document).ready(function() {
    // Máscaras de input
    $('#telefone').inputmask('(99) 99999-9999');
    $('#cpf').inputmask('999.999.999-99');
    $('#cep').inputmask('99999-999');
    $('#cnpj').inputmask('99.999.999/9999-99');

    // Exibir campos de empresa
    $('#possui_empresa').on('change', function() {
        $('#empresa_fields').toggle(this.checked);
    });

    // Buscar endereço pelo CEP
    $('#cep').on('blur', function() {
        let cep = $(this).val().replace(/\D/g, '');
        if (cep.length === 8) {
            $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function(data) {
                if (!data.erro) {
                    $('#endereco').val(data.logradouro);
                    $('#cidade').val(data.localidade);
                    $('#estado').val(data.uf);
                }
            });
        }
    });
});
</script>
@endsection