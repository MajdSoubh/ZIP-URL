<?php

namespace Core\Http;

use Core\Support\Arr;
use Core\View\View;

class Route
{
    protected Request $request;

    protected Response $response;

    private static array $routes = [];

    private static  $middlewares = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    protected function getMethod()
    {
        $method = $this->request->has('method') ? $this->request->get('method') : $this->request->method();

        return strtolower($method);
    }

    /**
     * Register get route
     * @param string $route Path to register. 
     * @param array|callable $action Action will triggered when user access path. 
     * @param array|string|object $middlewares Assign middlewares to handle request before action triggered. 
     */
    public static function get($route, array|callable $action, array|string|object $middlewares = [])
    {
        // Trim slashes.
        $route = trim($route, '/');

        self::$routes['get'][$route] = $action;

        // Parse middlewares
        $middlewares = self::parseMiddlewares('get', $route, $middlewares);

        // Save parsed middlewares into desired method and route.
        self::$middlewares['get'][$route] = $middlewares;
    }

    /**
     * Register post route
     * @param string $route Path to register. 
     * @param array|callable $action Action will triggered when user access path. 
     * @param array|string|object $middlewares Assign middlewares to handle request before action triggered. 
     */
    public static function post($route, array|callable $action, array|string|object $middlewares = [])
    {
        // Trim slashes.
        $route = trim($route, '/');

        self::$routes['post'][$route] = $action;

        // Parse middlewares
        $middlewares = self::parseMiddlewares('post', $route, $middlewares);

        // Save parsed middlewares into desired method and route.
        self::$middlewares['post'][$route] = $middlewares;
    }

    /**
     * Register put route
     * @param string $route Path to register. 
     * @param array|callable $action Action will triggered when user access path. 
     * @param array|string|object $middlewares Assign middlewares to handle request before action triggered. 
     */
    public static function put($route, array|callable $action, array|string|object $middlewares = [])
    {
        // Trim slashes.
        $route = trim($route, '/');

        self::$routes['put'][$route] = $action;

        // Parse middlewares
        $middlewares = self::parseMiddlewares('put', $route, $middlewares);

        // Save parsed middlewares into desired method and route.
        self::$middlewares['put'][$route] = $middlewares;
    }

    /**
     * Register delete route
     * @param string $route Path to register. 
     * @param array|callable $action Action will triggered when user access path. 
     * @param array|string|object $middlewares Assign middlewares to handle request before action triggered. 
     */
    public static function delete($route, array|callable $action, array|string|object $middlewares = [])
    {
        // Trim slashes.
        $route = trim($route, '/');

        self::$routes['delete'][$route] = $action;

        // Parse middlewares
        $middlewares = self::parseMiddlewares('delete', $route, $middlewares);

        // Save parsed middlewares into desired method and route.
        self::$middlewares['delete'][$route] = $middlewares;
    }

    /**
     * Execute specific route action.
     */
    public function resolve()
    {
        // Get request method.
        $method = $this->getMethod();
        //Get user requested path and trim slashes.
        $requestedPath = trim($this->request->path(), '/');

        // Get all routes of specific method type.
        $routes = self::$routes[$method];

        foreach ($routes as $path => $action)
        {
            $routeParamsNames = [];
            $routeParamsValues = [];

            // Convert path to regex.
            $pathRegex = "@^" . preg_replace_callback('/{\w+(:([^}]+))?}/', fn ($m) => isset($m[2]) ? "($m[2])" : '(\w+)', $path) . "$@";

            // Check if requested path match current pathRegex.
            if (preg_match_all($pathRegex, $requestedPath, $matches))
            {
                // Get all user requested path params values.
                $routeParamsValues = Arr::flatten(Arr::except($matches, 0));

                // Find all route params names from path and save in $routeParamsNames
                if (preg_match_all('/{(\w+)(:[^}]+)?}/', $path, $matches))
                {
                    $routeParamsNames = $matches[1];
                }

                // Combine between path registered keys and user requested path params values.
                $routeParams = array_combine($routeParamsNames, $routeParamsValues);

                // Assign route params to request.
                app()->request->setRouteParams($routeParams);

                return $this->resolveMiddlewares($method, $path);
            }
        }

        //    If user requested path not registered render 404 error view.
        return View::makeError('404');
    }


    /**
     * Handle the user request and perform a properly action. 
     */
    public  function resolveMiddlewares($method, $path)
    {

        $middlewares = self::$middlewares[$method][$path] ?? [];

        $request = app()->request;

        $index = 0;

        // Create middleware pipeline.
        // If one of the middlewares not pass the request to next middleware execution will stop and return middleware response.
        $handleMiddleware = function ($request) use (&$index, &$handleMiddleware, &$middlewares, $path, $method)
        {
            // If no middleware remains execute route action.
            if ($index >= count($middlewares))
            {

                return $this->resolveAction($method, $path);
            }

            // Get next middleware.
            $middleware = $middlewares[$index];
            $index++;

            // Let next middleware handle the request.
            return $middleware->handle($request, $handleMiddleware);
        };


        $response = $handleMiddleware($request);

        // Print response to user.
        echo  $response;
    }


    protected function resolveAction($method, $path)
    {
        // Get route action.
        $action = self::$routes[$method][$path];

        if (is_callable($action))
        {
            return   call_user_func_array($action, app()->request->getRouteParams());
        }

        // if action is method of class create new instance of class and call the method.
        if (is_array($action))
        {
            return  call_user_func_array([new $action[0], $action[1]], app()->request->getRouteParams());
        }
    }

    /**
     * Parse middlewares
     */
    protected static  function parseMiddlewares($method, $route, $middlewares = [])
    {
        if (is_object($middlewares))
        {

            $middlewares = [$middlewares];
        }
        else
        {
            $middlewares = (array)$middlewares;
        }

        $result = [];

        foreach ($middlewares as $middleware)
        {

            if (is_object($middleware))
            {

                $result[] =  $middleware;
            }
            else
            {
                $result[] = new $middleware;
            }
        }

        return $result;
    }
}
