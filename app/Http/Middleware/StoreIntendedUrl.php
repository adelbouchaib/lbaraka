<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class StoreIntendedUrl
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() 
            && !$request->is('login') 
            && !$request->is('livewire/*') 
            && !$request->is('api/*') // Ignore API requests
        ) {
            Session::put('url.intended', $request->fullUrl());
        }

        return $next($request);
    }
}