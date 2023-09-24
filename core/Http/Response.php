<?php

namespace Core\Http;


class Response
{

    protected $statusCode;
    protected array $headers = [];
    protected $body;

    public function __construct($data = null, $code = 200)
    {
        $this->body = $data;
        $this->statusCode = $code;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function header($name, $value)
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function body($body)
    {
        $this->body = $body;
        return $this;
    }
    public function json($body)
    {
        $this->body = json_encode($body);
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function back()
    {
        if (!headers_sent())
        {

            return   header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
    public function redirect($route)
    {
        if (!headers_sent())
        {

            return   header('Location:' . $route);
        }
    }
    public function send()
    {
        // Set the HTTP status code
        http_response_code($this->statusCode);

        // Set the response headers
        foreach ($this->headers as $name => $value)
        {
            header("$name: $value");
        }

        // Send the response body

        return $this->body ?? '';
    }

    public function __toString()
    {

        return $this->send();
    }


    public function __get($name)
    {
        return property_exists($this, $name) ? $this->$name : null;
    }

    public function __set($name, $value)
    {
        property_exists($this, $name) ? $this->$name = $value : null;
    }
}
