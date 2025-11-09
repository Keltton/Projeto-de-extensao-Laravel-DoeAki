@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-5">Sobre Nós</h2>
    <p class="text-center mb-5">Conheça a nossa equipe que torna tudo possível!</p>

    <div class="row justify-content-center g-4">
        <!-- Card 1 -->
        <div class="col-md-4 col-lg-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('images/equipe1.jpg') }}" class="card-img-top" alt="Nome 1">
                <div class="card-body text-center">
                    <h5 class="card-title">Nome 1</h5>
                    <p class="card-text">Cargo 1</p>
                    <a href="https://www.linkedin.com/in/link1" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="fab fa-linkedin"></i> LinkedIn
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4 col-lg-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('images/equipe2.jpg') }}" class="card-img-top" alt="Nome 2">
                <div class="card-body text-center">
                    <h5 class="card-title">Nome 2</h5>
                    <p class="card-text">Cargo 2</p>
                    <a href="https://www.linkedin.com/in/link2" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="fab fa-linkedin"></i> LinkedIn
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-4 col-lg-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('images/equipe3.jpg') }}" class="card-img-top" alt="Nome 3">
                <div class="card-body text-center">
                    <h5 class="card-title">Nome 3</h5>
                    <p class="card-text">Cargo 3</p>
                    <a href="https://www.linkedin.com/in/link3" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="fab fa-linkedin"></i> LinkedIn
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-md-4 col-lg-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('images/equipe4.jpg') }}" class="card-img-top" alt="Nome 4">
                <div class="card-body text-center">
                    <h5 class="card-title">Nome 4</h5>
                    <p class="card-text">Cargo 4</p>
                    <a href="https://www.linkedin.com/in/link4" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="fab fa-linkedin"></i> LinkedIn
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 5 -->
        <div class="col-md-4 col-lg-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('images/equipe5.jpg') }}" class="card-img-top" alt="Nome 5">
                <div class="card-body text-center">
                    <h5 class="card-title">Nome 5</h5>
                    <p class="card-text">Cargo 5</p>
                    <a href="https://www.linkedin.com/in/link5" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="fab fa-linkedin"></i> LinkedIn
                    </a>
                </div>
            </div>
        </div>

        <!-- Card 6 -->
        <div class="col-md-4 col-lg-4">
            <div class="card h-100 shadow-sm">
                <img src="{{ asset('images/equipe6.jpg') }}" class="card-img-top" alt="Nome 6">
                <div class="card-body text-center">
                    <h5 class="card-title">Nome 6</h5>
                    <p class="card-text">Cargo 6</p>
                    <a href="https://www.linkedin.com/in/link6" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="fab fa-linkedin"></i> LinkedIn
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
