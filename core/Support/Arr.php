<?php

namespace Core\Support;

use ArrayAccess;
use Closure;

class Arr
{

    public static function only($array, ...$keys)
    {
        $keys = Arr::flatten($keys);
        return array_intersect_key($array, array_flip($keys));
    }

    public static function flatten($array, $depth = INF)
    {
        if ($depth === 1)
        {
            return array_values($array);
        }
        if (!static::accessiable($array))
        {

            return [$array];
        }

        $result = [];
        foreach ($array as $item)
        {
            $res = static::flatten($item, $depth - 1);

            $result = array_merge($result, $res);
        }

        return $result;
    }
    public static function except($array, ...$keys)
    {
        $keys = Arr::flatten($keys);
        return static::forget($array, $keys);
    }
    public  static function accessiable($value)
    {
        return is_array($value) || $value instanceof ArrayAccess;
    }

    public static function exists($array, $key)
    {
        return $array instanceof ArrayAccess ? $array->offsetExists($key) : array_key_exists($key, $array);
    }

    public static function has($array, ...$keys)
    {
        $keys = Arr::flatten($keys);

        if (empty($keys))
        {
            return false;
        }

        foreach ($keys as $key)
        {
            $subArray = &$array;

            // Check if array key exists.
            if (static::exists($subArray, $key)) continue;

            foreach (explode('.', $key) as $segment)
            {
                if (!self::accessiable($subArray) || !self::exists($subArray, $segment))
                {
                    return false;
                }
                $subArray = &$subArray[$segment];
            }
        }
        return true;
    }


    public static function last($array,  callable $cal = null, $default = null)
    {
        if (is_null($cal))
        {
            if (empty($array))
            {
                return value($default);
            }

            return end($array);
        }

        if (empty($array))
        {
            return value($default);
        }

        $reversedArrayKeys = array_reverse($array, true);

        foreach ($reversedArrayKeys as $key => $value)
        {
            if ($result = call_user_func($cal, $value, $key))
            {
                return $result;
            }
            return $value;
        }
    }

    public static  function first($array, callable $cal = null, $default = null)
    {
        if (is_null($cal))
        {
            if (empty($array))
            {
                return value($default);
            }
            foreach ($array as $item)
            {
                return $item;
            }
        }

        if (empty($array))
        {
            return value($default);
        }

        foreach ($array as $key => $value)
        {
            if ($result = call_user_func($cal, $value, $key))
            {
                return $result;
            }
            return $value;
        }
    }

    public static function forget(&$orginial, ...$keys)
    {
        $keys = Arr::flatten($keys);

        if (empty($keys))
        {
            return $orginial;
        }

        foreach ($keys as $key)
        {
            $parts = explode('.', $key);
            $array = &$orginial;
            while (count($parts) > 1)
            {
                $part = array_shift($parts);
                if (!self::accessiable($array[$part]) || !self::exists($array, $part)) break;
                $array = &$array[$part];
            }

            $lastPart = array_shift($parts);

            if (self::exists($array, $lastPart))
            {
                unset($array[$lastPart]);
            }
        }
        return $orginial;
    }

    /**
     * Access array elements and return values from it.
     * @return array|mixed Return array of values if the params $keys is array otherwise return value of the provided key from array .
     */
    public static function get($array, $keys, $default = null)
    {
        $ukeys = (array)$keys;
        if (!static::accessiable($array) || empty($ukeys))
        {
            return value($default);
        }

        $result = [];
        foreach ($ukeys as $key)
        {
            if (static::exists($array, $key))
            {
                $result[] = $array[$key];
                continue;
            }
            $subArray = &$array;
            $doInsert = true;
            foreach (explode('.', $key) as $segment)
            {
                if (!static::accessiable($subArray) || !static::exists($subArray, $segment))
                {
                    $doInsert = false;
                    break;
                }
                $subArray = &$subArray[$segment];
            }
            $doInsert ? $result[] = $subArray : null;
        }


        if (!is_array($keys))
        {
            return end($result);
        }
        if (empty($result))
        {
            return value($default);
        }
        return value($result);
    }

    public static function set(&$array, $key, $value)
    {
        if (is_null($key))
        {
            $array[] = $value;
            return true;
        }

        foreach (explode('.', $key) as $segment)
        {
            if (!static::accessiable($array) || !static::exists($array, $segment)) return false;
            $array = &$array[$segment];
        }
        $array = $value;
        return true;
    }

    public static function unset(&$array, $key)
    {
        if (is_null($key)) return false;

        $parts = explode('.', $key);
        while (count($parts) > 1)
        {
            $part = array_shift($parts);
            if (!static::accessiable($array) || !static::exists($array, $part)) return false;
            $array = &$array[$part];
        }

        $lastPart = array_shift($parts);

        if (!static::accessiable($array) || !static::exists($array, $lastPart)) return false;

        unset($array[$lastPart]);

        return true;
    }
}
