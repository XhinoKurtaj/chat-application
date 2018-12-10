<?php
if (! function_exists('connectToDb')) {

    include("dbcon.php");
}
include_once("Users.php");



$userSession = $_SESSION["userId"];
$list = Conversations::getConversationByUser($userSession);

$name = $photo = "";
$nameErr = "";

if(isset($_GET["submit"]))
{
    if(empty($_GET["convName"]))
    {
        $nameErr = "Please enter a name to your conversation";
    }else{
        $name = $_GET["convName"];
    }
    $photo = $_GET["convPhoto"];
    Conversations::createConversationByUserId($name, $photo);
    header("location:ConversationLists.php");
}

if(!empty($_POST["deleteConversation"]))
{
    $conversationName = $_POST["getName"];
    $conversationId = Conversations::getConversationIdByName($conversationName);
    Conversations::deleteConversationById($conversationId);
    header("location:ConversationLists.php");
}

    if (isset($_POST["open_conv"]))
    {
        $conversationId = $_POST["ConversationID"];
        header("location:chatBoard.php?cId=".$conversationId);
    }




class Conversations{

    var $conversationId;
    var $customName;
    var $customPhoto;
    var $createdAt;
    var $lastMsg;


    function  __construct($cId, $cName, $cPhoto, $cAt, $lMsg)
    {
        $this->conversationId = $cId;
        $this->customName = $cName;
        $this->customPhoto = $cPhoto;
        $this->createdAt = $cAt;
        $this->lastMsg = $lMsg;
    }

    public static function getConversationByUser($userId)
    {
        $dbConn = connectToDb();
        $listConv = [];
        $sql = "SELECT * FROM v_conversations WHERE user_id=:user";
        $sqlQuery = $dbConn->prepare($sql);
        $sqlQuery->bindParam(":user",$userId, PDO::PARAM_STR);
        $sqlQuery->execute();
        while($row = $sqlQuery->fetch())
        {
            $con = new Conversations($row["conversation_id"], $row["custom_name"], $row["custom_photo"], $row["created_at"], $row["message"]);
            $listConv[] = $con;
        }
        unset($sqlQuery);
        unset($dbConn);

        return $listConv;
    }

    public static function createConversationByUserId($name, $img)
    {
        $dbConn = connectToDb();
        $sql = "INSERT INTO conversations (custom_name, custom_photo) VALUES (:name, :img)";
        $sqlQuery = $dbConn->prepare($sql);
        $sqlQuery->bindParam(":name", $name, PDO::PARAM_STR);
        $sqlQuery->bindParam(":img", $img, PDO::PARAM_STR);
        $sqlQuery->execute();
        $lastConv = $dbConn->lastInsertId(); //PDO::rowCount

        $sql2 = "INSERT INTO conusr(conversation_id, user_id) VALUES (:cid, :uid)";
        $sqlQuery2 = $dbConn->prepare($sql2);
        $sqlQuery2->bindParam(":cid", $lastConv, PDO::PARAM_STR);
        $sqlQuery2->bindParam(":uid", $paramId, PDO::PARAM_STR);
        $paramId = $_SESSION["userId"];
        $sqlQuery2->execute();

        unset($sqlQuery);
        unset($dbConn);
    }

    public static function getConversationIdByName($name)
    {
        $dbConn = connectToDb();
        $sql = "SELECT conversation_id FROM conversations WHERE custom_name =:name ";
        $sqlQuery = $dbConn->prepare($sql);
        $sqlQuery->bindParam(":name", $name, PDO::PARAM_STR);
        $sqlQuery->execute();
        $row = $sqlQuery->fetch();
        $conversationId = $row[0];

        unset($sqlQuery);
        unset($dbConn);
        return $conversationId;
    }

    public static function deleteConversationById($convId)
    {
        $dbConn = connectToDb();
        $sql = "DELETE FROM conusr WHERE conversation_id=:id";
        $sqlQuery = $dbConn->prepare($sql);
        $sqlQuery->bindParam(":id",$convId, PDO::PARAM_INT);
        $sqlQuery->execute();

        $sqlConv = "DELETE FROM conversations WHERE conversation_id =:convId";
        $sqlQueryConv = $dbConn->prepare($sqlConv);
        $sqlQueryConv->bindParam(":convId",$convId, PDO::PARAM_INT);
        $sqlQueryConv->execute();

        unset($sqlQuery);
        unset($sqlQueryConv);
        unset($dbConn);
    }

    public static function conversationMemebers($conId)
    { 
        $ulist=[];
        $dbConn = connectToDb();
        $userId = [];
        $sql = "SELECT user_id FROM conusr WHERE conversation_id=:cID";
        $sqlQuery= $dbConn->prepare($sql);
        $sqlQuery->bindParam("cID",$conId,PDO::PARAM_INT);
        $sqlQuery->execute();
        while($row = $sqlQuery->fetch())
        {
            $userId[] = $row[0];
        }
        $join = implode(',', $userId);
        $ids='WHERE user_id in ('.$join.')';
        $sqlUsr = "SELECT name ,surname FROM users ".$ids;
        $sqlQueryUsr= $dbConn->prepare($sqlUsr);
        $sqlQueryUsr->execute();
        while($row = $sqlQueryUsr->fetch())
        {         
         $us=new Users($row['name'], $row['surname'], '', '');
         $ulist[]=$us;
        }
        return  $ulist;
    }

}


?>
