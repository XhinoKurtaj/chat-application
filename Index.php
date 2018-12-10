<?php
include("logController.php");

?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <style>
        .alert{
            color:orangered;
        }
    </style>
</head>
<body>

<div class="container" id="mover">
    <div class="card">
        <div class="card-body">
            <div class="container" id="bColor">
                <div class="row">
                    <div class="col"></div>
                    <div class="col">
                        <h2>H.r.uChat</h2>
                        <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Sign Up</button>
                        <button onclick="document.getElementById('login').style.display='block'" style="width:auto;">Sign In</button>
                    </div>
                    <div class="col"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="id01" class="modal">
    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
    <form class="modal-content" action="Index.php" method="POST">
        <div class="container">
            <h1>Sign Up</h1>
            <p>Please fill in this form to create an account.</p>
            <hr>
            <label for="lableName" class="lable">Name</label>
            <input type="text" class="form-control" name="name" id="lableName" placeholder="Name">
            <span class="help-block"><?php echo $nameErr; ?></span><br>

            <label for="lableSurname" >Surname</label>
            <input type="text" class="form-control" name="surname" id="lableSurname" placeholder="surname">
            <span class="help-block"><?php echo $surnameErr; ?></span><br>

            <label for="lableEmail" class="lable">Email</label>
            <input type="email" class="form-control" name="email" id="lableEmail" placeholder="Email">
            <span class="help-block"><?php echo $emailErr; ?></span><br>

            <label for="lablePass" >Password</label>
            <input class="form-control" type="password" name="pass" id="lablePass" placeholder="Password">
            <span class="help-block"><?php echo $passwordErr; ?></span><br>

            <label for="lablePassVerify" >Confirm Password</label>
            <input class="form-control" type="password" name="passVerify" id="lablePassVerify" placeholder="Verify Password">
            <span class="help-block"><?php echo $passwordVerifyErr; ?></span><br>

            <div class="clearfix">
                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                <button type="submit" class="signupbtn">Sign Up</button>
            </div>
        </div>
    </form>
</div>

<div id="login" class="modal">
    <span onclick="document.getElementById('login').style.display='none'" class="close" title="Close Modal">&times;</span>
    <form class="modal-content" action="Index.php" method="POST">
        <div class="container">
            <h1>Sign In</h1>
            <hr>

            <label for="lableEmail" class="lable">Email</label>
            <input type="email" class="form-control" name="logEmail" id="lableEmail" placeholder="Email">
            <span class="help-block alert"><?php echo $emailErr; ?></span><br><br>

            <label for="lablePass" >Password</label>
            <input class="form-control" type="password" name="logPass" id="lablePass" placeholder="Password">
            <span class="help-block alert"><?php echo $passwordErr; ?></span>

            <div class="clearfix">
                <button type="button" onclick="document.getElementById('login').style.display='none'" class="cancelbtn">Cancel</button>
                <button type="submit" class="signupbtn">Sign In</button>
            </div>
        </div>
    </form>
</div>

<script>
    var modal = document.getElementById('id01');

    window.onclick = function(event)
    {
        if (event.target == modal)
        {
            modal.style.display = "none";
        }
    }
</script>

</body>
</html>


