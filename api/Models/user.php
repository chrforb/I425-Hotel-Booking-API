<?php

public static function authenticateUser(string $username, string $password)
{
    $user = self::where('username', $username)
                ->where('password', $password)
                ->first();

    return $user !== null;
}

public static function authenticateUser(string $username, string $password)
{
    $user = self::where('username', $username)->first();

    if (!$user) {
        return false;
    }

    return password_verify($password, $user->password);
}
