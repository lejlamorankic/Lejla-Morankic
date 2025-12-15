<?php

class Roles
{
    const ADMIN = 'admin';
    const USER = 'user';

    public static function all()
    {
        return [
            self::ADMIN,
            self::USER
        ];
    }
}
