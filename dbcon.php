<?php
function connectToDb()
{
    $dbhost = "mysql:dbname=xchat;host = 127.0.0.1";
    $dbname = "root";
    $dbpass = "";

    try
    {
        $dbcon = new PDO($dbhost, $dbname,$dbpass);

    }
    catch(PDOException $err)
    {
        echo"Something went wrong  ".$err->getMessage();
    }

    return $dbcon;
}
?>