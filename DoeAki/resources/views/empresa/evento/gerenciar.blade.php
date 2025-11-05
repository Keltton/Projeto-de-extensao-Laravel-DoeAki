@extends ('layouts.empresa.app')

@section('title', 'Gerenciar Eventos')

@section('content')

<div class="col d-flex flex-column h-sm-100">
    <main class="row overflow-auto">
        <div class="container py-5 main-gerenciar ">

            <div class="col-md-10 offset-md-1">


                <h1 class="mb-4">Editar seu evento</h1>


                <form class="form" action="{{ route( 'empresa.evento.update',  $Eventos->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                    <div class="form-group row ">
                        <label class="col-lg-3 col-form-label form-control-label" for="nome"> <strong>Nome do evento: </strong></label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" name="nome" id="nome" value="{{ $Eventos -> nome}}" required>
                        </div>
                    </div>

                    <div class="form-group row mt-5">
                        <label class="col-lg-3 col-form-label form-control-label" for="data_vencimento"><strong>Data de vencimento:</strong></label>
                        <div class="col-lg-9">
                            <input class="form-control" type="date" name="data_vencimento" id="data_vencimento" value="{{ $Eventos -> data_vencimento}}" required>
                        </div>
                    </div>

                    <div class="form-group row mt-5">
                        <label class="col-lg-3 col-form-label form-control-label" for="img_path"> <strong>Imagen do evento: </strong></label>
                        <div class="col-lg-9">
                            <input class="form-control" type="file" id="img_path" name="img_path" value="{{ $Eventos -> img_path }}">
                        </div>
                    </div>

                    <div class="form-group row mt-5">
                        <label class="col-lg-3 col-form-label form-control-label" name="id_tipo"><strong>Item para ser doado:</strong></label>
                        <div class="col-lg-9">
                            <select id="id_tipo" class="form-control" size="0" name="id_tipo">
                                <option value="brinquedo">Brinquedos</option>
                                <option value="roupa">Roupas</option>
                                <option value="alimento">Alimento</option>
                                <option value="higiene">Produtos de higiene</option>
                            </select>
                        </div>
                    </div>

                    <label for="descricao" class=" mt-5"><strong>Descrição do Evento</strong></label>
                    <div class="row mb-1">
                        <div class="col-lg-12">
                            <textarea rows="6" name="descricao" id="descricao" class="form-control" value="{{ $Eventos -> descricao }}" required></textarea>
                        </div>
                    </div>

                    <div class="d-grid gap-4 d-md-flex justify-content-md-end mt-5">
                        <button class="btn btn-success me-md-2" type="submit">Salvar</button>
                        <button type="button" class="btn btn-danger" onclick="history.back()">Voltar</button>
                    </div>

                </form>
            </div>
        </div>
    </main>
</div>

@endsection