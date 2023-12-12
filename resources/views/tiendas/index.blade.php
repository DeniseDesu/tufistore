@extends('layouts.app')

@section('content')

<div class="container">
    <!-- Card de Categorías -->
    <div class="row mb-4">

        <div class="col-md-3">
            <div class="card">

                <div class="card-header text-center fw-bold">{{ __('Categorías') }}</div>
                
                <div class="card-body">
                    <ul class="list-group text-center">
                        @forelse ($categorias as $cat)
                            <li class="list-group-item">
                                <a href="{{ route('tiendas.index', ['categoria' => $cat->nombre]) }}">{{ $cat->nombre }} ({{ $cat->articulos_count }})</a>
                            </li>
                        @empty
                            <li class="list-group-item">No hay categorías creadas</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Card Principal con Artículos -->
        <div class="col-md-9">
            <div class="card">

                <div class="card-header text-center fw-bold">{{ __('Artículos') }}</div>

                <div class="card-body">
                    <div class="row justify-content-center">
                        @foreach ($articulos as $item)
                            <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
                                <div class="card mx-auto shadow-sm" style="width: 15rem">
                                    <img class="img-fluid" src="{{ asset('/storage/' . $item->img) }}" alt="" style="height: 200px; object-fit: contain;">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">{{$item->nombre}}</h5>
                                        <p class="card-text text-success font-weight-bold">$ {{$item->precio}}</p>
                                    </div>
                                    <div class="card-footer bg-white d-flex justify-content-center">
                                        <!--<a href="{{ route('articulos.show', $item) }}" class="btn btn-primary me-1">Ver</a> Boton de ver una card individual del articulo -->
                                        <form action="{{ route('add') }}" method="POST" class="ms-0">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item->id }}" />
                                            <button class="btn btn-success ml-2" type="submit"><i class="fa fa-cart-plus"></i> Agregar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 d-flex justify-content-center">
                        {{$articulos->links()}}
                    </div>
                    
                </div>
            </div>
        </div>


    </div>
</div>

@endsection
