<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App;

class SetLocale
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
        $locale = config('app.locale');
        if ($request->segment(1)) {
            if (in_array($request->segment(1), config('app.locales'))) {
                $locale = $request->segment(1);
                app()->setLocale($locale);
            }
        }
        URL::defaults(['locale' => $locale]);
        $request->route()->forgetParameter('locale');
        return $next($request);
    }
}
