<?php
$imageID = $_GET['id'];//获取所在照片的id
$conn = new mysqli('localhost','Elaine','IamElaineee','travel');
$sql = "";
if(preg_match("/^[\w\.]*[^-~]*[\@][\w\.]*[^-~]*$/","$_COOKIE[username]")){
    $sql = "SELECT * FROM traveluser where Email = '$_COOKIE[username]'";
}
else{
    $sql = "SELECT * FROM traveluser where UserName = '$_COOKIE[username]'";
}
$result = $conn->query($sql);
$row = $result->fetch_row();
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
else if(!isset($_COOKIE['username'])){
    echo '<script>window.location="favorites.php";</script>';
    echo "<script>alert('Login timeout.');</script>";
}
else{
    $sql = "delete from travelimagefavor where ImageID = $imageID and UID = $row[0]";
    $result=$conn->query($sql);
    if(!$result){//insert或者delete的结果集为boolean
        echo'<script>alert("Image not found.");</script>';
    }
    else{
        echo '<script>alert("Deletion completed.");</script>';
        echo '<script>window.location="favorites.php";</script>';
    }
}
$conn->close();
