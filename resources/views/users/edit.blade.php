@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Editar Usuario</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
        </div>
    @endif


    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin" {{ $user->is_admin ? 'checked' : '' }}>
            <label class="form-check-label" for="is_admin">Administrador</label>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="is_visible" name="is_visible" {{ $user->is_visible ? 'checked' : '' }}>
            <label class="form-check-label" for="is_visible">Visible</label>
        </div>


        <div class="d-flex justify-content-start">
            <button type="submit" class="btn btn-primary me-2">Actualizar</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Volver a la Lista de Usuarios</a>
        </div>
    </form>

    
</div>
@endsection
