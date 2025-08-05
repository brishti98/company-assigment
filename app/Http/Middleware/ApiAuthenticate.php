<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-KEY') ?? $request->header('API-KEY');

        $validApiKey = config('services.api.key');

        if ($apiKey !== $validApiKey) {
            $apiResponse = new \App\Http\Helpers\ApiResponseHelper;
            $response = $apiResponse->unauthorized('Unauthorized. Invalid API key.');
            return response()->json($response, $response['statusCode']);
        }

        return $next($request);
    }
}
