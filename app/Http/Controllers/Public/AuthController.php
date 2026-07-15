<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WebCliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function showLogin() {
        return Inertia::render('auth/Login');
    }

    public function showRegister() {
        return Inertia::render('auth/Register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            /** @var \App\Models\User $user */ 
            $user = Auth::user();


            if ($user->hasAnyRole(['administrador', 'gestor-tienda'])) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('home'));
        }

        throw ValidationException::withMessages([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'dni' => 'required|string|size:8|unique:web_clientes,dni',
            'telefono' => 'required|string|min:9',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->nombres . ' ' . $request->apellidos,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            WebCliente::create([
                'user_id' => $user->id,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'dni' => $request->dni,
                'telefono' => $request->telefono,
                'email' => $request->email,
                'activo' => true,
            ]);

            $user->assignRole('cliente');
            Auth::login($user);
        });

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}