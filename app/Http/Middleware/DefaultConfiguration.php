<?php

namespace App\Http\Middleware;

use App\Models\Config;
use Closure;
use Illuminate\Support\Facades\Cache;

class DefaultConfiguration
{
    public function handle($request, Closure $next)
    {
        Cache::rememberForever('app.name', function () {
            $config = Config::where('key', 'app.name')->first();
            return $config ? $config->value : '';
        });

        return $next($request);
    }
}
