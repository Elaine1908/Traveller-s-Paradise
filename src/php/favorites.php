<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My favorite</title>
    <link href="../css/reset.css" rel="stylesheet" type="text/css" >
    <link href="../css/favorites.css" rel="stylesheet" type="text/css" >
    <link href="../css/nav.css" rel="stylesheet" type="text/css" >
    <link rel="stylesheet" href="../../font-awesome-4.7.0/css/font-awesome.min.css">
    <script src="../js/highlight.js"></script>
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

<div class="favor">MY FAVORITE <i class="fa fa-heart fa-fw" aria-hidden="true"></i></div>

<?php
$conn = new mysqli('localhost','Elaine','IamElaineee','travel');
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
$sql = "SELECT * FROM traveluser where UserName = '$_COOKIE[username]' or Email = '$_COOKIE[username]'";
$result = $conn->query($sql);
$row = $result->fetch_row();

$sql2 = "SELECT * FROM travelimagefavor where UID = '$row[0]'";
$result2 = $conn->query($sql2);


if(mysqli_num_rows($result2)){//存在收藏的图片
    while ($row2 = $result2->fetch_row()) {
        $sql3 = "SELECT * FROM travelimage where ImageID = '$row2[2]'";
        $result3 = $conn->query($sql3);
        while ($row3 = $result3->fetch_row()) {
            echo "<div class=\"box\" id=".$row3[1].">
    <a href=\"details.php?id=".$row3[0]."\"><img src=\"../../travel-images/large/".$row3[8]."\" alt=\"img\"></a>
    <div class=\"words\">
        <h4>".$row3[1]."</h4>
        <p>".$row3[2]."</p>
    </div>
    <a href=\"deleteFav.php?id=".$row3[0]."\"><button >DELETE</button></a>
</div>
";
        }
    }
}

else{
    echo "<div class=\"feedback\">You haven't collected any photos yet. Go and pick what you like!</div>";
}
?>



<footer><span class="copyright">Copyright © 2020 Elaine1908 All Right Reserved ICP:19302010075</span></footer>
</body>
</html>
