<?php
$x = $_GET["convId"];
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'dbcon.php';
include_once 'Messages.php';


$dbConn = connectToDb();


$message = new Messages(" ",$x," ","","");

$stmt = $message->readMessages($x);
$num = $stmt->rowCount();

if($num>0){
    $messageArray = array();
    $messageArray["records"]= array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $messageID = $row['message_id'];
        $conversationId = $row["conversation_id"];
        $msgContent = $row["content"];
        $msgAttachmnet = $row["attachment"];
        $msgSender = $row["sender"];

        $messageItem = array(
          "message_id" => $messageID,
          "conversation_id" => $conversationId,
          "content" => $msgContent,
          "attachment" => $msgAttachmnet,
          "sender" => $msgSender
        );
        array_push($messageArray["records"], $messageItem);
    }
    http_response_code(200);
    echo json_encode($messageArray);
}else{

    http_response_code(404);

    echo json_encode(
        array("message" => "No messages found.")
    );
}

?>
