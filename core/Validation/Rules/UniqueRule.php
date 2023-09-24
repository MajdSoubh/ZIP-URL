<?php

namespace Core\Validation\Rules;

use Core\Validation\Rules\Contract\Rule;
use Exception;

class UniqueRule implements Rule
{
    protected $table;
    protected $column;
    protected $except;

    public function __construct($table, $column, $except = null)
    {
        if ($table == null || $column == null)
        {
            throw new \Exception('You must provide table and column names to rule unique. ');
        }

        $this->table = $table;
        $this->column = $column;
        $this->except = $except;
    }

    public function apply($field, $value, $data)
    {

        $data = [];
        if (!isset($this->except))
        {

            $data = app()->db->query("SELECT count(*) as `count` FROM {$this->table} WHERE {$this->column} = ?", [$value])[0];
        }
        else
        {
            $data = app()->db->query("SELECT count(*) as `count` FROM {$this->table} WHERE {$this->column} = ? AND  id <> ?", [$value, $this->except])[0];
        }

        return $data['count'] == 0;
    }

    public function __toString()
    {
        return '%s is already exists in our records.';
    }
}
