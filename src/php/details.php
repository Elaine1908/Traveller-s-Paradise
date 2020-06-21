<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Details</title>
    <link href="../css/reset.css" rel="stylesheet" type="text/css" >
    <link href="../css/details.css" rel="stylesheet" type="text/css" >
    <link href="../css/nav.css" rel="stylesheet" type="text/css" >
    <link rel="stylesheet" href="../../font-awesome-4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function(){
            $.ajax({
                type:'POST',
                url:'myAccount.php',
                async: false,
                success:function (data) {
                    $('#myAccount').html(data);
                }
            })
        });
    </script>
</head>
<body>

<div id="nav">
    <div class="div-left">
        <ul>
            <li><a href="index.php" id="home">Home</a></li>
            <li><a href="Browser.php" id="browser">Browse</a></li>
            <li><a href="Search.html" id="search">Search</a></li>
            <li id="myAccount"></li>
        </ul>
    </div>
</div>


<div class="details">DETAILS OF THE PIC <i class="fa fa-image fa-fw" aria-hidden="true"></i></div>

<?php
$imageID = $_GET['id'];//获取所在照片的id
$conn = new mysqli('localhost','Elaine','IamElaineee','travel');
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
else {
    $sql0 = "";

    $sql1 = "select max(ImageID) from travelimage";
    $result1 = $conn->query($sql1);
    $row1 = $result1->fetch_row();//获取当前最大id值

    $sql = "select ImageID from travelimagefavor";
    $result = $conn->query($sql);
    $fav = [];//存储每个imageID出现的次数
    for ($i = 0; $i <= $row1[0]; $i++) {
        $fav[$i] = 0;
    }
    $row = $result->fetch_row();
    while ($row = $result->fetch_row()) {
        $fav[$row[0] - 1] += 1;
    }

    $sql2 = "select PATH,Content,Description,Title from travelimage where ImageID = '$imageID'";
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_row();
    if ($row2[2] == NULL) {
        $row2[2] = 'It has not got any description yet.';
    }

    $sql3 = "select Country_RegionName from geocountries_regions JOIN travelimage on geocountries_regions.ISO = travelimage.Country_RegionCodeISO where ImageID = '$imageID'";
    $result3 = $conn->query($sql3);
    if ($result3->num_rows > 0) {
        $row3 = $result3->fetch_assoc();
        if ($row3 == NULL) {
            $country = "unknown";
        } else {
            $country = $row3['Country_RegionName'];
        }
    } else {
        $country = "unknown";
    }


    $sql4 = "select AsciiName from geocities JOIN travelimage on geocities.GeoNameID = travelimage.CityCode where ImageID = '$imageID'";
    $result4 = $conn->query($sql4);
    if ($result4->num_rows > 0) {
        $row4 = $result4->fetch_assoc();
        if ($row4 == NULL) {
            $city = "unknown";
        } else {
            $city = $row4['AsciiName'];
        }
    } else {
        $city = "unknown";
    }

    echo "<div class=\"left\">
<img src=\"../../travel-images/large/" . $row2[0] . "\" alt=\"image\">
<div class=\"pic\">" . $row2[3] . "<span class=\"photogragher\">  by Christopher</span></div>
</div>


<div class=\"right\">
    <table class=\"more\">
        <tr class=\"th\"><th>About the pic</th></tr>
        <tr><td>Content :" . $row2[1] . "</td></tr>
        <tr><td>Country : " . "$country" . "</td></tr>
        <tr><td>City : " . "$city" . "</td></tr>
        <tr><td>Description : " . $row2[2] . "</td></tr>
    </table>

    <table class=\"more\">
        <tr class=\"th\"><th>Like Number</th></tr>
        <tr><td class=\"num\">" . $fav[$imageID - 1] . "</td></tr>
    </table>";



    if (!isset($_COOKIE['username'])) {
        echo "<button onclick=\"alert('Please login first.')\"><i class=\"fa fa-heart fa-fw\" aria-hidden=\"true\"></i>  I LIKE IT!</button>";
    } else{
        if (preg_match("/^[\w\.]*[^-~]*[\@][\w\.]*[^-~]*$/", "$_COOKIE[username]")) {
            $sql0 = "select * from traveluser JOIN travelimagefavor on traveluser.UID = travelimagefavor.UID where ImageID = '$imageID' and traveluser.Email = '$_COOKIE[username]'";
        } else {
            $sql0 = "select * from traveluser JOIN travelimagefavor on traveluser.UID = travelimagefavor.UID where ImageID = '$imageID' and traveluser.UserName = '$_COOKIE[username]' ";
        }

        $result0 = $conn->query($sql0);//用户和收藏的图片都是多对多的关系

        if ($result0->num_rows>0) {
        echo "<button onclick=\"alert('already liked.')\"><i class=\"fa fa-heart fa-fw\" aria-hidden=\"true\"></i>  LIKED </button>";
    } else {
        echo "<button onclick=window.location.href=\"like.php?id=" . $imageID . "\"><i class=\"fa fa-heart fa-fw\" aria-hidden=\"true\"></i>  I LIKE IT!</button>";
    }
}echo "</div>";
}
?>


<footer><span class="copyright">Copyright © 2020 Elaine1908 All Right Reserved ICP:19302010075</span></footer>
</body>
</html>