@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card">
                <div class="card-header text-center fw-bold">{{ $articulo->nombre }}</div>

                <div class="card-body">

                    @if (Session('warning')) <!-- SE CREA EL ALERTA EN EL INDEX DE ARTICULOS PARA MOSTRAR LA MODIFICACIONES -->
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">  {{ Session('warning') }} </div>
                    @endif

                    @if ($errors->any())   <!-- Alerta de las validaciónes -->
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    <!-- Se colocaron las etiquetas Value para traer la información del articulo a editar.
                         Se modifico la ruta hacia el metodo UPDATE que actualiza los cambios.
                         Se coloco la directiva method: PUT para que se enviíe la información.
                        Como ultimo paso se establecio el enctype para la carga de imagene      -->
                        <form action="{{ route('articulos.update', $articulo) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="nombre" class="form-label"> Nombre </label>
                                <input type="text" class="form-control" id="nombre" name="nombre"
                                    placeholder="Ingrese el nombre del artículo" value="{{ $articulo->nombre }}">
                            </div>
                            <div class="mb-3">
                                <label for="stock" class="form-label"> Stock </label>
                                <input type="text" class="form-control" id="stock" name="stock" placeholder="Ingrese el stock" value="{{ $articulo->stock }}">
                            </div>
                            <div class="mb-3">
                                <label for="precio" class="form-label"> Precio</label>
                                <input type="text" class="form-control" id="precio" name="precio" placeholder="Ingrese el precio" value="{{ $articulo->precio }}">
                            </div>
                            <div class="mb-3">
                                <label for="categoria_id" class="form-label"> Categoría </label>
                                <select class="form-control" name="categoria_id" id="categoria_id">
                                    <option value=""> Por favor seleccione la categoría del artículo </option>
                                    @foreach ($categorias as $cat)
                                        <option @selected($cat->id == $articulo->categoria_id) value="{{ $cat->id }}"> {{ $cat->nombre }}  </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="text-center my-4">
                                <img id="imgSeleccionada" class="img-fluid" style="max-height: 300px">  <!-- _Nueva imagen -->
                                <img class="img-thumbnail img-fluid" style=" width: 250px; height: 300px " src="{{ asset('/storage/' . $articulo->img) }}" alt=".."> <!-- imagen actual-->
                            </div>

                            <div class="mb-3">
                                <label for="img" class="form-label"> Imagen </label>
                                <input type="file" class="form-control" id="img" name="img">
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success" data-toggle="tooltip" title="Modificar"> <i class="fa fa-pencil fa-fw text-white"></i> </button>
                                <a href="{{ route('articulos.index') }}" class="btn btn-danger" data-toggle="tooltip" title="Cancelar"> <i class="fa fa-ban" aria-hidden="true"></i> </a>
                            </div>
                        </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- Script para ver la imagen que se va a cargar -->
<script>
    $(document).ready(function (e) {
        $('#img').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#imgSeleccionada').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        });      
    });
</script>