<?php

class DB
{
    protected $conn = null;

    public function Open()
    {
        try {
            $dsn = "mysql:dbname=beanstalk; host=localhost";
            $user = "root";
            $password = "";

            $options  = array(PDO::ATTR_ERRMODE =>      PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            );

            $this->conn = new PDO($dsn, $user, $password, $options);
            return $this->conn;
        } catch (PDOException $e) {
            echo 'Connection error: ' . $e->getMessage();
        }
    }
    
    public function Close()
    {
        $this->conn = null;
    }

    public function read($query){
        try{
            $db = new DB();
            $conn = $db->Open();
            if($conn){
                $result  = $conn->query($query);
                return $result;
            }else{
                echo $conn;
            }
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }
}
