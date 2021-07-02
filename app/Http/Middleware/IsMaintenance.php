<?php

namespace App\Http\Middleware;

use App\Models\Config;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class IsMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $is_maintenance = Cache::remember('is_maintenance', 60 * 10, function () {
            $config = Config::where('key', 'is_maintenance')->first();
            return $config ? $config->value : '';
        });

        if (1 == $is_maintenance) {
            return redirect(route('maintenance'));
        }

        return $next($request);
    }
}
