@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="header">
    <h1>Dashboard</h1>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<p>Bem-vindo ao painel administrativo, {{ Auth::user()->name }}!</p>

@endsection
