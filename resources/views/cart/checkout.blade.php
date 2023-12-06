@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('info'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('info') }}
                    </div>
                @endif


                <div class="card">
                    <div class="card-body">
                        @if(Cart::count())

                            <div class="table-responsive"> <!-- Envuelve la tabla con .table-responsive -->

                                <table class="table table.striped text-center">
                                
                                    <thread>

                                        <th class="d-none d-md-table-cell">IMG</th>
                                        <th>NOMBRE</th>
                                        <th class="d-none d-md-table-cell">STOCK</th>
                                        <th>PRECIO</th>
                                        <th>CANTIDAD A COMPRAR</th>
                                        <th>IMPORTE</th>
                                    </thread>
                                    <tbody>
                                    
                                        @foreach (Cart::content() as $item)
                                            <tr class="align-middle">

                                                <td><img class="img-fluid" src="{{ asset('/storage/' . $item->options->img) }}" width="100"></td>
                                                <td>{{ $item->model->nombre}}</td>
                                                <td>{{ $item->model->stock }}</td>
                                                <td>{{ $item->model->precio }}</td>
                                                <td>
                                                    <form action="{{ route('updateitem') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="rowId" value="{{ $item->rowId }}" />
                                                        <input type="number" name="qty" value="{{ $item->qty }}" min="1" />
                                                        <button type="submit" class="btn btn-info btn-sm">Actualizar</button>
                                                    </form>
                                                </td>
                                                <td>{{ $item->qty * $item->model->precio }}</td>
                                                <td>
                                                    <form action="{{route('removeitem')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="rowId" value="{{ $item->rowId }}" />
                                                        
                                                        <button type="submit" class="btn btn-danger btn_eliminar_recurso" data-toggle="tooltip" title="Eliminar"> <i class="fa fa-trash-o fa-fw"></i> </button>                

                                                    </form>
                                                </td>

                                            </tr>
                                        @endforeach
                                            <tr class="fw-bolder">

                                                <td colspan="4"></td>
                                                <td class="text-end">Subtotal</td>
                                                <td class="text-end">{{Cart::subtotal()}}</td>
                                                <td></td>

                                            </tr>
                                            <tr class="fw-bolder">

                                                <td colspan="4"></td>
                                                <td class="text-end">IVA 15%</td>
                                                <td class="text-end">{{Cart::tax()}}</td>
                                                <td></td>

                                            </tr>
                                            <tr class="fw-bolder">

                                                <td colspan="4"></td>
                                                <td class="text-end">Total</td>
                                                <td class="text-end">{{Cart::total()}}</td>
                                                <td></td>

                                            </tr>


                                    </tbody>
                                                    
                                </table>

                            </div>

                            <div class="text-center mt-4">
                                <a href="{{ route('clear') }}" class="btn btn-primary"> Vaciar Carrito </a>
                                <a href="{{ route('payment') }}" class="btn btn-success"> Procesar Pago </a>
                            </div>


                        @else
                            <div class="text-center"> <a href="{{ route('tiendas.index') }}" class="btn btn-primary"> Agregar un producto </a> </div>
                        @endif
                    </div>
                </div>
    </div>
</div>    



@endsection
