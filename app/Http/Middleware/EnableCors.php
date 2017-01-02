<?php

namespace App\Http\Middleware;

use Closure;

class EnableCors
{
    public function handle($request, Closure $next)
    {
        if ($request->isMethod('OPTIONS')) {
            $response = response('', 200);
        } else {
            $response = $next($request);
        }
        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('Access-Control-Allow-Methods',
            'GET, DELETE, PATCH, POST, PUT');
        $response->header('Access-Control-Allow-Headers',
            'Authorization, Content-Type, Origin');
        return $response;
    }
}
