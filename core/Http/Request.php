<?php

namespace Core\Http;

use Core\Support\Arr;
use Core\Support\Auth;

class Request
{

    protected  $routeParams = [];

    public  function method()
    {
        $method = $this->has('_method') ?  $this->get('_method') :  $_SERVER['REQUEST_METHOD'];

        return  strtolower($method);
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

    public function remove(...$keys)
    {
        return Arr::forget($_REQUEST, $keys);
    }

    public function except(...$keys)
    {
        return Arr::except($_REQUEST, $keys);
    }

    public function get($key)
    {
        return Arr::get($this->all(), $key);
    }

    public function set($key, $value)
    {
        return Arr::set($_REQUEST, $key, $value);
    }

    public function has($key)
    {
        return Arr::has($this->all(), $key);
    }

    public function getActualMethod()
    {
        return  strtolower($_SERVER['REQUEST_METHOD']);
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
