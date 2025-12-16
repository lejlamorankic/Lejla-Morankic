<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Config
{
    public static function DB_HOST()
    {
        return 'localhost';
    }

    public static function DB_PORT()
    {
        return 3307; 
    }

    public static function DB_USER()
    {
        return 'root';
    }

    public static function DB_PASSWORD()
    {
        return ''; 
    }

    public static function DB_NAME()
    {
        return 'fittrack';
    }

    public static function JWT_SECRET()
    {
        return 'malemace12345';
    }
}

class Database
{
    public static function connect(): PDO
    {
        try {
            return new PDO(
                "mysql:host=" . Config::DB_HOST() .
                ";port=" . Config::DB_PORT() .
                ";dbname=" . Config::DB_NAME() .
                ";charset=utf8mb4",
                Config::DB_USER(),
                Config::DB_PASSWORD(),
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}
