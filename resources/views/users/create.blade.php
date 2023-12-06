@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Agregar Nuevo Usuario</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="d-flex justify-content-start">
        <button type="submit" class="btn btn-primary me-2">Guardar</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Volver a la Lista de Usuarios</a>
        </div>

    </form>
</div>
@endsection
