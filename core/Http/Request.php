<?php

namespace Core\Http;

use Core\Support\Arr;
use Core\Support\Auth;

class Request
{

    protected  $routeParams = [];

    public  function method()
    {
        return  strtolower($_SERVER['REQUEST_METHOD']);
    }

    public  function path()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';


        return str_contains($path, '?') ? explode('?', $path)[0] : $path;
    }

    /**
     * Return authenticated user
     * @return object|null
     */
    public function user()
    {

        return Auth::user();
    }


    public function all()
    {
        return $_REQUEST;
    }

    public function only(...$keys)
    {
        return Arr::only($this->all(), $keys);
    }
    public function except(...$keys)
    {
        return Arr::except($this->all(), $keys);
    }

    public function get($key)
    {
        return Arr::get($this->all(), $key);
    }
    public function has($key)
    {
        return Arr::has($this->all(), $key);
    }

    public function setRouteParams($params)
    {
        $this->routeParams = $params;
    }
    public function getRouteParams()
    {
        return $this->routeParams;
    }
}
