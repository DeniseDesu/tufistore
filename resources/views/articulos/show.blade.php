@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-header text-center fw-bold">{{ $articulo->nombre }}</div>

                        <div class="card-body">

                            <img class="img-thumbnail img-fluid mx-auto d-block" style=" width: 250px; height: auto " src="{{ asset('/storage/' . $articulo->img) }}" alt=".."> 

                            <div class="table-responsive">

                                <table class="table text-center">
                    
                                    <thread>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Categoría</th>
                                        <th>Precio</th>
                                        <th>Stock</th>
                                    </tr>
                                    </thread>

                                    <tbody class="align-middle">

                                    <tr>
                                        <td> {{ $articulo->nombre }}</td>
                                        <td> {{ $articulo->categoria->nombre }} </td>
                                        <td> {{ $articulo->precio }}</td>
                                        <td> {{ $articulo->stock }} </td>
                                    </tr>

                                    </tbody>

                                </table>
                            
                            </div>

                            
                            <div class="text-center mt-4 d-flex justify-content-center">
                                <a href="{{ route('tiendas.index') }}" class="btn btn-primary me-2" data-toggle="tooltip" title="Volver a la tienda"> <i class="fa fa-backward" aria-hidden="true"></i> </a> <!--ESTE TIENE QUE VOLVER A LA PAGINA TIENDA.PHP-->
                                
                                <form action="{{ route('add') }}" method="POST" class="ms-2">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $articulo->id }}">
                                    <input type="hidden" name="qty" value="1"> <!-- Puedes ajustar la cantidad si es necesario -->
                                    <button type="submit" class="btn btn-success" data-toggle="tooltip" title="Agregar al carrito">
                                        <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </div>


                        </div>
                   
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/js/admin/submit_eliminar_recurso.js'])

@endsection