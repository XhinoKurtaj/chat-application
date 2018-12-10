<?php
if (! function_exists('connectToDb')) {

    include("dbcon.php");
}
class Users 
{
    var $name;
    var $surname;
    var $email;
    var $password;

    function __construct($uN, $uS, $uE, $uP)
    {
        $this->name = $uN;
        $this->surname = $uS;
        $this->email = $uE;
        $this->password = $uP;
    }

    public  function save()
    {
        $dbConn = connectToDb();
        $sql = "INSERT INTO users(name, surname, email, password) VALUES (:name, :surname, :email, :password)";

        if($sqlQuery = $dbConn->prepare($sql))
        {
            $sqlQuery->bindParam(":name", $this->name, PDO::PARAM_STR);
            $sqlQuery->bindParam(":surname", $this->surname, PDO::PARAM_STR);
            $sqlQuery->bindParam(":email", $this->email, PDO::PARAM_STR);
            $sqlQuery->bindParam(":password", $passCrypt, PDO::PARAM_STR);

            $passCrypt = password_hash($this->password, PASSWORD_BCRYPT);

            if($sqlQuery->execute())
            {
                header("location:ConversationLists.php");
            }else{
                echo "Something went wrong";
            }
        }
        unset($sqlQuery);
        unset($dbConn);
    }
    public static function getUser($email, $password,$passwordErr,$emailErr)
    {
        $dbConn = connectToDb();
        $sql = "SELECT user_id,email,password,name,surname  FROM users WHERE email=:email";

        if($sqlQuery = $dbConn->prepare($sql))
        {
            $sqlQuery->bindParam(":email", $email, PDO::PARAM_STR);
            if($sqlQuery->execute())
            {
                if($sqlQuery->rowCount() == 1 )
                {
                    if($row = $sqlQuery->fetch())
                    {
                        $id = $row["user_id"];
                        $name = $row["name"];
                        $surname = $row["surname"];
                        $email = $row["email"];
                        $hashed_password = $row["password"];

                        if(password_verify($password,$hashed_password))
                        {
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["userId"] = $id;
                            $_SESSION["userEmail"] = $email;
                            $_SESSION["userName"] = $name;
                            $_SESSION["userSurname"] = $surname;

                            header("location:ConversationLists.php");
                        }else{
                            $passwordErr = "Password u entered was not valid";
                        }
                    }
                }else{
                    $emailErr = "We didnt find any user with that email";
                }
            }
            echo "Something Went Wrong !!";
        }
        unset($sqlQuery);
        unset($dbConn);
    }


    public  function updateUsersData()
    {
   
       $dbConn = connectToDb();
       $sql = "UPDATE users SET name=:name, surname=:surname, email=:email, password=:password WHERE user_id=:id";
       $sqlQuery = $dbConn->prepare($sql);
       $sqlQuery->bindParam(":name",$this->name, PDO::PARAM_STR);
       $sqlQuery->bindParam(":surname", $this->surname, PDO::PARAM_STR);
       $sqlQuery->bindParam(":email",$this->email,PDO::PARAM_STR);
       $sqlQuery->bindParam(":password", $passCrypt, PDO::PARAM_STR);
       $sqlQuery->bindParam(":id", $sessionUser,PDO::PARAM_INT);
       $passCrypt = password_hash($this->password, PASSWORD_BCRYPT);
       $sessionUser = $_SESSION["userId"];

       $sqlQuery->execute();

       unset($sqlQuery);
       unset($dbConn);

    }


}

