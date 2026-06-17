<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next) //la petición que hace el usuario (por ejemplo entrar a /admin)
    {
        if(auth()->check() && auth()->user()->rol_id == 1){ //Hace dos preguntas, si esta logueado y si es admi
            return $next($request); //si se cumple lo deja pasar
        }

        return redirect('/')->with('error', 'No tienes permisos'); //si no se cumplen las condiciones lo manda al inicio (/) con mensaje de error.
    }
}