<?php

namespace Core\Database\Grammars;

use App\Models\Model;

class MysqlGrammar
{

    public static function buildInsertGrammar($keys)
    {
        $fields = ' (`' . implode('`,`', $keys) . '`)';
        $values = '(' . str_repeat('?,', count($keys) - 1) . '? ' . ')';
        $query = 'INSERT INTO ' .
            Model::getTableName() .
            $fields  .
            ' values' .
            $values;

        return $query;
    }

    public static function buildUpdateGrammar($keys)
    {
        $fields = '`' . implode('`= ? , `', $keys) . '`= ?';
        $query = 'UPDATE ' .
            Model::getTableName() .
            ' SET ' .
            $fields;


        return $query;
    }
    public static function buildSelectGrammar($columns = '*')
    {
        $fields = $columns;

        if (empty($columns))
        {
            $fields = '*';
        }
        else if (is_array($columns))
        {
            $fields = '`' . implode('`,`', $columns) . '`';
        }

        $query = 'SELECT ' .
            $fields .
            ' FROM ' .
            Model::getTableName();


        return $query;
    }


    public static function buildDeleteGrammar()
    {
        $query = 'DELETE FROM ' . MODEL::getTableName();
        return $query;
    }

    public static function bindFilterGrammer($query, $filter = [])
    {
        // If no filter exist return query.
        if (is_null($filter) || empty($filter))
        {

            return $query;
        }

        $filterQuery = '';

        if (!str_contains($query, ' WHERE '))
        {

            $filterQuery = ' WHERE ';

            $filterQuery .= " {$filter[0]} {$filter[1]} '{$filter[2]}' ";
        }
        else
        {
            $filterQuery = ' AND ';

            $filterQuery .= " {$filter[0]} {$filter[1]} '{$filter[2]}' ";
        }


        $queryWithFilters = $query . $filterQuery;

        return $queryWithFilters;
    }
}
