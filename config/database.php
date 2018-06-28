<?php

class Database{
 
    /*Database Credentials*/
    private $host_name = "localhost";
    private $database_name = "api_db";
    private $user_name = "root";
    private $password = "";
    public $conn;
 
    /*Connecting to database*/
    public function getConnection(){
        $this->conn = null;
        try
		{
            $this->conn = new PDO("mysql:host=" . $this->host_name . ";dbname=" . $this->database_name, $this->user_name, $this->password);
        }
		catch(PDOException $exception)
		{
            echo "Error in connection: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

?>