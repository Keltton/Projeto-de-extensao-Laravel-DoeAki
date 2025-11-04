@extends('layouts.admin')

@section('title', 'Editar Usuário')

@section('content')

<div class="header">
    <h1>Editar Usuário</h1>
</div>

<form action="{{ route('admin.users.update', $user) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nome:</label>
    <input type="text" name="name" value="{{ $user->name }}" required><br><br>

    <label>Email:</label>
    <input type="email" name="email" value="{{ $user->email }}" required><br><br>

    <label>Permissão</label>
    <select name="role" required>
        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Usuário</option>
        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrador</option>
    </select><br><br>
    <button class="btn btn-primary">Atualizar</button>
</form>

@endsection
