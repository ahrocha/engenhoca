<?php

namespace App\Services;

class SecurityService
{
    private $allowedIps;

    public function __construct()
    {
        $this->allowedIps = explode(',', getenv('ALLOWED_IPS'));
    }

    public function isAllowed()
    {
        if (empty($this->allowedIps)) {
            return true;
        }
        return in_array($_SERVER['REMOTE_ADDR'], $this->allowedIps);
    }
}
