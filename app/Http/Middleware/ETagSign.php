<?php

namespace App\Http\Middleware;

use Closure;

class ETagSign
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($request->isMethod('GET') || $request->isMethod('HEAD')) {

            $requestETags = $request->getETags();

            $responseETag = md5($response->getContent());
            $response->setETag($responseETag);

            foreach ($requestETags as $requestETag) {
                if ($requestETag === $responseETag) {
                    $response->setNotModified();
                    break;
                }
            }
        }

        return $response;
    }
}
