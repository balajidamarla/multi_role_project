<?php

namespace App\Libraries;

class TokenService
{
    protected static $decodedToken;

    public static function setDecodedToken($token)
    {
        self::$decodedToken = $token;
    }

    public static function getDecodedToken()
    {
        return self::$decodedToken;
    }

    public static function getUserId()
    {
        return self::$decodedToken->sub ?? null;
    }

    public static function getEmail()
    {
        return self::$decodedToken->email ?? null;
    }
}
