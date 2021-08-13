<?php

namespace App\Response;


class rules
{
    private static $credentialsRule = [
        'name' => 'required|min:3|max:20',
        'email' => 'required|unique:users|email',
        'password' => 'required|min:8|max:20|confirmed'
    ];

    private static $updateRules = [
        'name' => 'min:3|max:20',
        'email' => 'unique:users|email',
    ];

    private static $reset = [
        'password' => 'required|confirmed'
    ];

    private static $login = [
        'email' => 'required|email',
        'password' => 'required|min:8'
    ];

    static function registerRules() 
    {
        return self::$credentialsRule;
    }

    static function updateRules() 
    {
        return self::$updateRules;
    }

    static function resetPassRules()
    {
        return self::$reset;
    }

    static function loginRules()
    {
        return self::$login;
    }

    
}