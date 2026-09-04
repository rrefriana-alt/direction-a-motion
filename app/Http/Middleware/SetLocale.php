<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->route('locale');
        if (!in_array($locale, ['en', 'id'])) {
            $locale = 'en';
        }
        App::setLocale($locale);
        URL::defaults(['locale' => $locale]);
        view()->share('locale', $locale);
        view()->share('otherLocale', $locale === 'en' ? 'id' : 'en');

        return $next($request);
    }
}
