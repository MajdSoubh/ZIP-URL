<?php

namespace Core\Validation\Rules;

use Core\Validation\Rules\Contract\Rule;

class EmailRule implements Rule
{


    public function apply($field, $value, $data)
    {
        return preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i', $value);
    }
    public function __toString()
    {
        return '%s field must be a valid email address.';
    }
}
