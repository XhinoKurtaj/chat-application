<?php
include ("logController.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
<div class="wrapper">
    <h2>Reset Password</h2>
    <form action="logController.php" method="post">

         <div class="form-group ">
            <label>Name</label>
            <input type="text" name="new_name" value="<?php echo ($_SESSION["userName"]) ?>" class="form-control" >
        </div>

        <div class="form-group">
            <label>Surname</label>
            <input type="text" name="new_surname" value="<?php echo ($_SESSION["userSurname"])?>" class="form-control" ">
        </div>

        <div class="form-group ">
            <label>Email</label>
            <input type="email" name="new_email" value="<?php echo ($_SESSION["userEmail"]) ?>" class="form-control" >
        </div>

        <div class="form-group <?php echo (!empty($newPasswordErr)) ? 'has-error' : ''; ?>">
            <label>New Password</label>
            <input type="password" name="new_password" class="form-control" value="<?php echo $newPasswordErr; ?>">
            <span class="help-block"><?php echo $newPasswordErr; ?></span>
        </div>

         <div class="form-group <?php echo (!empty($confirmPasswordErr)) ? 'has-error' : ''; ?>">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control">
            <span class="help-block"><?php echo $confirmPasswordErr; ?></span>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="xs" value="Submit">
            <a class="btn btn-link" href="chatBoard.php">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>
