<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Routing\Exceptions\InvalidSignatureException;

class ValidateHttpsSignature
{
    public $keyResolver;

    public function __construct()
    {
        $this->keyResolver = function () {
            return App::make('config')->get('app.key');
        };
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->hasValidSignature($request)) {
            return $next($request);
        }

        throw new InvalidSignatureException;
    }

    public function hasValidSignature(Request $request, $absolute = true)
    {
        $url = $absolute ? $request->url() : '/' . $request->path();

        // fixing reverse proxy https signature issue
        $url = str_replace('http://', 'https://', $url);

        $original = rtrim($url . '?' . Arr::query(
            Arr::except($request->query(), 'signature')
        ), '?');

        $expires = $request->query('expires');

        $signature = hash_hmac('sha256', $original, call_user_func($this->keyResolver));

        return hash_equals($signature, (string) $request->query('signature', '')) && ! ($expires && Carbon::now()->getTimestamp() > $expires);
    }
}
