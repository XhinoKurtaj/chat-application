<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true)
{
    header("location: Index.php");
    exit;
}
include_once("Chats.php");

?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/ConvStyle.css">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-6 col-md-4">
            <div class="container">
                <div class="card text-white bg-dark mb-3" style="max-width: 30rem;">
                    <div class="container center">
                        <img src="Testing%20Photos/photo-1543872643-f48849879e62.jpg" alt="Avatar" id="photo_pic">
                        <h5 id="username"><?php echo ($_SESSION["userName"]." ".$_SESSION["userSurname"]); ?></h5>
                        <div class="btn-group dropright ">
                            <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="btnSettings">
                                Settings
                            </button>
                            <div class="dropdown-menu">
                                <a href="Logout.php" class="dropdown-item onMouse">Sign Out</a>
                                <a href="UpdateData.php" class="dropdown-item onMouse">Update User Data</a>
                                <a href="PhotoBoard.php" class="dropdown-item onMouse">Choose a photo</a>
                                <hr>
                                <a href="" class="dropdown-item btn" id="deleteUser">Delete User</a>
                            </div>
                        </div>
                    </div><hr><hr>
                    <h3>Create new conversation</h3>
                    <hr>
                    <form action="ConversationLists.php" method="GET">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputEmail3" placeholder="Custom Name" name="convName">
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span  id="inputGroupFileAddon01">Upload photo </span>&nbsp&nbsp
                            </div>
                            <div class="custom-file">
                                <input type="file" name="convPhoto">

                            </div>
                        </div>
                        <br>
                        <input type="submit" name="submit" value="Create Conversation" class="btn btn-sm btn-outline-success">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-8">
            <?php
            if(empty($list))
            {
                echo "You do not have any conversation";
            }else{
            ?>
            <table class="table table-dark">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Last message</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($list as $el)
                  {
                     echo "<tr>"."<th scope='row'>";
                     echo "<form action='ConversationLists.php' method='POST'>";
                     echo "$el->customName";
                     echo "<input type='text' name='getName' value='$el->customName' style='visibility:hidden;' name='conv'>";
                     echo "</p>"."</th>"."<td>";
                     echo "$el->lastMsg";
                     echo "</td>"."<td>";
                     echo "<input type ='submit' class='btn btn-sm btn-outline-success ' name= 'open_conv' value='Join Conversation' > &nbsp &nbsp";
                     echo "<input type='submit' class='btn btn-danger btn-sm' name='deleteConversation' value='Delete'>";
                     echo "<input type='hidden'  name='ConversationID' value='$el->conversationId'>";
                     echo "</form> </td></tr>";

                  }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>




</body>
</html>
