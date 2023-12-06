@extends('layouts.app')

@section('content')


            <!-- Carousel -->
            <div id="carousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carousel" data-bs-slide-to="0" class="active" aria-current="true"
                        aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="3000">
                        <img src="/img/front01.png" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item" data-bs-interval="3000">
                        <img src="/img/front02.png" class="d-block w-100" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <!-- Sobre TUFI Store -->
            <section class="sobre-tufistore seccion-oscura">
                <div class="container text-center">
                    <h2 class="seccion-titulo"> TUFI Store </h2>
                    <p class="seccion-texto">Tu tienda online de figuritas sueltas</p>
                </div>
            </section>

            <!-- Novedades -->
            <section class="novedades seccion-clara">
                <div class="container">
                    <h2 class="seccion-titulo text-center">NOVEDADES</h2>

                    <div class="row justify-content-center">
                        @foreach ($ultimosArticulos as $articulo)
                            <div class="col-12 col-md-4 mb-4">
                                <div class="card mx-auto" style="width: 18rem;">
                                    <img src="{{ asset('/storage/' . $articulo->img) }}" class="card-img-top" alt="{{ $articulo->nombre }}">

                                    <div class="card-body text-center">

                                        <h5 class="card-title">{{ $articulo->nombre }}</h5>
                                        <p class="card-text text-success font-weight-bold">$ {{$articulo->precio}}</p>
                                        <form action="{{ route('add') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $articulo->id }}">
                                            <button type="submit" class="btn btn-primary">Agregar al carrito</button>
                                        </form>

                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>
            </section>

        
            <footer id="contacto" class="contacto seccion-oscura text-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-6" >
                            <p class="seccion-titulo">¡Contactanos!</p>
                            <p>Podemos ayudarte a encontrar esas figurita que estás buscando.</p>
                        </div>
                    </div>

                    <!-- Mostrar errores de validación -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('consulta.store') }}" method="post">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="FormControlInput1" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="FormControlInput1" name="nombre" placeholder="Ingresa tu nombre">
                                </div>
                                <div class="mb-3">
                                    <label for="FormControlInput2" class="form-label">Dirección de Correo</label>
                                    <input type="email" class="form-control" id="FormControlInput2" name="email" placeholder="nombre@ejemplo.com">
                                </div>
                                <div class="mb-3">
                                    <label for="FormControlTextarea1" class="form-label">Consulta</label>
                                    <textarea class="form-control" id="FormControlTextarea1" name="consulta" rows="3"></textarea>
                                </div>
                                <button type="submit" class="form-cta" name="submit">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </footer>

@endsection