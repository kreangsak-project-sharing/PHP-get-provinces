<?php

class Database
{
    public $dbconn;

    public function __construct()
    {
        $host = 'localhost';
        $db   = 'register_provinces';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $this->dbconn = new PDO($dsn, $user, $pass, $options);
            // echo "Connected to database successful";
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function closeConnection()
    {
        $this->dbconn = null;
    }
}
