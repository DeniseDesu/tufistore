<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\Http\Request;
use App\Models\Categoria; //IMPORTAMOS EL MODELO CATEGORIA
use Cart;


class ArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articulos = Articulo::where('is_visible', true) //DESDE EL MODELO SE LLAMA A UN METODO (WHERE) Y SE LLAMO A MAS METODOS ENCADENADOS (ORDERBY Y GET) PARA QUE MUESTRE LOS ARTICULOS VISIBLES Y ACTIVOS
        ->orderBy('nombre')
        ->paginate(4);  //SE AGREGO UN PAGINADOR EN EL METODO INDEX DE ARTICULOS QUE MUESTRE 4 REGISTROS (PARA EL TP2) Y SE AMPLIARAN PARA LA ENTREGA DEL FINAL. TAMBIEN SE AGREGO EL PARAMETRO EN EL VIEW DE ARTICULO 
        return view('articulos.index', [ 'articulos' => $articulos ]);
    }

    /**
     * ESTO NOS LLEVA A UN FORMULARIO (OTRA VIEW) CUANDO QUEREMOS AGREGAR UN NUEVO ARTICULO A NUESTRA DB POR CATEGORIA
     */
    public function create()
    {
        $categorias = Categoria::orderBy('nombre')->get();
        return view('articulos.create', [ 'categorias' => $categorias ]);
    }

    /**
     * Store a newly created resource in storage. ESTO CREA EL REGISTRO DONDE NOS TRAE LA INFO INGRESADA y CREAMOS EL RETURN PARA MOSTRARLOS EN EL INDEX DE ARTICULOS
     */
    public function store(Request $request)
    {

        $request->validate([ //SE ESTABLECEN VALIDACIONES PARA LA CREACION DE NUEVOS ARTICULOS TANTO EN EL METODO DE STORE COMO EN LA VIEW DE CREATE PARA QUE TRAIGA LOS VALORES INGRESADOS SI ALGUNA VALIDACION FALLO

            'nombre' => 'required|max:25',
            'stock' => 'required|numeric|max:9999',
            'precio' => 'required|numeric|max:9999',
            'categoria_id' => 'required',
            'img' => 'required|mimes:jpg,png',

        ], [
            'nombre.required' => 'El nombre del artículo es obligatorio',
            'stock.required' => 'La cantidad de stock es obligatoria',
            'precio.required' => 'El precio es obligatorio',
            'categoria_id.required' => 'La categoría es obligatoria',
            'img.required' => 'Adjuntar una imagen del tipo JPG o PNG es obligatorio' 
        ]);

        $imagen_nombre = time() . $request->file('img')->getClientOriginalName(); //SE ESTABLECE UNA VARIABLE PARA GUARDAR LAS IMAGENES QUE SE SUBAN

        $img = $request->file('img')->storeAs('articulos', $imagen_nombre, 'public' );


        Articulo::create([
            'nombre' => $request ->nombre,
            'stock' => $request ->stock,
            'precio' => $request ->precio,
            'categoria_id' => $request ->categoria_id,
            'img' => $img,
        ]);
        return redirect()
        ->route('articulos.index')
        ->with('success', 'El artículo se ha agregado correctamente' );
    }

    /**
     * Display the specified resource. ESTO PERMITE VER CADA ARTICULO
     */
    public function show(Articulo $articulo)
    {
        return view('articulos.show', [ 'articulo' => $articulo]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Articulo $articulo)
    {
        $categorias = Categoria::orderBy('nombre')->get();
        return view ('articulos.edit', [
            'categorias' => $categorias,
            'articulo' => $articulo
         ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Articulo $articulo)
    {

        $request->validate([ 

            'nombre' => 'required|max:25',
            'stock' => 'required|numeric|max:9999',
            'precio' => 'required|numeric|max:9999',
            'categoria_id' => 'required',
            'img' => 'required|mimes:jpg,png',

        ], [
            'nombre.required' => 'El nombre del artículo es obligatorio',
            'stock.required' => 'La cantidad de stock es obligatoria',
            'precio.required' => 'El precio es obligatorio',
            'categoria_id.required' => 'La categoría es obligatoria',
            'img.required' => 'Adjuntar una imagen del tipo JPG o PNG es obligatorio' 
        ]);


        $imagen_nombre = time() . $request->file('img')->getClientOriginalName();
        $img = $request->file('img')->storeAs('articulos', $imagen_nombre, 'public');
        

        $articulo->fill($request->only([   //MENSAJE DE ALERTA SI NO HACEN MODIFICACIONES PARTE1
            'nombre', 'stock', 'precio', 'categoria_id', 'img'
        ]));

        if($articulo->isClean()){   //MENSAJE DE ALERTA SI NO HACEN MODIFICACIONES PARTE2
        return back()->with('warning','Debe realizar cambios para actualizar');}


        $articulo->update([
            'nombre' => $request ->nombre,
            'stock' => $request ->stock,
            'precio' => $request ->precio,
            'categoria_id' => $request ->categoria_id,
            'img' => $img,
        ]);
        return redirect()
        ->route('articulos.index')
        ->with('success', 'El artículo se ha modificado correctamente' ); //SE ESTABLECE PARA LOS METODOS UPDATE, DELETE Y STORE CON EL METODO WITH UNA ACCION QUE NOTIFIQUE UNA MODIFICACION EN LA DB. ESTO SE VISUALIZA EN EL INDEX A TRAVES DE UNA VARIABLE.
    }

    /**
     * Remove the specified resource from storage. HACEMOS QUE EL OBJETO ARTICULO RECIBA EL METODO UPDATE ESTE A SU VEZ EL PARAMETRO is_visible = false PARA QUE SE ACTUALICE EL INDEX DE ARTICULOS Y NO SE BORRE EN LA DB.
     */
    public function destroy(Articulo $articulo)
    {
        $articulo->update([
            'is_visible' => false
        ]);
        return redirect()
        ->route('articulos.index')
        ->with('danger', 'El artículo se ha eliminado correctamente' );
    }


    // Funcion para ver los ultimos articulos creados en las Cards de novedades del welcome.blade.php

    public function ultimosArticulos()
    {
        $ultimosArticulos = Articulo::where('is_visible', true)
                        ->where('stock', '>', 0) // Añadir esta condición para filtrar solo artículos con stock
                        ->orderBy('created_at', 'desc')
                        ->take(3) // número de artículos que quieres mostrar
                        ->get();

        return view('welcome', ['ultimosArticulos' => $ultimosArticulos]);
    }






}
