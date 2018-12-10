<?php
if (! function_exists('connectToDb')) {
    include("dbcon.php");
}


//if(isset($_POST['action']) && !empty($_POST['action']) && isset($_POST['convid']) && !empty($_POST['convid'])) {
//    $ConvId=$_POST['convid'];
//    $Content=$_POST["message"];
//    $attachmnets = $_POST["att"];
//    echo "$attachmnets";
//    $send = Messages::SendMessage($ConvId,$Content,$attachmnets);
//}
if(isset($_POST['action']) && !empty($_POST['action']) && isset($_POST['convid']) && !empty($_POST['convid'])) {
    $ConvId=$_POST['convid'];
    $Content=$_POST["message"];
//    $attachmnets = $_POST["att"];

    $targetDir = "attachmnets/";
    $fileName = $_FILES['att']['name'];
    $targetFilePath = $targetDir.$fileName;
    $fileType=pathinfo($targetFilePath,PATHINFO_EXTENSION);
    move_uploaded_file($_FILES["att"]["tmp_name"], $targetFilePath);
    $send = Messages::SendMessage($ConvId, $Content, $fileName);

}


if(isset($_POST['action']) && !empty($_POST['action'])
    && isset($_POST['cId']) && !empty($_POST['cId'])
    && isset($_POST['memberName']) && !empty($_POST['memberName'])
    && isset($_POST['memberSurname']) && !empty($_POST['memberSurname']))
{
    $cId=$_POST['cId'];
    $memberName=$_POST['memberName'];
    $memberSurname=$_POST['memberSurname'];
    $add = Messages::addMemberToConversation($memberName,$memberSurname,$cId);
}
































class Messages
{
    var $messageID;
    var $conversationId;
    var $msgContent;
    var $msgAttachment;
    var $msgSender;


    function Messages($cId)
    {
        $this->conversationId = $cId;
    }

    function __construct($msgID, $convID, $msgC, $msgA, $msgS)
    {
        $this->messageID = $msgID;
        $this->conversationId = $convID;
        $this->msgContent = $msgC;
        $this->msgAttachment = $msgA;
        $this->msgSender = $msgS;
    }


    public static function sendMessage($convid, $content, $attachment)
    {
        session_start();
        $dbConn = connectToDb();
        $sql = "INSERT INTO messages (conversation_id, content, attachment, sender) VALUES (:cId,:content, :attach, :sender)";

        $sqlQuery = $dbConn->prepare($sql);
        $sqlQuery->bindParam(":cId", $convid, PDO::PARAM_INT);
        $sqlQuery->bindParam(":content", $content, PDO::PARAM_STR);
        $sqlQuery->bindParam(":attach", $attachment, PDO::PARAM_STR);
        $sqlQuery->bindParam(":sender", $sender, PDO::PARAM_STR);
        $sender = $_SESSION["userName"];
        $sqlQuery->execute();

        unset($sqlQuery);
        unset($dbConn);
        return $sender;
    }

    public function readMessages($convId)
    {
        $dbConn = connectToDb();
        $sql = "SELECT * FROM messages WHERE conversation_id=:id";
        $sqlQuery = $dbConn->prepare($sql);
        $sqlQuery->bindParam(":id",$convId,PDO::PARAM_INT);
        $sqlQuery ->execute();

        return $sqlQuery;



    }

    public static function addMemberToConversation($userName,$userSurname, $conId)
    {
        $dbConn = connectToDb();
        $sqlUser="SELECT user_id FROM users WHERE name=:name AND surname=:surname";
        $sqlQueryUser = $dbConn->prepare($sqlUser);
        $sqlQueryUser->bindParam("name",$userName,PDO::PARAM_STR);
        $sqlQueryUser->bindParam("surname",$userSurname,PDO::PARAM_STR);
        $sqlQueryUser->execute();
        $row = $sqlQueryUser->fetch();
        $userId = $row[0];

        $sql = "INSERT INTO conusr (user_id, conversation_id) VALUES (:uId, :cId )";
        $sqlQuery = $dbConn->prepare($sql);
        $sqlQuery->bindParam("uId", $userId, PDO::PARAM_INT);
        $sqlQuery->bindParam("cId", $conId, PDO::PARAM_INT);
        $sqlQuery->execute();
        unset($sqlQuery);
        unset($dbConn);
    }

}
