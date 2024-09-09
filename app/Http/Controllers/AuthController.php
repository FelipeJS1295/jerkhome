<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;

class AuthController extends Controller
{
    // Mostrar el formulario de inicio de sesión
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Procesar el inicio de sesión
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }

    // Mostrar el formulario de registro
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Procesar el registro
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->intended('dashboard');
    }

    // Procesar el cierre de sesión
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    // Mostrar el formulario de actualización de perfil
    public function showProfileForm()
    {
        return view('auth.profile');
    }

    // Procesar la actualización del perfil
    public function updateProfile(ProfileUpdateRequest $request)
    {
        $user = Auth::user();

        if ($user instanceof \App\Models\User) {
            $user->update($request->validated());
            return back()->with('status', 'Perfil actualizado con éxito');
        }

        return back()->withErrors(['error' => 'No se pudo actualizar el perfil.']);
    }
}
