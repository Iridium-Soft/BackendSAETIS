<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JsonResponseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if($response instanceof \Illuminate\Http\JsonResponse){

            $current_data = $response->getData();

            $current_data->user_status = ['add some data here'];

            $response->setData($current_data);
        }
        return $response;

    }
}
