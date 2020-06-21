<?php
require_once("config.php");
$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
$sql = "";
//正则表达式判断用户为邮箱登录还是用户名登陆
if(preg_match("/^[\w\.]*[^-~]*[\@][\w\.]*[^-~]*$/","$_COOKIE[username]")){
    $sql = "SELECT travelimage.ImageID, travelimage.PATH, travelimage.Title, travelimage.Description  
FROM travelimage INNER JOIN traveluser ON travelimage.UID=traveluser.UID WHERE traveluser.Email = '$_COOKIE[username]'";
}
else{
    $sql = "SELECT travelimage.ImageID, travelimage.PATH, travelimage.Title, travelimage.Description  
FROM travelimage INNER JOIN traveluser ON travelimage.UID=traveluser.UID WHERE traveluser.UserName = '$_COOKIE[username]'";
}

$result = $pdo->query($sql);
$pictures = array();
$titles = array();
$descriptions = array();
$imageID = array();

if($result->rowCount()>0){

    while($row = $result->fetch()) {
    array_push($pictures, $row['PATH']);
    array_push($titles, $row['Title']);
    array_push($descriptions, $row['Description']);
    array_push($imageID,$row['ImageID']);
}

function myPhoto($pictures, $titles, $descriptions,$imageID)
{
    for ($i = 0; $i < count($titles); $i++) {
        if($descriptions[$i]==""){$descriptions[$i]="There's no description yet...";}
        if($titles[$i]==""){$titles[$i]="wonderland";}
        echo '<div class="box">
    <a href="details.php?id='.$imageID[$i].'"><img src="../../travel-images/large/'.$pictures[$i].'." alt="image"></a>
    <div class="words">
        <h4>'.$titles[$i].'</h4>
        <p>'.$descriptions[$i].'</p>
    </div>
    <a href="upload.php?id='.$imageID[$i].'"><button class="modify">MODIFY</button></a><a href="deleteMy.php?id='.$imageID[$i].'"><button class="delete">DELETE</button></a>
</div>';
    }
}
myPhoto($pictures, $titles, $descriptions,$imageID);}
else{{echo '<div class="feedback">You haven’t uploaded any pictures. Click "upload" to add one!</div>';}}
$pdo = null;

