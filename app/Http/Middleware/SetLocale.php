<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

use function PHPUnit\Framework\isNull;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $languages = config('app.languages');
        if (session()->has('locale')) {
            $locale = session('locale');
            if (array_key_exists($locale, $languages)) {
                App::setLocale($locale);
            } else {
                session()->forget('locale');
            }
        }

        return $next($request);
    }
}
