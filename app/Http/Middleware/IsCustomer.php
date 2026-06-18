<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class IsCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): SymfonyResponse
    {
        // Check jika user sudah login dan role = customer
        if (!auth()->check() || auth()->user()->role !== 'customer') {
            return redirect('/')->with('error', 'Unauthorized access. Customer only.');
        }

        return $next($request);
    }
}
