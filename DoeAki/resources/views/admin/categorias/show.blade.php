@extends('layouts.empresa.app')
@section('title', 'Detalhes do Evento')

@section('content')
<h1>{{ $Evento->nome }}</h1>

<p><strong>Descrição:</strong> {{ $Evento->descricao }}</p>
<p><strong>Data:</strong> {{ date('d/m/Y', strtotime($Evento->data_vencimento)) }}</p>
<p><strong>Tipo:</strong> {{ $Evento->id_tipo }}</p>

@if($Evento->img_path)
    <p><strong>Imagem:</strong></p>
    <img src="{{ asset('storage/'.$Evento->img_path) }}" alt="{{ $Evento->nome }}" width="300">
@endif

<a href="{{ route('empresa.eventos.index') }}" class="btn btn-secondary mt-3">Voltar</a>
@endsection
