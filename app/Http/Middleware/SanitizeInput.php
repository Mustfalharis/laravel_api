<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SanitizeInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $input= $request->all();
        $sanitizedInput = $this->sanitizeArray($input);
        $request->replace($sanitizedInput);
        return $next($request);
    }
    protected function sanitizeArray($array)
    {
        array_walk_recursive($array, function (&$value, $key) {
            $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        });
        return $array;
    }
}
