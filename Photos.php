<?php
if (! function_exists('connectToDb')) {

    include("dbcon.php");
}

session_start();
$statusMsg="";

$targetDir = "images/";
$fileName = $_FILES['photoPic']['name'];
$targetFilePath = $targetDir.$fileName;
$fileType=pathinfo($targetFilePath,PATHINFO_EXTENSION);


if(isset($_POST["addToDb"]) && !empty($_FILES['photoPic']['name']))
{
    move_uploaded_file($_FILES["photoPic"]["tmp_name"], $targetFilePath);

    $insert = Photos::setPhotoByFileName($fileName);
    header("location:PhotoBoard.php");
    if($insert)
    {
        $statusMsg = "The file ".$fileName. " has been uploaded successfully.";
    }else{
        $statusMsg = "File upload failed, please try again.";
    }
}
echo $statusMsg;


if(!empty($_GET["deletePhoto"]))
{
    $photoName = $_GET["photoName"];
    $photoID = Photos::getPhotoIdByName($photoName);
    $success = Photos::deletePhotoById($photoID);
    header("location:PhotoBoard.php");
}




class Photos
{
    var $photoId;
    var $userId;
    var $addedDate;
    var $userPhoto;

    function __construct($pId, $uId, $aDate, $pH)
    {
        $this->photoId = $pId;
        $this->userId = $uId;
        $this->addedDate = $aDate;
        $this->userPhoto = $pH;
    }

    public  function setPhotoByFileName($photo)
    {
        $dbConn = connectToDb();
        $sql = "INSERT INTO photos (photo, user_id) VALUES (:photo, :id)";

        $sqlQuery = $dbConn->prepare($sql);
        $sqlQuery->bindParam(":photo", $photo,PDO::PARAM_STR);
        $sqlQuery->bindParam(":id", $paramID,PDO::PARAM_INT);

        $paramID = $_SESSION["userId"];
        $sqlQuery->execute();

        unset($sqlQuery);
        unset($dbConn);

    }

    public static function getPhotoByUserId($userId)
    {
        $dbConn = connectToDb();
        $profPhoto =[];
        $sql = "SELECT * FROM  v_photo_user AS v WHERE v.user_id =:user";
        $sqlQuery = $dbConn->prepare($sql);
        $sqlQuery->bindParam(":user",$userId, PDO::PARAM_INT);
        $sqlQuery->execute();

        while($row = $sqlQuery->fetch())
        {
            $existedPhotos = new Photos($row["id"], $row["user_id"],$row["added_date"],$row["photo"]);
            $profPhoto[] = $existedPhotos ;
        }
        unset($sqlQuery);
        unset($dbConn);
        return $profPhoto;

    }


    public static function  getPhotoIdByName($name)
    {
        $dbConn = connectToDb();
        $sql = "SELECT id FROM photos WHERE photo =:photo";
        $sqlQuery = $dbConn->prepare($sql);
        $sqlQuery->bindParam(":photo",$name, PDO::PARAM_STR);
        $sqlQuery->execute();
        $row = $sqlQuery->fetch();
        $photoId = $row[0];

        unset($sqlQuery);
        unset($dbConn);
        return $photoId;
    }

    public static function deletePhotoById($photoId)
    {
        $dbConn = connectToDb();
        $sql = "DELETE FROM photos WHERE id=:id";
        $sqlQuery = $dbConn->prepare($sql);
        $sqlQuery->bindParam(":id",$photoId,PDO::PARAM_INT);
        $sqlQuery->execute();

        unset($sqlQuery);
        unset($dbConn);
    }

//    public static function setPhotoProfile($photo)
//    {
//        $dbConn = connectToDb();
//        $sql = "INSERT INTO users(photo) VALUES (:photo)";
//        $sqlQuery = $dbConn->prepare($sql);
//        $sqlQuery->bindParam(":photo",$photo,PDO::PARAM_STR);
//        $sqlQuery->execute();
//        unset($sqlQuery);
//        unset($dbConn);
//    }
}
