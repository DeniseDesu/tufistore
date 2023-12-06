    <!--

                @foreach ($articulos as $art)         

                <div class="col-4 text-center">
                    



                    <div class="card">

                        <img class="img-fluid" src="{{ asset('/storage/' . $art->img) }}" alt="">
                        <div class="card-footer">
                            <a href="{{ route('articulos.show', $art) }}" class="btn btn-primary">Ver</a>
                            <a href="" class="btn btn-primary">Carrito</a>
                        </div>
                    </div>


                    
                </div>

                
            @endforeach

       -->


       <!--

<div class="container" style="background-color: red">

<div class="row d-flex justify-content-end">


    @if ($articulos->count() > 0)
    
    @foreach ($articulos as $art)         

        <div class="col-3 text-center">
            



            <div class="card" style="width: 15rem">

                <img class="img-fluid" src="{{ asset('/storage/' . $art->img) }}" alt="">
                <div class="card-footer">
                    <a href="{{ route('articulos.show', $art) }}" class="btn btn-primary">Ver</a>
                    <a href="" class="btn btn-primary">Carrito</a>
                </div>
            </div>


            
        </div>

        
    @endforeach

    @else
                  <tr>

                     <td colspan="15" class="center"> No hay artículos creados </td>

                  </tr>
    @endif


    
    <div class="col-12">
    {{$articulos->links()}}
    </div>




</div>



</div>

<div class="container" style="background-color: black">
    <div class="row">
    <div class="col-sm-2">
        <div class="card">
            <div class="card-header text-center fw-bold">{{ __('Categorías') }}</div>

                <div class="card-body">


                <table class="table text-center">
                    <thread>
                        <tr>
                            <th>Nombre</th>
                        </tr>
                    </thread>

                <tbody class="align-middle">

                @if ($categorias->count() > 0)

                    @foreach ($categorias as $cat)
                    <tr>
                        <td> {{ $cat-> nombre }}</td>
                    </tr>
                    @endforeach

                @else
                  <tr>
                     <td colspan="5" class="text-center"> No hay categorías creadas </td>
                  </tr>
                @endif

                </tbody>

                </table>




                </div>
            </div>
        </div>
    </div>
   </div>
</div>

-->


<!--
    
@if (Auth::user()->is_admin)
@endif
-->