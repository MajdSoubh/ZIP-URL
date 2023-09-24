<?php

namespace Core\Support;

use App\Models\User;
use Exception;

class Auth
{

    /**
     * The session key for authenticated user. 
     */
    protected static $sessionKey = 'user';


    /**
     * Attempt to log the user in if the login credentials are correct.
     * @param array $credentials User credentials must have email and password.
     * @return boolean True if user log in false otherwise.
     */
    public static function attempt($credentials)
    {

        // Retrieve the required user. 
        $user = User::where(['email', '=', $credentials['email']])->first();

        // If user doesn't exists return false.
        if (empty($user))
        {
            return false;
        }

        // Check if passwords match.
        if (!Hash::verify($credentials['password'], $user['password']))
        {
            return false;
        }

        $user =  Arr::except($user, 'password');

        // Save the logged user to the session.
        session()->set(self::$sessionKey, json_encode($user));

        return true;
    }

    /**
     * Perform user login.
     * @param array $credentials User credentials must have email.
     * @return boolean True if user log in false otherwise.
     */
    public static function login($credentials)
    {

        // Retrieve the required user. 
        $user = User::where(['email', '=', $credentials['email']])->first();

        // If user doesn't exists return false.
        if (empty($user))
        {
            return false;
        }

        $user =  Arr::except($user, 'password');

        // Save the logged user to the session.
        session()->set(self::$sessionKey, json_encode($user));

        return true;
    }

    /**
     * Check if the user is authenticated.
     *
     * @return bool
     */
    public static function check()
    {
        return session()->has(self::$sessionKey);
    }

    /**
     * Get the authenticated user.
     *
     * @return User|null
     */
    public static function user()
    {
        return Auth::check() ? json_decode(session()->get(self::$sessionKey)) : null;
    }

    /**
     * Logout the user.
     *
     * @return bool
     */
    public static function logout()
    {
        return   session()->destroy();
    }
}
