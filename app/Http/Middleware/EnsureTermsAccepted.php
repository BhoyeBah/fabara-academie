<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/** Si les CGU / la politique de confidentialité ont changé, le client doit les accepter à nouveau. */
class EnsureTermsAccepted
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($user && ! $user->isAdmin() && $user->terms_version !== config('legal.version')) {
            return redirect()->route('terms.accept');
        }

        return $next($request);
    }
}
