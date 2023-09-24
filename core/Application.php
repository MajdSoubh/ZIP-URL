<?php

namespace Core;

use Core\Database\DB;
use Core\Database\Managers\MysqlManager;
use Core\Http\Request;
use Core\Http\Response;
use Core\Http\Route;
use Core\Support\Auth;
use Core\Support\Config;
use Core\Support\Session;
use Core\Support\Str;
use Core\View\View;
use Exception;

class Application
{


    protected Route $route;
    protected Request $request;
    protected Response $response;
    protected Config $config;
    protected Auth $auth;
    protected View $view;
    protected Session $session;
    protected DB $db;
    protected static  $instance;

    private function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->auth = new Auth();
        $this->view = new View();
        $this->route = new Route($this->request, $this->response);
        $this->config = new Config($this->loadConfiguration());
        $this->db = new DB($this->getDatabaseDriver());
    }

    protected function getDatabaseDriver()
    {

        return match (Str::lower(env('DB_DRIVER')))
        {
            'mysql' => new MysqlManager,
            default => new MysqlManager
        };
    }
    public static function getInstance()
    {
        static::$instance;
        if (!static::$instance)
        {

            static::$instance = new Application();
        }

        return static::$instance;
    }

    protected function loadConfiguration()
    {
        foreach (scandir(config_path()) as $file)
        {
            if ($file === '.' || $file === '..') continue;

            $filename = explode('.', $file)[0];

            yield $filename => require config_path($file);
        }
    }
    public function run()
    {
        try
        {
            $this->db->init();
            $this->route->resolve();
        }
        catch (Exception $e)
        {
            $this->view->makeException($e);
        }
    }

    public function __get($name)
    {
        return property_exists($this, $name) ? $this->$name : null;
    }
}
