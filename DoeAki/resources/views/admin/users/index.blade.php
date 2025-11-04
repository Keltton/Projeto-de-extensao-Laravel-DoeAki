@extends('layouts.admin')

@section('title', 'Usuários')

@section('content')

<div class="header">
    <h1>Gerenciar Usuários</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Novo Usuário</a>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<table>
    <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Data de Criação</th>
            <th>Permissão</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
            <td>{{ $user->role }}</td>
            <td>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">Editar</a>

                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('Tem certeza?')">Excluir</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
