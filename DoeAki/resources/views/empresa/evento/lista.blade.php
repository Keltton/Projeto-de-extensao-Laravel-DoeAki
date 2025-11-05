@extends('layouts.empresa.app')
@section('title', 'Dashboard')

@section('content')




<div class="content">
    <main class="row g-4">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ( $Eventos as $Evento)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('storage/' . $Evento->img_path) }}" class="card-img-top" alt="imagem do evento">
                    <div class="card-body">
                        <h5 class="card-title"><a href="{{ route('evento.show', parameters: $Evento ) }}">{{ $Evento->nome }}</a></h5>
                        <p class="card-text">{{$Evento->descricao}}</p>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-primary btn-sm"
                                onclick="window.location='{{ route('empresa.evento.gerenciar', $Evento->id) }}';">
                                <i class="bi bi-pencil"></i> Editar
                            </button>

                            <form action="{{ route('empresa.evento.destroy', $Evento->id) }}"
                                method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Tem certeza que deseja excluir este evento?');">
                                    <i class="bi bi-trash"></i> Deletar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </main>
</div>
@endsection