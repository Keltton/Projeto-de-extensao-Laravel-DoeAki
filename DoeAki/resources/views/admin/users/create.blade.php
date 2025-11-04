@extends('layouts.admin')

@section('title', 'Novo Usuário')

@section('content')

<div class="header">
    <h1>Cadastrar Usuário</h1>
</div>

<form action="{{ route('admin.users.store') }}" method="POST">
    @csrf

    <label>Nome:</label>
    <input type="text" name="name" value="{{ old('name') }}" required><br><br>

    <label>Email:</label>
    <input type="email" name="email" value="{{ old('email') }}" required><br><br>

    <label>Senha:</label>
    <input type="password" name="password" required><br><br>

    <button class="btn btn-primary">Salvar</button>
</form>

@endsection
