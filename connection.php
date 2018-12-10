<?php

class Database{

    private $dbhost = "mysql:dbname=xchat;host = 127.0.0.1";
    private $dbname = "root";
    private $dbpass = "";

    function connectToDb()
    {
        try
        {
            $dbcon = new PDO($this->dbhost, $this->dbname,$this->dbpass);

        }
        catch(PDOException $err)
        {
            echo"Something went wrong  ".$err->getMessage();
        }

        return $dbcon;
    }
}


?>

