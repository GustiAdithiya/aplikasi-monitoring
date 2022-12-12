<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $userType)
    {
        if (auth()->user()->role == $userType) {
            return $next($request);
        }

        // return response()->json(['You do not have permission to access for this page.']);
        $this->data['type'] = "404";
        $this->data['message'] = "The page you are looking for doesn't exist.";
        return response()->view('layouts.error', $this->data);
    }
}
