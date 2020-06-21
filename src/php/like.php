<?php
$imageID = $_GET['id'];//获取所在照片的id
$conn = new mysqli('localhost','Elaine','IamElaineee','travel');
// 检测连接
if ($conn->connect_error) {
    die("Failed connection: " . $conn->connect_error);
}

if (preg_match("/^[\w\.]*[^-~]*[\@][\w\.]*[^-~]*$/", "$_COOKIE[username]")) {
    $sql0 = "select UID from traveluser where Email = '$_COOKIE[username]'";
} else {
    $sql0 = "select UID from traveluser where UserName = '$_COOKIE[username]'";
}

$result0 = $conn->query($sql0);
$row0 = $result0->fetch_row();

$sql = "INSERT INTO travelimagefavor (FavorID, UID, ImageID) VALUES (NULL, '$row0[0]', '$imageID')";
$result=$conn->query($sql);

if(!$result){//insert或者delete的结果集为boolean
    echo'<script>alert("Failed collection.");</script>';
}
else{
    echo '<script>alert("Collected!");</script>';
    echo '<script>window.location="favorites.php";</script>';
}
$conn->close();