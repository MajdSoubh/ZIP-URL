<?php

namespace Core\Validation;

use Exception;

trait RulesMapper
{

    protected static array $rulesMap = [
        'required' => \Core\Validation\Rules\RequiredRule::class,
        'alnum' => \Core\Validation\Rules\AlphaNumericalRule::class,
        'max' => \Core\Validation\Rules\MaxRule::class,
        'min' => \Core\Validation\Rules\MinRule::class,
        'between' => \Core\Validation\Rules\BetweenRule::class,
        'confirmed' => \Core\Validation\Rules\ConfirmationRule::class,
        'email' => \Core\Validation\Rules\EmailRule::class,
        'url' => \Core\Validation\Rules\URLRule::class,
        'unique' => \Core\Validation\Rules\UniqueRule::class,
    ];

    public static function resolve($rule, $options)
    {
        // Check if rule name exist in rules map.

        if (!isset(static::$rulesMap[$rule]))
        {

            throw new Exception('Rule ' . $rule . ' not exist in rulesMap array.');
        }

        return new static::$rulesMap[$rule](...$options);
    }
}
