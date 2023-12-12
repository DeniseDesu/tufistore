<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    
    public function index(Request $request)
    {
        $search = $request->query('search');
    
        if ($search) {
            // Realiza la búsqueda si se proporcionó un término de búsqueda
            $users = User::where(function($query) use ($search) {
                            $query->where('name', 'LIKE', "%{$search}%")
                                  ->orWhere('email', 'LIKE', "%{$search}%");
                        })
                        ->orderBy('is_admin', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10); // Modificado para paginar
        } else {
            // Devuelve solo los usuarios visibles si no se realizó ninguna búsqueda
            $users = User::orderBy('is_admin', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10); // Modificado para paginar
        }
    
        return view('users.index', compact('users'));
    }

    public function create()
    {

    return view('users.create');
    }

    public function store(Request $request)
    {
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
    ], [
        'name.required' => 'El nombre es obligatorio',
        'email.required' => 'El email es obligatoria',
        'password.required' => 'La contraseña es obligatoria',

    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        // Puedes agregar más campos según sea necesario
    ]);

    return redirect()->route('users.index')->with('success', 'Usuario creado con éxito.');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ], [
            'name.required' => 'El nombre es obligatorio',
            'email.required' => 'El email es obligatorio',
        ]);
    
        $user = User::findOrFail($id);
    
        // Verificación para evitar desactivar un usuario administrador
        if ($user->is_admin && !$request->has('is_visible')) {
            return redirect()->back()->with('error', 'No puedes desactivar un usuario administrador.');
        }
    
        // Actualización del usuario
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->has('is_admin'),
            'is_visible' => $request->has('is_visible'),
        ]);
    
        return redirect()->route('users.index')->with('success', 'Usuario actualizado con éxito.');
    }


    public function destroy($id)
    {
    $user = User::findOrFail($id);

    // Verifica si el usuario es administrador y actualiza ambos campos.
    if ($user->is_admin) {
        $user->update(['is_admin' => false, 'is_visible' => false]);
        return redirect()->route('users.index')->with('success', 'Usuario administrador eliminado con éxito.');
    }

    // Si el usuario no es administrador, solo actualiza el campo 'is_visible'.
    $user->update(['is_visible' => false]);
    return redirect()->route('users.index')->with('success', 'Usuario eliminado con éxito.');
    }





}
