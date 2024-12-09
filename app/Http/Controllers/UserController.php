<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Muestra el formulario de edición de los usuarios.
     */
    public function index()
    {
        // Verifica si el usuario es administrador
        if (Auth::user()->idRol !== 1) {
            return redirect()->route('home')->with('error', 'Acceso denegado');
        }

        // Obtener todos los usuarios
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Guarda un nuevo usuario.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'idRol' => 'required|in:2,3', // 2: Doctor, 3: Paciente
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->idRol = $request->idRol;

        if ($request->idRol == 2) {
            $user->license_number = $request->license_number; // Solo para doctores
        }

        if ($request->idRol == 3) {
            $user->medical_history = $request->medical_history; // Solo para pacientes
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado con éxito');
    }

    /**
     * Muestra el formulario para editar un usuario.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Actualiza un usuario existente.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'idRol' => 'required|in:2,3',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->idRol = $request->idRol;

        if ($request->idRol == 2) {
            $user->license_number = $request->license_number; // Solo para doctores
        }

        if ($request->idRol == 3) {
            $user->medical_history = $request->medical_history; // Solo para pacientes
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado con éxito');
    }

    /**
     * Elimina un usuario.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado con éxito');
    }
}
