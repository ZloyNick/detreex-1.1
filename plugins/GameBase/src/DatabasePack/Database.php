<?php

declare(strict_types=1);

namespace DatabasePack;

use mysqli;
use Exception;

class Database
{

    /**
     * @var mysqli|null $instance
     */
    protected static
        $instance;

    /**
     * Creates connection
     *
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $database
     * @param int $port
     * @return Database
     * @throws Exception
     */
    public static function connect(string $host, string $username, string $password, string $database, int $port = 3306) : Database
    {
        static::$instance = new mysqli
        (
                $host, $username, $password, $database, $port
        );

        //Handle
        $driver = &static::$instance;

        if($driver->connect_error)
        {
            //stack trace
            var_dump($driver->error_list);

            //Exception
            throw new Exception("Error: ({$driver->errno}) {$driver->connect_error}");
        }
        return (new static);
    }
}