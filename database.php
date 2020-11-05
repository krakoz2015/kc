<?php

session_start();

class Database{
    private $host = "localhost";
    private $db_name = "allergist2_moz";
    private $username = "allergist2_moz";
    private $password = "dKEvT3IBt";
    public $conn;
 
    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

?>

