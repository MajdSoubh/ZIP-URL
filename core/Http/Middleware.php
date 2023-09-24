<?php

namespace Core\Http;



abstract class Middleware
{

    /**
     * Handle the incoming request.
     *
     * @param   Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public abstract function handle($request, $next);
}
