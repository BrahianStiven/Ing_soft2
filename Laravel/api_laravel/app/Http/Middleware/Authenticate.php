<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{

    /** En una app API Gateway, cuando no hay autenticación válida, 
     * el comportamiento correcto es 401 JSON, no una redirección a una pantalla de login. */
    protected function redirectTo(Request $request): ?string
    {
        // Para un API Gateway no queremos redirecciones HTML.
        // Si la request NO está autenticada, debe responder 401 en vez de buscar route('login').
        if ($request->is('api/*')) {
            return null;
        }

        return $request->expectsJson() ? null : route('login');
    }
}
