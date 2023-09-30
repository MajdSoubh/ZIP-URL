<?php

namespace Core\Http;



abstract class Middleware
{


    public function __invoke($request, $next)
    {
        $this->handle($request, $next);
    }

    /**
     * Handle the incoming request.
     *
     * @param   Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public abstract function handle($request, $next);
}
