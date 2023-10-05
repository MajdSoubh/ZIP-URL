<?php

use Core\Application;
use Core\Support\Hash;
use Core\View\View;

if (!function_exists('base_path'))
{
    /**
     * Project root directory path
     */
    function base_path($path = '')
    {
        return dirname(__DIR__, 2) . '/' . $path;
    }
}

if (!function_exists('config_path'))
{
    /**
     * Project configuration files directory path
     */
    function config_path($path = '')
    {
        return base_path('config/' . $path);
    }
}


if (!function_exists('view_path'))
{
    /**
     * View directory path
     */
    function view_path($path = '')
    {
        return dirname(__DIR__, 2) . '/views/' . $path;
    }
}


if (!function_exists('view'))
{
    /**
     * Render a view or return view instance.
     *
     * @param string $path The path to the view file (optional).
     * @param string|null $layout The path to the base layout file (optional).
     * @param array $params An associative array of parameters to pass to the view (optional).
     */
    function view($view = null, $layout = null, $params = [])
    {
        return $view ? View::make($view, $layout, $params) : app()->view;
    }
}

if (!function_exists('config'))
{
    function config($key = null, $default = null)
    {
        if (is_null($key))
        {
            return app()->config;
        }
        if (is_array($key))
        {
            return app()->config->set($key);
        }
        return app()->config->get($key);
    }
}

if (!function_exists('env'))
{

    function env($key, $default = '')
    {
        return $_ENV[$key] ?? value($default);
    }
}

if (!function_exists('app'))
{

    function app()
    {
        static $instance = null;
        if (!$instance)
        {
            $instance = Application::getInstance();
        }
        return $instance;
    }
}

if (!function_exists('value'))
{
    function value($val)
    {

        return $val instanceof Closure ? $val() : $val;
    }
}


if (!function_exists('bcrypt'))
{
    function bcrypt($value)
    {
        return Hash::make($value);
    }
}



if (!function_exists('class_basename'))
{
    function class_basename($class)
    {
        $class = is_object($class) ? get_class($class) : $class;

        return basename(str_replace('\\', '/', $class));
    }
}

if (!function_exists('request'))
{
    function request($key = null)
    {
        if (is_string($key))
        {
            return app()->request->get($key);
        }
        if (is_array($key))
        {
            return app()->request->only($key);
        }
        return  app()->request;
    }
}

if (!function_exists('response'))
{
    function response($body = null, $code = 200)
    {
        $response = app()->response;


        $response->body = $body;
        $response->statusCode = $code;

        return $response;
    }
}


if (!function_exists('session'))
{
    function session($key = null)
    {
        return $key ? app()->session->get($key) : app()->session;
    }
}

if (!function_exists('auth'))
{
    function auth()
    {
        return  app()->auth;
    }
}


if (!function_exists('old'))
{
    function old($key = null)
    {
        if (session()->hasFlash('old'))
        {

            return $key ? session()->getFlash('old.' . $key) : session()->getFlash('old');
        }
    }
}


if (!function_exists('back'))
{
    function back()
    {
        return app()->response->back();
    }
}
if (!function_exists('redirect'))
{
    function redirect($route)
    {
        return app()->response->redirect($route);
    }
}

if (!function_exists('errors'))
{
    function errors($key = null)
    {
        return $key ? session()->getFlash('errors.' . $key)  : session()->getFlash('errors');
    }
}

if (!function_exists('asset'))
{
    function asset($asset = '')
    {
        $asset = ltrim($asset, '/');
        return  env('APP_URL') . '/' . $asset;
    }
}
if (!function_exists('url'))
{
    function url($url = '')
    {
        $url = ltrim($url, '/');
        return  env('APP_URL') . '/' . $url;
    }
}

if (!function_exists('csrf'))
{
    function csrf()
    {
        return  session('_token');
    }
}
