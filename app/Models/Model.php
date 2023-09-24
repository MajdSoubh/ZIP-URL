<?php

namespace App\Models;

use Core\Support\Str;
use ReflectionClass;

abstract class Model
{
    protected static $instance;

    protected  static $table;


    public static function query($query, $values = [])
    {
        return app()->db->raw($query, $values);
    }

    public static function all()
    {
        static::init();

        return app()->db->read();
    }



    public static function where($filter)
    {

        static::init();

        return app()->db->filter($filter);
    }

    public static function create($attributes)
    {
        static::init();

        return app()->db->create($attributes);
    }


    public static function delete($id)
    {
        static::init();

        return app()->db->delete($id);
    }


    public static function update($id, $data)
    {
        static::init();

        return app()->db->update($id, $data);
    }

    public static function init()
    {
        self::$instance = static::class;
    }

    public static function getModel()
    {

        return self::$instance;
    }
    public static function getTableName()
    {

        $table = isset(self::$instance::$table) ?
            self::$instance::$table :
            Str::lower(Str::plural(class_basename(Model::getModel())));

        return $table;
    }
}
