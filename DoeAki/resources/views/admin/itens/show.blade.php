@extends('layouts.app') {{-- Or your base layout --}}

@section('content')
<div class="container">
    <h1>Detalhes do Evento</h1>
    
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $Evento->nome }}</h5>
            <p class="card-text"><strong>Data:</strong> {{ $Evento->data_evento }}</p>
            <p class="card-text"><strong>Local:</strong> {{ $Evento->local }}</p>
            <p class="card-text"><strong>Descrição:</strong> {{ $Evento->descricao }}</p>
            
            <a href="{{ route('admin.empresa.eventos.index') }}" class="btn btn-secondary">Voltar</a>
            <a href="{{ route('admin.empresa.eventos.edit', $Evento->id) }}" class="btn btn-warning">Editar</a>
        </div>
    </div>
</div>
@endsection