@extends ('layouts.empresa.app')

@content

<div class="card card-outline-secondary">

    <div class="card-header">
        <h3 class="mb-0">Cadastre seu evento</h3>
    </div>
    <div class="card-body">
        <form class="form" action="">

            <div class="form-group row">
                <label class="col-lg-3 col-form-label form-control-label" for="nomeEvento">Nome do evento</label>
                <div class="col-lg-9">
                    <input class="form-control" type="text" name="nomeEvento" id="nomeEvento" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 col-form-label form-control-label" for="dataEvento">Data do evento</label>
                <div class="col-lg-9">
                    <input class="form-control" type="date" name="dataEvento" id="dataEvento" required>
                </div>
            </div>

            <label for="nomeEvento"></label>
            <input type="text" name="nomeEvento" id="nomeEvento" required>

            <label for="dataEvento"></label>
            <input type="date" name="dataEvento" id="dataEvento" required>

            <label for="descricaoEvento"></label>
            <input type="textbox" name="descricaoEvento" id="descricaoEvento" required>

            <label for="itemEvento"></label>
            <select name="itemEvento" id="itemEvento">
                <option value="brinquedo">Brinquedos</option>
                <option value="roupa">Roupas</option>
                <option value="alimento">Alimento</option>
                <option value="higiene">Produtos de higiene</option>
            </select>
        </form>
    </div>
</div>