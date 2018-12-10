<?php
include("Photos.php");
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>

        body{
            background-color: #474e5d;
        }
        .wrapp{
            margin-top: 10px;
        }
        .frame{
            margin-top: 15px;
            /*margin-right: 15px;*/
            margin-left: 25px;
            border-width: 3px;
            border-style:inset;
        }
        #photo_pic{
            width:90%;
            margin-top: 10px;
            padding: 5px 0px 0px 5px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="container-fluid wrapp">
        <div class="row">
            <div class="col-1"> <a href="conversationLists.php" class="btn btn-success btn-sm">Go Back </a></div>
            <div class="col-4"></div>
            <div class="col-4 ">
                <form action="<?php $_SERVER["PHP_SELF"]?>" method="POST" enctype="multipart/form-data">
                    <div class="input-group">
                            <input type="file" class= "btn btn-sm btn-primary" name="photoPic" value="test.jpg" accept=".jpg, .jpeg, .png">
                        <div class="input-group-append">
                            <input type="submit" class="btn btn-outline-info" id="inputGroupFileAddon04" name="addToDb" value="Upload">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
            <?php
            $userSession = $_SESSION["userId"];
            $photoList = Photos::getPhotoByUserId($userSession);
            if(empty($photoList))
            {
                echo "<div class='container'><div class='row'><div class='col-3'></div><div class='col-6' style= 'margin-top: 100px'>";
                echo "<h5> You dont have any photo</h5>";
                echo "</div><div class='col-3'></div></div></div>";
            }else{
                foreach($photoList as $el)
                {
                    echo "<div class='col-4 col-md-2 frame'>";
                    echo "<img src='images/$el->userPhoto' id='photo_pic' alt='Card image cap'>";
                    echo "<p>";
                    echo "<small class='text-muted'>";
                    echo "$el->addedDate";
                    echo "</small></p>";
                    echo "<form action='' method='GET'>";
                    echo "<input type='text' value='$el->userPhoto' name='photoName' style='visibility:hidden'>";
                    echo "<input type='submit' class='btn btn-sm btn-outline-info' name='profilePhoto' value='Set as photo profile'>&nbsp&nbsp";
                    echo "<input type='submit' class='btn btn-sm btn-outline-danger '  name='deletePhoto' value='Delete'>";
                    echo "</form>";
                    echo "</div>";
                }
            }
            ?>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
</body>
</html>

