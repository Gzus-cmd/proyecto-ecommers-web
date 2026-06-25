<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Inertia\Inertia;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth; 

class UserController extends Controller
{
    /**
     * Listado de Operadores con búsqueda y roles
     */
    public function index(Request $request)
    {
        $users = User::with('roles')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
            'filters' => $request->only(['search'])
        ]);
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        return Inertia::render('Admin/Users/Create', [
            'roles' => Role::all() 
        ]);
    }

    /**
     * Guardar nuevo operador
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',

            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|exists:roles,name', 
        ]);

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $user->assignRole($validated['role']);
        });

        return redirect()->route('admin.users.index')
            ->with('success', 'Operador creado correctamente.');
    }

    /**
     * Formulario de edición
     */
    public function edit(User $user)
    {
        return Inertia::render('Admin/Users/Edit', [
            'user' => $user->load('roles'),
            'roles' => Role::all()
        ]);
    }

    /**
     * Actualizar datos y/o contraseña del operador
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|exists:roles,name',

            'password' => ['nullable', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);


        $user->update([
            'name'  => $validated['name'],
            'email' => $validated['email'],
        ]);


        if ($request->filled('password')) {
            $user->update([
                'password' => \Illuminate\Support\Facades\Hash::make($validated['password'])
            ]);
        }

        $user->syncRoles([$validated['role']]);

        return redirect()->route('admin.users.index')->with('success', 'Operador actualizado.');
    }

    /**
     * Eliminar operador con protección de seguridad
     */
public function destroy(User $user)
{

    if ($user->id === Auth::id()) {
        return redirect()->back()->withErrors([
            'error' => 'No puedes eliminar tu propia cuenta administrativa.'
        ]);
    }

    $user->delete();

    return redirect()->route('admin.users.index')
        ->with('success', 'El operador ha sido dado de baja del sistema.');
}
}