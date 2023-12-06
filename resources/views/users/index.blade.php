@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Gestión de Usuarios</h2>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4 d-flex justify-content-between">
        <form action="{{ route('users.index') }}" method="GET" class="form-inline">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Buscar usuarios...">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-outline-secondary">Buscar</button>
                </div>
            </div>
        </form>
        <a href="{{ route('users.create') }}" class="btn btn-success">Agregar Usuario</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Administrador/Cliente</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="text-center">{{ $user->name }}</td>
                        <td class="text-center">{{ $user->email }}</td>
                        <td class="text-center">
                            @if ($user->is_admin)
                                <span class="badge bg-warning">Admin</span> <!-- Luz amarilla para administrador -->
                            @else
                                <span class="badge bg-secondary">Cliente</span> <!-- Color diferente para no administrador -->
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($user->is_visible)
                                <span class="badge bg-success">Activo</span> <!-- Luz verde para activo -->
                            @else
                                <span class="badge bg-danger">Inactivo</span> <!-- Luz roja para inactivo -->
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-pencil"></i> Editar
                            </a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline-block;" class="js-eliminar">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fa fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $users->links() }}
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
        text: "Este usuario se eliminará definitivamente",
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
