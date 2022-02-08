<?php

namespace AbuDayeh\Core;

use PDO;
use PDOException;

class Database
{
    public PDO $pdo;

    public function __construct(array $config)
    {
        $HostName   = $config['HostName'] ?? '';
        $UserName   = $config['UserName'] ?? '';
        $Password   = $config['Password'] ?? '';
        $DbName     = $config['DbName'] ?? '';
        try {
            $this->pdo = new PDO('mysql:host=' . $HostName . ';dbname=' . $DbName, $UserName, $Password, array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            ));
        }catch (PDOException $e){
            echo $e->getMessage();
            exit();
        }
    }
}