@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header text-center fw-bold">{{ __('Agregar Categoría') }}</div>

                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                        <!-- Se establecio la directiva @csrf para que me genere el token de verificacion de informacion que envia el usuario.
                         Tambien se establecioo el metodo POST para recibir la informacion del metodo STORE.
                         Se establecio la ruta al metodo STORE donde guarda la información recibida -->
                        <form action="{{ route('categorias.store') }}" method="POST">
                            @csrf
                            <div class="mb-3 text-center">
                                <label for="nombre" class="form-label"> Nombre </label>
                                <input type="text" class="form-control text-center" id="nombre" name="nombre"
                                    placeholder="Ingrese el nombre de la categoría" value="{{ old('nombre') }}">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" data-toggle="tooltip" title="Agregar Categoría"> <i class="fa fa-plus" aria-hidden="true"></i> </button>
                                <a href="{{ route('categorias.index') }}" class="btn btn-danger" data-toggle="tooltip" title="Cancelar"> <i class="fa fa-ban" aria-hidden="true"></i> </a>
                            </div>
                        </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection