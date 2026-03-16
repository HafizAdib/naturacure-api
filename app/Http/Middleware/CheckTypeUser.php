<?php

// app/Http/Middleware/CheckTypeUser.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckTypeUser
{
    public function handle(Request $request, Closure $next, $type)
    {
        $user = $request->user();

        if (!$user || $user->type_user !== $type) {
            return response()->json(['message' => 'Accès interdit'], 403);
        }

        return $next($request);
    }
}