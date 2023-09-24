<?php

namespace Core\Validation;

use Core\Support\Arr;

class Validator
{
    protected array $data = [];
    protected array $rules = [];
    protected array $aliases = [];
    protected ErrorBag $errorBag;


    /**
     * Initializes the validator with the provided data, rules, and aliases. It triggers the validation process internally.
     * @param array $data The data to be validated.
     * @param array $rules Validation rules for each field.
     * @param array $aliases Field name aliases for error messages.
     */
    public function make($data, $rules = [], $aliases = [])
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->aliases = $aliases;
        $this->errorBag = new ErrorBag();
        $this->validate();
    }

    protected function validate()
    {
        foreach ($this->rules as $field => $rules)
        {
            foreach (RulesResolver::resolveRules($rules) as $rule)
            {
                $this->applyRule($field, $rule);
            }
        }
    }

    protected function applyRule($field, $rule)
    {

        if (!$rule->apply($field, $this->getFieldValue($field), $this->data))
        {
            $this->errorBag->add($field, Message::generate($rule, $this->alias($field)));
        }
    }


    protected function getFieldValue($field)
    {

        return Arr::get($this->data, $field, null);
    }
    public function setRules($rules)
    {
        $this->rules = $rules;
    }


    /**
     * Checks if there are any validation errors.
     * @return bool
     */
    public function fails()
    {
        return !empty($this->errors());
    }

    /**
     * Checks if there aren't any validation errors.
     * @return bool
     */
    public function passes()
    {
        return empty($this->errors());
    }
    public function errors($key = null)
    {
        return $key ? $this->errorBag->errors[$key] : $this->errorBag->errors;
    }

    public function alias($field)
    {
        return $this->aliases[$field] ?? $field;
    }

    public function setAliases(array $aliases)
    {
        $this->aliases = $aliases;
    }
}
