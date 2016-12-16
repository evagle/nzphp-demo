<?php

namespace common;


class ErrorCode
{

    private static $errorMessages = array(
        1 => "Undefined error",
        2 => "System error",
    );

    public static function getErrorMessage($code)
    {
        if (self::$errorMessages[$code]) {
            return self::$errorMessages[$code];
        } else {
            return self::$errorMessages[self::UNDEFINED_ERROR];
        }
    }

    public static function getErrorLevel($code)
    {
        if ($code < 100) {
            return "alert";
        } else {
            return "error";
        }
    }

    // system error < 100
    const UNDEFINED_ERROR = 1;
    const SYSTEM_ERROR = 2;

    // user error > 100

}