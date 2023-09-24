<?php


namespace App\Middlewares;

use Core\Http\Middleware;


class AuthMiddleware extends Middleware
{

    protected $guard;

    public function __construct($guard = null)
    {
        $this->guard = $guard;
    }

    public function handle($request, $next)
    {


        if ($this->guard == 'guest')
        {
            if (auth()->check())
            {
                return redirect('/');
            }
        }
        else
        {
            if (!auth()->check())
            {
                return redirect('/login');
            }
        }
        return $next($request);
    }
}
