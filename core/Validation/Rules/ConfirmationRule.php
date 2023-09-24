<?php

namespace Core\Validation\Rules;

use Core\Validation\Rules\Contract\Rule;

class ConfirmationRule implements Rule
{

    public function apply($field, $value, $data)
    {
        $confirmationField = $data[$field . '_confirmation'] ?? null;
        return $confirmationField == $value;
    }
    public function __toString()
    {
        return '%s does not match %s confirmation.';
    }
}
