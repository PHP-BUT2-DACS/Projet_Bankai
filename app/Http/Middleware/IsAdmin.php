<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            // Si pas connecté -> on redirige vers login
            return redirect()->route('login');
        }

        if (Auth::user()->role !== 'admin') {
            // Si connecté mais pas admin -> erreur 403
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}
