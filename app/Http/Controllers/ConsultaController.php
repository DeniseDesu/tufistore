<?php

namespace App\Http\Controllers;
use App\Models\Consulta;

use Illuminate\Http\Request;

class ConsultaController extends Controller
{
   
    public function index(Request $request)
    {
        $search = $request->query('search');
    
        if ($search) {
            // Realiza la búsqueda si se proporcionó un término de búsqueda
            $consultas = Consulta::where('is_visible', true)
                        ->where(function($query) use ($search) {
                            $query->where('nombre', 'LIKE', "%{$search}%")
                                  ->orWhere('consulta', 'LIKE', "%{$search}%");
                        })
                        ->orderBy('created_at', 'desc')
                        ->paginate(6);
        } else {
            // Devuelve solo las consultas visibles si no se realizó ninguna búsqueda
            $consultas = Consulta::where('is_visible', true)
                        ->orderBy('created_at', 'desc')
                        ->paginate(6);
        }
    
        return view('consultas.index', compact('consultas'));
    }


    public function store(Request $request)
    {
    $request->validate([
        'nombre' => 'required|max:25',
        'email' => 'required|email',
        'consulta' => 'required|max:1000',
    ], [
        'nombre.required' => 'El nombre es obligatorio',
        'email.required' => 'El email es obligatorio',
        'consulta.required' => 'Enviar un mensaje es obligatorio',
    ]);

    Consulta::create($request->all());

    return back()->with('success', 'Tu consulta ha sido enviada.');
    }


    public function destroy($id)
    {
        $consulta = Consulta::findOrFail($id);
        $consulta->update(['is_visible' => false]);
        return back()->with('success', 'Consulta eliminada correctamente.');
    }



}
