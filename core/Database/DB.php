<?php

namespace Core\Database;

use Core\Database\Managers\Contract\DatabaseManager;


class DB
{
    protected DatabaseManager $manager;

    public function __construct(DatabaseManager $manager)
    {
        $this->manager = $manager;
    }


    public function init()
    {
        return  $this->manager->connect();
    }

    protected function query(string $query, $values = [])
    {
        return $this->manager->query($query, $values);
    }
    protected function create($data)
    {
        return $this->manager->create($data);
    }

    protected function update($id, $data)
    {
        return $this->manager->update($id, $data);
    }

    protected function delete($id)
    {
        return $this->manager->delete($id);
    }

    protected function read($columns = "*", $filter = null)
    {
        return $this->manager->read($columns, $filter);
    }


    protected function filter($filter)
    {
        return $this->manager->filter($filter);
    }
    public function __call($name, $arguments)
    {

        if (method_exists($this, $name))
        {
            return call_user_func([$this, $name], ...$arguments);
        }
    }
}
