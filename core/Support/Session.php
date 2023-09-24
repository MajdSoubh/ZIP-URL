<?php

namespace Core\Support;


class Session
{


    public function __construct()
    {
        $this->startSession();

        $this->removeFlashMessages(0);
    }


    /**
     *    (Re)starts the session.
     *    
     *    @return    bool    TRUE if the session has been initialized, else FALSE.
     **/

    public function startSession()
    {
        if (session_status() === PHP_SESSION_NONE)
        {
            session_name(env('APP_NAME', 'APP') . '_SESSION_ID');
            session_start();
        }
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    public function has($key)
    {

        return isset($_SESSION[$key]);
    }

    public function get($key)
    {

        return $this->has($key) ? $_SESSION[$key] : null;
    }

    public function forget($key)
    {

        if ($this->has($key))
        {
            unset($_SESSION[$key]);
            return true;
        }
        return false;
    }
    public function hasFlash($key)
    {
        return isset($_SESSION['flash_messages'][$key]);
    }

    public function setFlash($key, $message)
    {
        $_SESSION['flash_messages'][$key] = [
            'remove' => false,
            'content' => $message
        ];
    }
    public function getFlash($key)
    {

        $segments = explode('.', $key);

        $flashMessages = $_SESSION['flash_messages'][$segments[0]]['content'] ?? null;

        $remainsKey = implode('.', Arr::except($segments, 0));

        return  !empty($remainsKey) ? Arr::get($flashMessages, $remainsKey) : $flashMessages;
    }

    public function __destruct()
    {
        $this->removeFlashMessages(1);
    }

    public function destroy()
    {
        setcookie("PHPSESSID", null, -1, "/");
        unset($_SESSION);
        session_destroy();
    }

    protected function removeFlashMessages($remove = false)
    {
        $flashMessages = $_SESSION['flash_messages'] ?? [];
        foreach ($flashMessages as $key => &$flashMessage)
        {
            if ($remove)
            {

                if ($flashMessage['remove'])
                {

                    unset($flashMessages[$key]);
                }
            }
            else
            {
                $flashMessage['remove'] = true;
            }
        }
        $_SESSION['flash_messages'] = $flashMessages;
    }
}
