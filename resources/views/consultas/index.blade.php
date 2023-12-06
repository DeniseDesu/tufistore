@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Consultas Recibidas</h2>
    <form action="{{ route('consultas.index') }}" method="GET" class="form-inline mb-4">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Buscar consultas..." value="{{ request()->query('search') }}">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
            </div>
        </div>
    </form>
    <div class="row">
        @foreach ($consultas as $consulta)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-header">{{ $consulta->created_at->format('d M Y') }}</div>
                    <div class="card-body">
                        <h5 class="card-title"><i class="fa fa-user"></i> {{ $consulta->nombre }}</h5>
                        <p class="card-text">{{ Str::limit($consulta->consulta, 1000) }}</p> <!-- Con esto podemos limitar la cantidad de letras que se muestran -->
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-success btn-sm me-1"><i class="fa fa-reply"></i> Responder</button>
                            <form action="{{ route('consultas.destroy', $consulta->id) }}" method="POST" class="js-eliminar">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center mt-4">
        {{ $consultas->links() }}
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
        text: "Esta consulta se eliminará definitivamente",
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