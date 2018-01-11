<?php

class DatabaseConnection
{
    private $conn;
    public function __construct()
    {
        $servername = "helios.csesalford.com";
        $username = "stc954";
        $password = "gs1zxKvx2";
        $databaseName = 'stc954';
        $port = "3306";
        try{
            $this->conn = new PDO("mysql:host=$servername;dbname=$databaseName", $username, $password);
        } catch (PDOException $e)
        {
            echo "Sorry error";
            die();
        }
    }

    public function getConncetion()
    {
        return $this->conn;
    }

}