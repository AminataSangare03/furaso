<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Vérifie que l'utilisateur connecté possède l'un des rôles autorisés.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user || ! in_array($user->role, $roles, true)) {
            abort(403, "Accès réservé : vous n'avez pas l'autorisation nécessaire.");
        }

        return $next($request);
    }
}
