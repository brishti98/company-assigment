<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class XssSanitize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();

        $dangerousPattern = '/<(script|iframe|object|embed|applet|meta|style|link|base|form)[^>]*>/i';
        $invalidFields = [];

        array_walk_recursive($input, function ($value, $key) use (&$invalidFields, $dangerousPattern) {
            if (preg_match($dangerousPattern, $value)) {
                $invalidFields[] = $key;
            }
        });

        if (!empty($invalidFields)) {
            $apiResponse = new \App\Http\Helpers\ApiResponseHelper;
            $response = $apiResponse->badRequest('Invalid input detected.');
            return response()->json($response, $response['statusCode']);
        }

        array_walk_recursive($input, function (&$input) {
            $input = strip_tags($input);
        });

        $request->merge($input);

        return $next($request);
    }
}
