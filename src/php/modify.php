<?php
$imageID = $_GET['id'];//修改一张图片，imageID不变

$conn = new mysqli('localhost','Elaine','IamElaineee','travel');
$content = isset($_POST['content'])? htmlspecialchars($_POST['content']) : '';//获取下拉菜单
$country = isset($_POST['country'])? htmlspecialchars($_POST['country']) : '';
$city = isset($_POST['city'])? htmlspecialchars($_POST['city']) : '';
$title = $_POST['title'];
$description = $_POST['description'];

if(!$country || !$city){
    echo '<script>alert("You haven‘t selected a country or city.");history.go(-1);</script>';
}//下拉菜单未选中
else {

    $sql2 = "";
    if (preg_match("/^[\w\.]*[^-~]*[\@][\w\.]*[^-~]*$/", "$_COOKIE[username]")) {
        $sql2 = "SELECT * FROM traveluser where Email = '$_COOKIE[username]'";
    } else {
        $sql2 = "SELECT * FROM traveluser where UserName = '$_COOKIE[username]'";
    }
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_row();
    $UID = $row2[0];//UID

    $sql3 = "select ISO from geocountries_regions where Country_RegionName = '$country'";
    $result3 = $conn->query($sql3);
    $row3 = $result3->fetch_row();
    $countryISO = $row3[0];

    $sql4 = "select GeoNameID from geocities where AsciiName = '$city'";
    $result4 = $conn->query($sql3);
    $row4 = $result4->fetch_row();
    $cityCode = $row4[0];

    $sql0 = "select PATH from travelimage where ImageID='$imageID'";
    $result0=$conn->query($sql0);
    $row0=$result0->fetch_row();
    $path=$row0[0];

    if($_POST['upload']==""){
        $sql_update = "UPDATE travelimage SET Title='$title',Description='$description',CityCode='$cityCode',Country_RegionCodeISO='$countryISO',UID='$UID',Content='$content' WHERE ImageID='$imageID'";
        $res_update = $conn->query($sql_update);
    }
    else {
        $path = $_POST['upload'];
        $sql_update = "UPDATE travelimage SET Title='$title',Description='$description',CityCode='$cityCode',Country_RegionCodeISO='$countryISO',UID='$UID',Content='$content',PATH='$path' WHERE ImageID='$imageID'";
        $res_update = $conn->query($sql_update);
    }

    if ($res_update) {
        echo '<script>window.location="photo.html";</script>';
    } else {
        echo "<script>alert('Modify unsuccessful.');</script>";
    }
}







