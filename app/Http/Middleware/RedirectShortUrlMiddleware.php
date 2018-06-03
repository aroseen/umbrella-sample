<?php

namespace App\Http\Middleware;

use App\Models\Url;
use Closure;

class RedirectShortUrlMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var Url $url */
        $url = $request->route()->parameter('shortUrl');

        return redirect()->to($url->origin_url);
    }
}
