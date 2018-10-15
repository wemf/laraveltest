<?php

namespace App\Http\Middleware;
use dateFormate;
use Closure;

class RequestTrim
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $input = $request->all();
        if (!empty($input)) {
            array_walk_recursive($input, function (&$item) {
                $item = strip_tags(trim($item));
                $item = ($item == "") ? null : $item;
                $item=dateFormate::ToFormat($item);
            });
            $request->merge($input);
        }
        return $next($request);
    }
}
