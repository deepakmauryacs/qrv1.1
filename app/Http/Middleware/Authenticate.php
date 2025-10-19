<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            if ($request->is('vendor') || $request->is('vendor/*')) {
                return route('vendor.login'); // Redirect vendors to the vendor login page
            }
            return route('login'); // Default login route for other users
        }
    }
}

