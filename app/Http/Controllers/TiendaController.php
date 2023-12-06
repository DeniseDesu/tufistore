<?php

namespace App\Http\Controllers;

use App\Models\Tienda;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Articulo;


class TiendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request){

    $categoriaSeleccionada = $request->get('categoria'); // Obtén el nombre de la categoría de la URL

    if ($categoriaSeleccionada) {
        $articulos = Articulo::where('is_visible', true)
            ->where('stock', '>', 0)
            ->whereHas('categoria', function ($query) use ($categoriaSeleccionada) {
                $query->where('nombre', $categoriaSeleccionada);
            })
            ->paginate(6);
    } else {
        $articulos = Articulo::where('is_visible', true)
        ->where('stock', '>', 0)
        ->paginate(6);
    }

    // Modificar aquí para incluir el conteo excluyendo aquellos articulos cuyo stock sean menores a 0
    $categorias = Categoria::where('is_visible', true)
            ->withCount(['articulos' => function($query) {
                $query->where('is_visible', true)
                ->where('stock', '>', 0);
            }])->get();

    return view('tiendas.index', compact('articulos', 'categorias'));

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(tienda $tienda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(tienda $tienda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, tienda $tienda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(tienda $tienda)
    {
        //
    }



}
