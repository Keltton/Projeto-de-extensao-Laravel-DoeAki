@extends('layouts.admin')

@section('title', 'Relatório Geral - DoeAki')

@section('content')
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1>Relatório Geral</h1>
            <p>Visão geral completa do sistema</p>
        </div>
        <a href="{{ route('admin.relatorios.index') }}" class="btn btn-secondary">
            Voltar ao Dashboard
        </a>
    </div>
</div>

<!-- Conteúdo do relatório geral -->
<div class="row">
    <!-- Adicione o conteúdo do relatório geral aqui -->
</div>
@endsection