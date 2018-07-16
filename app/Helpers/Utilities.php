<?php

namespace App\Helpers;


use phpDocumentor\Reflection\Types\Integer;

class Utilities
{
    public static function getValidationError(Integer $errorType = null, $errorsBag = [])
    {
        return new ValidationError($errorType, $errorsBag);
    }
}