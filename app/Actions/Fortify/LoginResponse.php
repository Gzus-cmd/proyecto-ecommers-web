<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract {
    public function toResponse($request) {
        $user = $request->user();
        
        if ($user->hasRole(['administrador', 'gestor-tienda'])) {
            return redirect()->intended('/admin/productos');
        }

        return redirect()->route('home');
    }
}