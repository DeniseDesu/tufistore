@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header text-center fw-bold">{{ __('Artículos') }}</div>

                <div class="card-body">

                    @if (Session('success')) <!-- SE CREA EL ALERTA EN EL INDEX DE ARTICULOS PARA MOSTRAR LA MODIFICACIONES -->
                    <div class="alert alert-success alert-dismissible fade show" role="alert">  {{ Session('success') }} </div>
                    @endif

                    @if (Session('danger')) <!-- SE CREA EL ALERTA EN EL INDEX DE ARTICULOS PARA MOSTRAR LA MODIFICACIONES -->
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">  {{ Session('danger') }} </div>
                    @endif




                    <!-- CREAMOS UN BOTON PARA AGREGAR ARTIULOS Y LE ESTABLEMOS LA RUTA DEL METODO CREATE DEL CONTROLLER DE ARTICULOS -->
                    <div class="text-center mb-4">
                       <a href="{{ route('articulos.create') }}" class="btn btn-primary"> Agregar Artículo </a>
                    </div>

                    <div class="table-responsive">

                        <table class="table text-center">

                            <thread>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Producto</th>
                                    <th>Categoría</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Acciones</th>
                                </tr>
                            </thread>

                            <tbody class="align-middle">
                            <!-- LISTAMOS LAS FIGURITAS QUE TENEMOS Y MOSTRAMOS UN MENSAJE SI NO CREAMOS NINGUNA -->

                                @if ($articulos->count() > 0)

                                    @foreach ($articulos as $art)
                                    <tr>
                                        <td> <img class="img-fluid img-thumbnail" style=" max-width: 70px; height: auto " src="{{ asset('/storage/' . $art->img) }}" alt=".."> </td>
                                        <td> {{ $art-> nombre }}</td>
                                        <td> {{ $art-> categoria->nombre }} </td>
                                        <td> {{ $art-> precio }}</td>
                                        <td> {{ $art-> stock }} </td>
                                        <td> 
                                            <a href="{{ route('articulos.edit', $art) }}" class="btn btn-success" data-toggle="tooltip" title="Editar"> <i class="fa fa-pencil fa-fw text-white"></i> </a>

                                            <form action="{{ route('articulos.destroy', $art) }}" method="POST" class="d-inline js-eliminar" data-toggle="tooltip" title="Eliminar">
                                              @csrf
                                              @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn_eliminar_recurso"> <i class="fa fa-trash-o fa-fw"></i> </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach

                                @else
                                <tr>

                                    <td colspan="15" class="center"> No hay artículos creados </td>

                                </tr>
                                @endif

                            </tbody>

                        </table>

                    </div>

                    <div class="d-flex justify-content-center">
                    {{ $articulos->links() }} <!-- PARAMETRO DEL PAGINADO -->
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    $('.js-eliminar').submit(function(e){
        e.preventDefault();

        Swal.fire({
        title: "¿Estás seguro?",
        text: "Este artículo se eliminará definitivamente",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "¡Sí, eliminar!",
        cancelButtonText: "Cancelar",
        }).then((result) => {
        if (result.value) {
            /*Swal.fire({
            title: "Deleted!",
            text: "Your file has been deleted.",
            icon: "success"
            });*/

            this.submit();
        }
        })

    });

</script>

@endsection
