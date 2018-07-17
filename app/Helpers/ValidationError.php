<?php

namespace App\Helpers;


class ValidationError
{
    public $error         = null;
    public $errorMessages = null;

    public function __construct($error, $errorMessages)
    {
        $this->error = $error;
        $this->errorMessages = $errorMessages;
    }
}