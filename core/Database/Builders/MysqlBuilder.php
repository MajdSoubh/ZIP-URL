<?php

namespace Core\Database\Builders;


use Core\Database\Grammars\MysqlGrammar;

class MysqlBuilder
{

    protected array $filters;

    protected  $query;

    protected $manager;

    public function __construct($manager)
    {
        $this->manager = $manager;
    }

    public  function get(...$columns)
    {
        $fields = [];
        foreach ($columns as $column)
        {
            if (is_array($column))
            {
                $fields = array_merge($fields, $column);
            }
            else
            {
                $fields[] = $column;
            }
        }

        $this->query = MysqlGrammar::buildSelectGrammar($fields);

        return $this->manager->query($this->resolveQuery());
    }

    public  function first(...$columns)
    {
        $fields = [];
        foreach ($columns as $column)
        {
            if (is_array($column))
            {
                $fields = array_merge($fields, $column);
            }
            else
            {
                $fields[] = $column;
            }
        }

        $this->query = MysqlGrammar::buildSelectGrammar($fields);

        return $this->manager->query($this->resolveQuery())[0] ?? [];
    }

    public  function where($filter)
    {
        $this->filters[] = $filter;

        return $this;
    }


    public  function delete()
    {

        $this->query = MysqlGrammar::buildDeleteGrammar();

        return $this->manager->query($this->resolveQuery());
    }


    public  function update($data)
    {
        $this->query = MysqlGrammar::buildUpdateGrammar(array_keys($data));

        return $this->manager->query($this->resolveQuery(), array_values($data));
    }

    public function resolveQuery()
    {

        $query = $this->query;

        foreach ($this->filters as $filter)
        {

            $query = MysqlGrammar::bindFilterGrammer($query, $filter);
        }


        return $query;
    }
}
