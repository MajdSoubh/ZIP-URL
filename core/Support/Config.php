<?php

namespace Core\Support;

use ArrayAccess;

class Config implements ArrayAccess
{
    protected array $items = [];


    public function __construct($items)
    {
        foreach ($items as $key => $value)
        {

            $this->items[$key] = $value;
        }
    }

    public function all()
    {
        return $this->items;
    }
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->set($offset, $value);
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->exists($offset);
    }


    public function offsetUnset(mixed $offset): void
    {
        $this->unset($offset);
    }


    public function get($keys, $default = null)
    {

        return Arr::get($this->items, $keys, $default);
    }

    public function set($key, $value = null)
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value)
        {

            Arr::set($this->items, $key, $value);
        }
    }

    public function unset($key)
    {
        return Arr::unset($this->items, $key);
    }
    public function exists($key)
    {
        return Arr::exists($this->items, $key);
    }
}
