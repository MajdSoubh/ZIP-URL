<?php

namespace Core\Validation\Rules;

use Core\Validation\Rules\Contract\Rule;

class BetweenRule implements Rule
{
    protected $min;
    protected $max;

    public function __construct($min, $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function apply($field, $value, $data)
    {
        return strlen($value) >= $this->min && strlen($value) <= $this->max;
    }

    public function __toString()
    {
        return "%s length must be between {$this->min} and {$this->max} characters.";
    }
}
