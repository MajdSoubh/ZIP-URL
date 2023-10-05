<?php

namespace Core\Support;

class Hash
{

    /**
     * Generate a hash value using Bcrypt algorthm.
     * @param String $value The value to be hashed.
     * @return String The generated password hash.
     */
    public static function make($value)
    {
        return password_hash($value, PASSWORD_BCRYPT);
    }

    /**
     * Verify if a value matches a given hashed value.
     * @param String $value The value to verify. 
     * @param String $hashedValue The hashed value to compare against.
     * 
     * @return Bool Return true if the value matches the hashed value, false otherwise.  
     */
    public static function verify($value, $hashedValue)
    {
        return password_verify($value, $hashedValue);
    }

    /**
     * Generate random hash based on the given value.
     * @param string $value The value to generate a random hash from.
     * @return string The generated random hash.
     */
    public static function random($value = null)
    {
        return sha1($value . time());
    }
}
