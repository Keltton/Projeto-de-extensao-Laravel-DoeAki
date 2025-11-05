@extends ('layouts.empresa.app')

@section('title', 'Adivionar Evento')

@section('content')

<div class="col d-flex flex-column h-sm-100">
    <main class="row overflow-auto">
        <div class="container py-5 main-gerenciar ">

            <div class="col-md-10 offset-md-1">


                <h1 class="mb-4">Criar um novo evento</h1>


                <form class="form" action="{{ route( 'empresa.evento.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="form-group row ">
                        <label class="col-lg-3 col-form-label form-control-label" for="nome"> <strong>Nome do evento: </strong></label>
                        <div class="col-lg-9">
                            <input class="form-control" type="text" name="nome" id="nome" required>
                        </div>
                    </div>

                    <div class="form-group row mt-5">
                        <label class="col-lg-3 col-form-label form-control-label" for="data_vencimento"><strong>Data de vencimento do evento:</strong></label>
                        <div class="col-lg-9">
                            <input class="form-control" type="date" name="data_vencimento" id="data_vencimento" required>
                        </div>
                    </div>

                    <div class="form-group row mt-5">
                        <label class="col-lg-3 col-form-label form-control-label" for="img_path"> <strong>Imagen do evento: </strong></label>
                        <div class="col-lg-9">
                            <input class="form-control" type="file" id="img_path" name="img_path">
                        </div>
                    </div>

                    <div class="form-group row mt-5">
                        <label class="col-lg-3 col-form-label form-control-label" for="Id_tipo"><strong>Item para ser doado:</strong></label>
                        <div class="col-lg-9">
                            <select id="Id_tipo" name="Id_tipo" class="form-control" size="0">
                                <option value="1">Brinquedos</option>
                                <option value="2">Roupas</option>
                                <option value="3">Alimento</option>
                                <option value="4">Produtos de higiene</option>
                            </select>
                        </div>
                    </div>

                    <label for="descricao" class=" mt-5"><strong>Descrição do Evento</strong></label>
                    <div class="row mb-1">
                        <div class="col-lg-12">
                            <textarea rows="6" name="descricao" id="descricao" class="form-control" required></textarea>
                        </div>
                    </div>

                    <div class="d-grid gap-4 d-md-flex justify-content-md-end mt-5">
                        <button type="submit" class="btn btn-success me-md-2">Salvar</button>
                        <button type="button" class="btn btn-danger" onclick="history.back()">Voltar</button>
                    </div>

                </form>
            </div>
        </div>
    </main>
</div>

@endsection