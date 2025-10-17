@extends ('layouts.empresa.app')

@section('title', 'Gerenciar Eventos')

@section('content')

<div class="container py-5 main-gerenciar ">

    <div class="col-md-10 offset-md-1">


        <h2 class="mb-4">Cadastre seu evento</h2>


        <form class="form" action="">

            <div class="form-group row ">
                <label class="col-lg-3 col-form-label form-control-label" for="nomeEvento"> <strong>Nome do evento: </strong></label>
                <div class="col-lg-9">
                    <input class="form-control" type="text" name="nomeEvento" id="nomeEvento" required>
                </div>
            </div>

            <div class="form-group row mt-5">
                <label class="col-lg-3 col-form-label form-control-label" for="dataEvento"><strong>Data do evento:</strong></label>
                <div class="col-lg-9">
                    <input class="form-control" type="date" name="dataEvento" id="dataEvento" required>
                </div>
            </div>

            <div class="form-group row mt-5">
                <label class="col-lg-3 col-form-label form-control-label"><strong>Item para ser doado:</strong></label>
                <div class="col-lg-9">
                    <select id="itemEvento" class="form-control" size="0">
                        <option value="brinquedo">Brinquedos</option>
                        <option value="roupa">Roupas</option>
                        <option value="alimento">Alimento</option>
                        <option value="higiene">Produtos de higiene</option>
                    </select>
                </div>
            </div>

            <label for="descricaoEvento" class=" mt-5"><strong>Descrição do Evento</strong></label>
            <div class="row mb-1">
                <div class="col-lg-12">
                    <textarea rows="6" name="descricaoEvento" id="descricaoEvento" class="form-control" required></textarea>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection