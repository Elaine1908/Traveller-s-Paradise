<?php

$conn = new mysqli('localhost','Elaine','IamElaineee','travel');
$content = isset($_POST['content'])? htmlspecialchars($_POST['content']) : '';//获取下拉菜单
$country = isset($_POST['country'])? htmlspecialchars($_POST['country']) : '';
$city = isset($_POST['city'])? htmlspecialchars($_POST['city']) : '';
//$city=$_POST['city'];


$title = $_POST['title'];
$description = $_POST['description'];
$path = $_POST['upload'];
if(!$country || !$city){
    echo '<script>alert("You haven‘t selected a country or city.");history.go(-1);</script>';
}//下拉菜单未选中
else {
    $sql = "select max(ImageID) from travelimage";
    $result = $conn->query($sql);
    $row = $result->fetch_row();//获取当前最大id值
    $imageID = $row[0] + 1;//ImageID

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

    $sql4 = "select * from geocities join geocountries_regions on geocountries_regions.ISO=geocities.Country_RegionCodeISO where AsciiName = '$city' and Country_RegionName = '$country'";
    $result4 = $conn->query($sql3);
    $row4 = $result4->fetch_row();
    $cityCode = $row4[0];
    echo '<script>alert('.$cityCode.');</script>';
}

   $sql_insert = "INSERT INTO travelimage (ImageID,Title,Description,CityCode,Country_RegionCodeISO,UID,PATH,Content) VALUES ('$imageID', '$title', '$description', '$cityCode', '$countryISO', '$UID', '$path', '$content')";
    $res_insert = $conn->query($sql_insert);

    if ($res_insert) {
        echo '<script>alert('.$city.');</script>';
        echo '<script>window.location="photo.html";</script>';
    } else {
        echo "<script>alert('Insert unsuccessful.');</script>";
    }




