<?php

namespace Core\Validation\Rules;

use Core\Validation\Rules\Contract\Rule;

class RequiredRule implements Rule
{
    public function apply($field, $value, $data)
    {
        return !($value === '' || $value === null);
    }

    public function __toString()
    {
        return "The field %s is required.";
    }
}
