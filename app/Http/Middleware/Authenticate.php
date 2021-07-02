<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Str;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return null|string
     */
    protected function redirectTo($request)
    {
        $admin = Str::contains($request->url(), config('app.admin_url'));
        if (!$request->expectsJson()) {
            if ($admin) {
                return route('admin.login');
            }

            return route('front.login');
        }
    }
}
