@extends('layouts.app')

@section('content')
<div class="container">

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('info'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('info') }}
                    </div>
    @endif


    <div class="row">
        <div class="col-md-6">

            <h2 class="text-center">Proceso de Pago</h2>

            <!-- Formulario de Datos de Pago -->
            <form action="{{ route('processPayment') }}" method="post" class="text-center">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre">
                </div>
                <div class="form-group">
                    <label for="apellido">Apellido:</label>
                    <input type="text" class="form-control" id="apellido" name="apellido">
                </div>
                <div class="form-group">
                    <label for="dni">DNI:</label>
                    <input type="text" class="form-control" id="dni" name="dni">
                </div>
                <div class="form-group">
                    <label for="dni">Dirección:</label>
                    <input type="text" class="form-control" id="direccion" name="direccion">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="form-group">
                    <label for="tarjeta">Número de Tarjeta:</label>
                    <input type="text" class="form-control" id="tarjeta" name="tarjeta">
                </div>
                <div class="form-group">
                    <label for="codigo">Código de la Tarjeta:</label>
                    <input type="text" class="form-control" id="codigo" name="codigo">
                </div>
                <div class="form-group">
                    <label for="expiracion">Fecha de Expiración (MM/YY):</label>
                    <input type="text" class="form-control text-center" id="expiracion" name="expiracion" placeholder="MM/YY">
                </div>
                <br>
                <a href="{{ route('checkout') }}" class="btn btn-primary"> Volver al Carrito </a>
                <button type="submit" class="btn btn-success">Pagar</button>
            </form>
         
        </div>
    

         <!-- Lista de Productos en el Carrito -->

        <div class="col-md-6">
                <h3 class="text-center">Productos en el Carrito</h3>
                <table class="table align-middle text-center">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach (Cart::content() as $item)
                        <tr>
                            <td><img src="{{ asset('/storage/' . $item->options->img) }}" alt="Imagen del producto" width="100"></td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>$ {{ $item->price }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <p class="text-end"><strong>Total a pagar: $ {{ Cart::total() }}</strong></p>

        </div>
    </div>
</div>
@endsection
