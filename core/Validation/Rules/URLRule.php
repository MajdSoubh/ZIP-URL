<?php

namespace Core\Validation\Rules;

use Core\Validation\Rules\Contract\Rule;

class URLRule implements Rule
{
    protected $protocol;

    public function __construct($protocol = null)
    {
        $this->setProtocol($protocol);
    }

    public function setProtocol($protocol)
    {

        // If specified protocol not correct return.
        if ($protocol !== 'http' && $protocol !== 'https')
        {

            return;
        }

        $this->protocol = $protocol;
    }

    public function apply($field, $value, $data)
    {
        $protocol = isset($this->protocol) ? $this->protocol : 'http|https';

        $regex = '(' . $protocol . '):\/\/'; // SCHEME
        $regex .= "(www\.)?([a-z0-9-]+\.?)+"; // Host or IP address
        $regex .= "(:[0-9]{2,5})?"; // Port
        $regex .= "(\/[a-z0-9+!\$&%_-~.]+)*\/?"; // Path
        $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\$._-]*)?"; // GET Query
        $regex .= "(#[a-z_.-][a-z0-9+\$%_.-]*)?"; // Anchor

        return preg_match('/^' . $regex . '/i', $value);
    }
    public function __toString()
    {
        $schemaSegment = isset($this->protocol) ? "starts with schema {$this->protocol}" : '';
        return "%s must be valid url {$schemaSegment}.";
    }
}
