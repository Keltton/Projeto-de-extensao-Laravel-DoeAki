    @extends('layouts.empresa.app')
    @section('title', 'Dashboard')

    <!-- Aqui começa o conteudo da pagina -->
    @section('content')
    <div class="col d-flex flex-column h-sm-100">
        <main class="row overflow-auto">
            <div class="col pt-4">
                <h1>Dashboard</h1>
                <p>Bem vindo a sua dashboard! aqui voce pode gerenciar eventos, editar seu perfil e gerar relatórios!</p>
            </div>


            <!-- Graficos, o codigo de verdade está em js/app.js-->
            <div class="card p-4" style="height: 78vh;">
                <canvas id="eventosChart"></canvas>
            </div>
        </main>
    </div>

    @endsection