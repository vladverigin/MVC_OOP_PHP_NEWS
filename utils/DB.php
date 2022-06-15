<?php

namespace utils;

class DB
{
    public static function setupConnection(): \PDO
    {
        $params = include('./config/db.php');
        return new \PDO("mysql:host={$params['host']}; dbname={$params['dbname']}",$params['user'],$params['pass']);
    }
}
