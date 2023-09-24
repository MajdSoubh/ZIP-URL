<?php

namespace Core\Database\Managers;

use App\Models\Model;
use Core\Database\Builders\MysqlBuilder;
use Core\Database\Grammars\MysqlGrammar;
use Core\Database\Managers\Contract\DatabaseManager;
use PDO;

class MysqlManager implements DatabaseManager
{
    protected static ?PDO $instance = null;


    public function connect(): PDO
    {
        if (!self::$instance)
        {
            self::$instance = new PDO('mysql:host=' . env('DB_HOST') . ';dbname=' . env('DB_DATABASE'), env('DB_USERNAME'), env('DB_PASSWORD'));
        }
        return self::$instance;
    }

    public function query(string $query, $values = [])
    {

        $stmt = self::$instance->prepare($query);

        foreach ($values as $index => $value)
        {

            $stmt->bindValue($index + 1, $value);
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $query = MysqlGrammar::buildInsertGrammar(array_keys($data));

        $stmt = self::$instance->prepare($query);

        foreach (array_values($data) as $index => $value)
        {

            $stmt->bindValue($index + 1, $value);
        }


        return $stmt->execute();
    }

    public function read($columns = '*', $filter = null)
    {
        $query = MysqlGrammar::buildSelectGrammar($columns);

        if (!empty($filter))
        {

            $query = MysqlGrammar::bindFilterGrammer($query, $filter);
        }

        $stmt = self::$instance->prepare($query);

        if ($filter)
        {
            $stmt->bindValue(2, $filter[2]);
        }

        $stmt->execute();


        //  return $stmt->fetchAll(PDO::FETCH_CLASS, Model::getModel());
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function update($id, $data)
    {
        $query = MysqlGrammar::buildUpdateGrammar(array_keys($data));
        $query = MysqlGrammar::bindFilterGrammer($query, ['id', '=', $id]);


        $stmt = self::$instance->prepare($query);

        foreach (array_values($data) as $index => $value)
        {


            $stmt->bindValue($index + 1, $value);
        }


        return $stmt->execute();
    }

    public function delete($id)
    {
        $query = MysqlGrammar::buildDeleteGrammar();
        $query = MysqlGrammar::bindFilterGrammer($query, ['id', '=', $id]);

        $stmt = self::$instance->prepare($query);


        return $stmt->execute();
    }

    public function filter($filter)
    {

        $builder = new MysqlBuilder($this);

        $builder->where($filter);

        return $builder;
    }
}
