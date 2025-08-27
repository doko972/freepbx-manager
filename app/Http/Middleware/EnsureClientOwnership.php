<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class EnsureClientOwnership
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->isAdmin()) {
            return $next($request);
        }

        $clientId = $request->route('clientId') ?? $request->route('id');
        
        if ($clientId) {
            $client = Auth::user()->clients()->find($clientId);
            if (!$client) {
                abort(403, 'Accès non autorisé à ce client');
            }
        }

        return $next($request);
    }
}