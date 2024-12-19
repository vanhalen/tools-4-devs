<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageSwitcher
{
    public function handle($request, Closure $next)
    {
        $locale = $request->get('lang', Session::get('lang', config('app.locale')));

        if (in_array($locale, ['en', 'es', 'pt-BR'])) {
            App::setLocale($locale);
            Session::put('lang', $locale);
        }

        return $next($request);
    }
}
