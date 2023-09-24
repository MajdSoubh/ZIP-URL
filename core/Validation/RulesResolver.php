<?php

namespace Core\Validation;

trait RulesResolver
{

    public static function resolveRules($rules)
    {
        $rules = is_string($rules) ? explode('|', $rules) : $rules;

        return array_map(function ($rule)
        {
            if (is_string($rule))
            {
                return static::resolveRuleFromString($rule);
            }
            return $rule;
        }, $rules);
    }

    protected static function resolveRuleFromString($rule)
    {

        $segments = explode(':', $rule);

        $rule = $segments[0];

        array_shift($segments);

        $options = explode(',', $segments[0] ?? '');


        return RulesMapper::resolve($rule, $options);
    }
}
