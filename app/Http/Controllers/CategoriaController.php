<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Models\Tienda;
use App\Models\Articulo;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categoria::where('is_visible', true)->get();
        return view('categorias.index', [ 'categorias' => $categorias ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $categorias = Categoria::orderBy('nombre')->get();
        return view('categorias.create', [ 'categorias' => $categorias ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([

            'nombre' => 'required|max:25|unique:categorias',
        ], [
            'nombre.required' => 'El nombre de la categoría es obligatorio',
        ]);



        Categoria::create([
            'nombre' => $request->nombre,
        ]);
        return redirect()
        ->route('categorias.index')
        ->with('success', 'La categoría se ha agregado correctamente' );
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        return view('categorias.show', [ 'categoria' => $categoria]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
  
        $categorias = Categoria::orderBy('nombre')->get();
        return view ('categorias.edit', [
            'categoria' => $categoria,
         ]);


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {

        $request->validate([

            'nombre' => 'required|max:25|unique:categorias',
        ], [
            'nombre.required' => 'El nombre de la categoría es obligatorio',
        ]);

        
        $categoria->update([
            'nombre' => $request ->nombre,
        ]);
        return redirect()
        ->route('categorias.index')
        ->with('success', 'La categoría se ha modificado correctamente' );
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Categoria $categoria) {
        if ($categoria->articulos()->count() > 0) {
            // Si la categoría tiene artículos asociados, redirige con un mensaje de error
            return redirect()->route('categorias.index')
            ->with('danger', 'No se puede borrar la categoría porque tiene artículos asociados');
        }

        // Si no hay artículos asociados, procede con la actualización
        $categoria->update(['is_visible' => false]);
        return redirect()->route('categorias.index')
        ->with('success', 'La categoría se ha eliminado correctamente');
    }






}
