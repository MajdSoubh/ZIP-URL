<?php


namespace App\Middlewares;

use Core\Http\Middleware;
use Core\Support\Hash;
use Core\View\View;

class CSRFMiddleware extends Middleware
{


    /**
     * Check if user request is authenticated.
     */
    public function handle($request, $next)
    {
        if (request()->method() != 'get')
        {
            if (!request()->has('_token') || request()->get('_token') !== session('_token'))
            {
                return View::makeError('PageExpired');
            }
        }

        // Delete token from request data.
        request()->remove('_token');

        // Regenerate CSRF Token.
        session()->set('_token', Hash::random());

        return $next($request);
    }
}
