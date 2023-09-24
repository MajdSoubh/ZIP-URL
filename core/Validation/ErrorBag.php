<?php

namespace Core\Validation;

class ErrorBag
{
    protected array $errors = [];
    public  function add($field, $message)
    {

        $this->errors[$field][] = $message;
    }

    public function __get($property)
    {
        return property_exists($this, $property) ? $this->$property : null;
    }
}
