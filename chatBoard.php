<?php
session_start();
include("Messages.php");
$convId  = $_GET['cId'];

?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/chatBorderStyle.css">
</head>
<body>
<input type="hidden" value='<?php echo "$convId" ?>' id='converastionId'/>
<div class="container-fluid">
    <div class="row no-gutters">
        <div class="col-6 col-md-4">
            <div class="container">
                <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                    <div class="container center">
                        <img src="<?php ?>" alt="Avatar" id="photo_pic">
                        <h5 id="username"><?php echo ($_SESSION["userName"]." ".$_SESSION["userSurname"]); ?></h5>
                        <div class="btn-group dropright ">
                            <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="btnSettings">
                                Settings
                            </button>
                            <div class="dropdown-menu">
                                <a href="Logout.php" class="dropdown-item onMouse">Sign Out</a>
                                <a href="UpdateData.php" class="dropdown-item onMouse">Update User Data</a>
                                <a href="PhotoBoard.php" class="dropdown-item onMouse">Choose a photo</a>
                                <a href="ConversationLists.php" class="dropdown-item onMouse">Leave Conversation</a>
                                <hr>
                                <a href="" class="dropdown-item btn" id="deleteUser">Delete User</a>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="text" name="addMemberName" id="addMemberName" placeholder="Name">
                <input type="text" name="addMemberSurname" id="addMemberSurname" placeholder="Surname">
                <button class="btn btn-outline-success" name="addButton" id="addButton">Add</button>
                <table class="table table-dark">
                    <thead>
                    <th>Conversation members</th>
                    <tr>
                        <th scope="col">name</th>
                        <th scope="col">Surname</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    include("Chats.php");
                    $test = Conversations::conversationMemebers($convId);
                    foreach($test as $el)
                    {
                        echo "<tr>";
                        echo "<td>";
                        echo $el->name."</td>";
                        echo "<td>";
                        echo $el->surname."</td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-8">
            <div class="card">
                <div class="card-body" style="overflow: auto" id="textResponse">
                    <div>
                        <p id="msgField"></p>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="container">

                    <div class="input-group">
                        <textarea class="form-control" aria-label="With textarea" id="msgArea" name="message"></textarea>
                        <div class="input-group-prepend">
                            <span class="input-group-text"><button type="button" id="btn_send" class="btn-lg btn-success">Send</button></span>
                        </div>
                    </div>
                    <div class="container">
                        <label for="profile_pic">Choose file to upload</label>
                        <input type="file" class="btn btn-sm " id="attach" name="att">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="convId" value="<?php echo $convId ?>">
<input type="hidden" id="sessionName" value="<?php echo($_SESSION["userName"].": ") ?>">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script>

    $("#btn_send").click(function(){
        var conversationId = $("#converastionId").val();
        var msgArea = $("#msgArea").val();
        var attach = $("#attach").val();
        $.ajax({
            type:"POST",
            url:"Messages.php",
            data:{action:"send",
                convid:conversationId,
                message:msgArea,
                attachmnet:attach
            },
            success:function(data){
                console.log(data);
            },
            error:function(err){
                console.log(err);
            }
        })
    });
</script>
<script>
    $("#addButton").click(function(){
        var conversationId = $("#converastionId").val();
        var addMemeberName = $("#addMemberName").val();
        var addMemberSurname = $("#addMemberSurname").val();
        $.ajax({
            type:"POST",
            url:"Messages.php",
            data:{
                action:"send",
                cId:conversationId,
                memberName:addMemeberName,
                memberSurname:addMemberSurname
            },
            success:function(data){
                console.log(data);
            },
            error:function(err){
                console.log(err);
            }
        })
    });

    function getRealData() {
        var display = $("#msgField");
         var id = $("#convId").val();
        console.log(id);
            $.ajax({
                method:"POST",
                url:"Read.php?convId="+id,
                success:function(result){
                    var output = "";
                    for(var i in result.records){
                       output += "<h6><strong>"+result.records[i].sender +": "+"</strong></h6>"+
                               "<p>"+result.records[i].content+"</p> <br>";
                    }
                    display.html(output);
                }
            })
    }
    $('document').ready(function () {
        setInterval(function () {getRealData()}, 5000);

    });

    // $("#btn_send").click(function(){
    //     var messageContent = $("#msgArea").val();
    //     var sender = $("#sessionName").val();
    //     $("#test").append(sender+"<br>"+ messageContent);
    //
    // })

    $("#btn_send").click(function(){
        $("#msgArea").val("");
    })

</script>
</body>
</html>
