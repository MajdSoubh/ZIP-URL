<?php

namespace Core\Validation\Rules;

use Core\Validation\Rules\Contract\Rule;

class MinRule implements Rule
{
    protected $min;
    public function __construct($min)
    {
        $this->min = $min;
    }

    public function apply($field, $value, $data)
    {
        return strlen($value) >= $this->min;
    }

    public function __toString()
    {
        return "%s length must be bigger than or equal to " . $this->min . '.';
    }
}
