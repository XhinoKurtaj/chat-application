<?php
session_start();
include("Users.php");

//Register System
$name = $surname = $email = $password = $confirmPass = "";
$nameErr = $surnameErr = $emailErr = $passwordErr = $passwordVerifyErr = "";

if($_SERVER["REQUEST_METHOD"]=="POST")
{
    if (empty($_POST["name"])) {
        $nameErr = "Please enter a name";
    } else {
        $name = $_POST["name"];
    }

    if (empty($_POST["pass"])) {
        $passwordErr = "Please enter your password";
    } elseif (strlen($_POST["pass"]) < 6) {
        $passwordErr = "Your password should contain atleast 6 characters";
    } else {
        $password = $_POST["pass"];
    }

    if (empty($_POST["passVerify"])) {
        $passwordVerifyErr = "Please confirm your password";
    } else {
        $confirmPass = $_POST["passVerify"];
        if (empty($password) || ($password != $confirmPass)) {
            $passwordVerifyErr = "Password did not match";
        }
    }

    if (empty($_POST["surname"])) {
        $surnameErr = "Please enter a surname";
    } else {
        $surname = $_POST["surname"];
    }

    if (empty($_POST["email"])) {
        $emailErr = "Please enter your email";
    } else {
        $email = $_POST["email"];
    }

    if(empty($nameErr) && empty($surnameErr) && empty($emailErr) && empty($passwordErr) && empty($passwordVerifyErr))
    {
        $user=new Users($name,$surname,$email,$password);
        $user->save();

    }
}

 $newName = $newSurname = $newEmail = $newPassword = $confirmNewPassword = "";
 $newPasswordErr = $confirmNewPasswordErr = "";

 if($_SERVER["REQUEST_METHOD"] == "POST")
 {
     if(!empty($_POST["new_name"]))
     {
         $newName = $_POST["new_name"];
     }

     if(!empty($_POST["new_surname"]))
     {
         $newSurname = $_POST["new_surname"];
     }

     if(!empty($_POST["new_email"]))
     {
         $newEmail = $_POST["new_email"];
     }

     if(empty($_POST["new_password"]))
     {
         $newPasswordErr = "Please enter the new password.";
     } elseif(strlen($_POST["new_password"]) < 6)
     {
         $newPasswordErr = "Password must have atleast 6 characters.";
     } else{
         $newPassword = $_POST["new_password"];
     }

     if(empty($_POST["confirm_password"]))
     {
         $confirmNewPasswordErr = "Please confirm the password.";
     } else{
         $confirmNewPassword = $_POST["confirm_password"];
         if(empty($newPassword) || ($newPassword != $confirmNewPassword))
         {
             $confirmNewPasswordErr = "Password did not match.";
         }
     }
     if(empty($newPasswordErr) && empty($confirmNewPasswordErr))
     {
//         $id = $_SESSION["userId"] ;
//         $email = $_SESSION["userEmail"];
//         $name = $_SESSION["userName"];
//         $surname = $_SESSION["userSurname"] ;
         $x = new Users($newName,$newSurname,$newEmail,$newPassword);
         $x->updateUsersData();
         header("location:ConversationLists.php");

     }

 }


//Login System

$logEmail = $logPassword = "";
$logEmailErr = $logPasswordErr = "";


if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["logEmail"]))
    {
        $logEmailErr = "Please enter your email";
    } else {
        $logEmail = $_POST["logEmail"];
    }

    if (empty($_POST["logPass"]))
    {
        $logPasswordErr = "Please enter your password";
    } else {
        $logPassword = $_POST["logPass"];
    }

    if(empty($logEmailErr) && empty($logPasswordErr))
    {
        Users::getUser($logEmail, $logPassword, $logEmailErr, $logPasswordErr);
    }
}

// Update user




//DELETE USERS

//function deleteUser()
//{
//    $x = $_SESSION["userId"];
//    Users::deleteUserById($x);
//}

?>
