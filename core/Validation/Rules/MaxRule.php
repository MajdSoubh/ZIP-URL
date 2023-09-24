<?php

namespace Core\Validation\Rules;

use Core\Validation\Rules\Contract\Rule;

class MaxRule implements Rule
{
    protected $max;
    public function __construct($max)
    {
        $this->max = $max;
    }

    public function apply($field, $value, $data)
    {
        return strlen($value) <= $this->max;
    }

    public function __toString()
    {
        return "%s length must be less than or equal to " . $this->max . '.';
    }
}
