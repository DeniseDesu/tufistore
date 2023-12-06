@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h2>Confirmación de Pedido</h2>
    <p>Tu pedido ha sido procesado exitosamente.</p>
    <p>Número de Orden: {{ $numeroOrden }}</p>
    <div class="text-center"> <a href="{{ route('tiendas.index') }}" class="btn btn-primary"> Seguir Comprando </a> </div>

</div>
@endsection