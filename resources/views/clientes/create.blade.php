@extends('layouts.app')

@section('title', 'Cadastro de Doador')

@section('content')
<div class="container py-4">
    <h1>Cadastro de Doador</h1>

    <form action="{{ route('clientes.store') }}" method="POST" class="mt-4">
        @csrf <!-- importante para formulários no Laravel -->

        <div class="mb-3">
            <label class="form-label">Nome:</label>
            <input type="text" name="nome" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Endereço:</label>
            <input type="text" name="endereco" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Complemento:</label>
            <input type="text" name="complemento" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Número:</label>
            <input type="text" name="numero" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">CEP:</label>
            <input type="text" name="cep" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Cidade:</label>
            <input type="text" name="cidade" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Estado:</label>
            <input type="text" name="estado" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">País:</label>
            <input type="text" name="pais" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Telefone:</label>
            <input type="text" name="telefone" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>
</div>
@endsection
