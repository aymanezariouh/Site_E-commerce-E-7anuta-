<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureSellerIsActive
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->isSeller() && $user->isSuspended()) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Votre compte vendeur est suspendu.');
        }

        return $next($request);
    }
}
