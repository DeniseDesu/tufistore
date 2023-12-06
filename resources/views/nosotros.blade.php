@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <div class="jumbotron text-center">
        <h2>Sobre TUFI Store</h2>
        <p>Breve introducción acerca de la empresa...</p>
    </div>

    <div class="row text-center">
        <div class="col-md-4">
            <div class="card h-100">
                <img src="ruta/a/imagen/mision.jpg" class="card-img-top" alt="">
                <div class="card-body">
                    <h3 class="card-title">Misión</h3>
                    <p>Descripción breve de la misión de la empresa.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <img src="ruta/a/imagen/vision.jpg" class="card-img-top" alt="">
                <div class="card-body">
                    <h3 class="card-title">Visión</h3>
                    <p>Descripción breve de la visión de la empresa.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <img src="ruta/a/imagen/valores.jpg" class="card-img-top" alt="">
                <div class="card-body">
                    <h3 class="card-title">Valores</h3>
                    <p>Descripción breve de los valores de la empresa.</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection