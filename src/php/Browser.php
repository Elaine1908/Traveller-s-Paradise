<?php
function show($imageID){
    $conn = new mysqli('localhost','Elaine','IamElaineee','travel');
    $sql = "SELECT PATH from travelimage where ImageID='$imageID'";
    $result = $conn->query($sql);
    $v=$result->fetch_row();
    echo '<a href="details.php?id=' . $imageID . '"><img src="../../travel-images/large/' . $v[0] . '." alt="image"></a>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Browser</title>
    <link href="../css/reset.css" rel="stylesheet" type="text/css" >
    <link href="../css/Browser.css" rel="stylesheet" type="text/css" >
    <link href="../css/nav.css" rel="stylesheet" type="text/css" >
    <link rel="stylesheet" href="../../font-awesome-4.7.0/css/font-awesome.min.css">
    <script src="../js/select.js"></script>
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

<div class="aside">
<form action="Browser.php" method="get" id="form1">
    <ul class="search">
        <li>SEARCH BY TITLE</li>
        <li><input type="text" name="title"><button id="title"><i class="fa fa-search fa-fw" aria-hidden="true"></i></button></li>
    </ul>
</form>

    <table class="hot country">
        <tr class="th"><th>HOT COUNTRY</th></tr>
        <tr><td><a href="Browser.php?country=CA">CANADA</a></td></tr>
        <tr><td><a href="Browser.php?country=GR">GERMANY</a></td></tr>
        <tr><td><a href="Browser.php?country=IT">ITALY</a></td></tr>
        <tr><td><a href="Browser.php?country=GB">UNITED KINGDOM</a></td></tr>
    </table>

    <table class="hot city">
        <tr class="th"><th>HOT CITY</th></tr>
        <tr><td><a href="Browser.php?city=5913490">CALGARY</a></td></tr>
        <tr><td><a href="Browser.php?city=3176959">FIRENZE</a></td></tr>
        <tr><td><a href="Browser.php?city=3169070">ROMA</a></td></tr>
    </table>

    <table class="hot content">
        <tr class="th"><th>HOT CONTENT</th></tr>
        <tr><td><a href="Browser.php?content=scenery">Scenery</a></td></tr>
    </table>
</div>

<div class="f-box">
    <div class="filter">FILTER</div>
    <form action="Browser.php" method="get" name="form2">
        <select name="content" class="content">
            <option value="city" selected>City</option>
            <option value="people">People</option>
            <option value="scenery">Scenery</option>
            <option value="wonder">Wonder</option>
            <option value="animal">Animal</option>
            <option value="building">Building</option>
            <option value="other">Other</option>
        </select>


    <select name="country" class="country" onchange="set_city(this,this.form.city)">
        <option>---select a country---</option>
        <?php
        $conn = new mysqli('localhost','Elaine','IamElaineee','travel');
        $sql = "SELECT Country_RegionName from geocountries_regions";
        $result = $conn->query($sql);
        while ($row = $result->fetch_row()){
            echo '<option value="'.$row[0].'">'.$row[0].'</option>';
        }
        ?>
    </select>

    <select name="city">
        <option>---select a city---</option>
    </select>

    <button class="filterbutton">Filter</button>
    </form>



    <div class="images">
        <?php
        $line=-1;
        $xxm="";
        $Content = isset($_GET['content']) ? $_GET['content'] : "";
        $Country = isset($_GET['country']) ? $_GET['country'] : "";
        $City = isset($_GET['city']) ? $_GET['city'] : "";
        if(isset($_GET['title'])) {
            $xxm = $_GET['title'];//提取关键字
            $tj = " Title like '%{$_GET['title']}%' ";
            $sql = "select ImageID from travelimage where " . $tj;//把条件拼在查询语句后面，并加上where。
            $result = $conn->query($sql);
            $line = $result->num_rows;
            $imageID = array();
            if ($result->num_rows > 0) {
                // 输出数据
                for ($i = 0; $i < $result->num_rows && $row = $result->fetch_assoc(); $i++) {
                    array_push($imageID, $row['ImageID']);
                }
            }
        }elseif (isset($_GET['content'])&&isset($_GET['country'])&&isset($_GET['city'])){//二级联动
            $sql0="select GeoNameID from geocities where AsciiName='$_GET[city]'";
            $result0 = $conn->query($sql0);
            $row0=$result0->fetch_row();
            $City2 = $row0[0];
            $sql = "select ImageID from travelimage where Content='$_GET[content]' and CityCode='$City2'";
            $result = $conn->query($sql);
            $line = $result->num_rows;
            $imageID = array();
            if ($result->num_rows > 0) {
                // 输出数据
                for ($i = 0; $i < $result->num_rows && $row = $result->fetch_assoc(); $i++) {
                    array_push($imageID, $row['ImageID']);
                }
            }
        }elseif (isset($_GET['content'])&&!isset($_GET['country'])&&!isset($_GET['city'])){//主题
            $sql = "select ImageID from travelimage where Content='$_GET[content]'";
            $result = $conn->query($sql);
            $line = $result->num_rows;
            $imageID = array();
            if ($result->num_rows > 0) {
                // 输出数据
                for ($i = 0; $i < $result->num_rows && $row = $result->fetch_assoc(); $i++) {
                    array_push($imageID, $row['ImageID']);
                }
            }
        }
        elseif (!isset($_GET['content'])&&isset($_GET['country'])&&!isset($_GET['city'])){//国家
            $sql = "select ImageID from travelimage where Country_RegionCodeISO='$_GET[country]'";
            $result = $conn->query($sql);
            $line = $result->num_rows;
            $imageID = array();
            if ($result->num_rows > 0) {
                // 输出数据
                for ($i = 0; $i < $result->num_rows && $row = $result->fetch_assoc(); $i++) {
                    array_push($imageID, $row['ImageID']);
                }
            }
        }
        elseif(!isset($_GET['content'])&&!isset($_GET['country'])&&isset($_GET['city'])){//城市
            $sql = "select ImageID from travelimage where CityCode='$City'";
            $result = $conn->query($sql);
            $line = $result->num_rows;
            $imageID = array();
            if ($result->num_rows > 0) {
                // 输出数据
                for ($i = 0; $i < $result->num_rows && $row = $result->fetch_assoc(); $i++) {
                    array_push($imageID, $row['ImageID']);
                }
            }
        }

        $TotalPages = ceil($line/20);
        $pagenow = isset($_GET['page'])?$_GET['page']:1;
        $back = ($pagenow == 1) ? 1 : $pagenow - 1;
        $next = ($pagenow == $TotalPages) ? $TotalPages : $pagenow + 1;

        if($line>0) {
            for($j = ($pagenow - 1) * 20;($j < $line) && ($j <= ($pagenow * 20)-1);$j++){//每一页20张
                show($imageID[$j]);
            }

        if(isset($_GET['title'])){
            echo '
        <div class = page>';
            echo '<a href=Browser.php?title='.$xxm.'&page=' . $back .'>previous </a>';
            $isfull = false;
            if($TotalPages <= 5){
                for ($i = 1; $i <= $TotalPages ; $i++) {
                    if ($i == $pagenow) echo '<a href=Browser.php?title='.$xxm.'&page=' . $i .' style = "color: blueviolet;">' . $i . '</a>';
                    else echo '<a href=Browser.php?title='.$xxm.'&page='. $i .'> '. $i .' </a>';
                }
            }
            else{
                for ($i = 1; $i <= 5 ; $i++) {
                    if ($i == $pagenow) echo '<a href=Browser.php?title='.$xxm.'&page=' . $i . ' style = "color: blueviolet;">' . $i . '</a>';
                    else echo '<a href=Browser.php?title='.$xxm.'&page='. $i .'> '. $i .' </a>';
                }
                echo '......';
            }
            echo '<a href=Browser.php?title='.$xxm.'&page=' . $next . '> next</a>';
            echo '</div>';
        }

        elseif(isset($_GET['content'])&&isset($_GET['country'])&&isset($_GET['city'])){
            echo '
        <div class = page>';
            echo '<a href=Browser.php?page=' . $back . '&content='.$Content.'&country='.$Country.'&city='.$City.'>previous </a>';
            $isfull = false;
            if($TotalPages <= 5){
                for ($i = 1; $i <= $TotalPages ; $i++) {
                    if ($i == $pagenow) echo '<a href=Browser.php?page=' . $i . '&content='.$Content.'&country='.$Country.'&city='.$City.' style = "color: blueviolet;">' . $i . '</a>';
                    else echo '<a href=Browser.php?page='. $i .'&content='.$Content.'&country='.$Country.'&city='.$City.'> '. $i .' </a>';
                }
            }
            else{
                for ($i = 1; $i <= 5 ; $i++) {
                    if ($i == $pagenow) echo '<a href=Browser.php?page=' . $i . '&content='.$Content.'&country='.$Country.'&city='.$City.' style = "color: blueviolet;">' . $i . '</a>';
                    else echo '<a href=Browser.php?page='. $i .'&content='.$Content.'&country='.$Country.'&city='.$City.'> '. $i .' </a>';
                }
                echo '......';
            }
            echo '<a href=Browser.php?page=' . $next . '&content='.$Content.'&country='.$Country.'&city='.$City.'> next</a>';
            echo '</div>';
        }

        elseif(isset($_GET['content'])&&!isset($_GET['country'])&&!isset($_GET['city'])){
            echo '
        <div class = page>';
            echo '<a href=Browser.php?page=' . $back . '&content='.$Content.'>previous </a>';
            $isfull = false;
            if($TotalPages <= 5){
                for ($i = 1; $i <= $TotalPages ; $i++) {
                    if ($i == $pagenow) echo '<a href=Browser.php?page=' . $i . '&content='.$Content.' style = "color: blueviolet;">' . $i . '</a>';
                    else echo '<a href=Browser.php?page='. $i .'&content='.$Content.'> '. $i .' </a>';
                }
            }
            else{
                for ($i = 1; $i <= 5 ; $i++) {
                    if ($i == $pagenow) echo '<a href=Browser.php?page=' . $i . '&content='.$Content.' style = "color: blueviolet;">' . $i . '</a>';
                    else echo '<a href=Browser.php?page='. $i .'&content='.$Content.'> '. $i .' </a>';
                }
                echo '......';
            }
            echo '<a href=Browser.php?page=' . $next . '&content='.$Content.'> next</a>';
            echo '</div>';
        }

        elseif(!isset($_GET['content'])&&isset($_GET['country'])&&!isset($_GET['city'])){
            echo '
        <div class = page>';
            echo '<a href=Browser.php?page=' . $back . '&country='.$Country.'>previous </a>';
            $isfull = false;
            if($TotalPages <= 5){
                for ($i = 1; $i <= $TotalPages ; $i++) {
                    if ($i == $pagenow) echo '<a href=Browser.php?page=' . $i . '&country='.$Country.' style = "color: blueviolet;">' . $i . '</a>';
                    else echo '<a href=Browser.php?page='. $i .'&country='.$Country.'> '. $i .' </a>';
                }
            }
            else{
                for ($i = 1; $i <= 5 ; $i++) {
                    if ($i == $pagenow) echo '<a href=Browser.php?page=' . $i . '&country='.$Country.'style = "color: blueviolet;">' . $i . '</a>';
                    else echo '<a href=Browser.php?page='. $i .'&country='.$Country.'> '. $i .' </a>';
                }
                echo '......';
            }
            echo '<a href=Browser.php?page=' . $next . '&country='.$Country.'> next</a>';
            echo '</div>';
        }

        elseif(!isset($_GET['content'])&&!isset($_GET['country'])&&isset($_GET['city'])){
            echo '
        <div class = page>';
            echo '<a href=Browser.php?page=' . $back . '&city='.$City.'>previous </a>';
            $isfull = false;
            if($TotalPages <= 5){
                for ($i = 1; $i <= $TotalPages ; $i++) {
                    if ($i == $pagenow) echo '<a href=Browser.php?page=' . $i . '&city='.$City.' style = "color: blueviolet;">' . $i . '</a>';
                    else echo '<a href=Browser.php?page='. $i .'&city='.$City.'> '. $i .' </a>';
                }
            }
            else{
                for ($i = 1; $i <= 5 ; $i++) {
                    if ($i == $pagenow) echo '<a href=Browser.php?page=' . $i . '&city='.$City.'style = "color: blueviolet;">' . $i . '</a>';
                    else echo '<a href=Browser.php?page='. $i .'&city='.$City.'> '. $i .' </a>';
                }
                echo '......';
            }
            echo '<a href=Browser.php?page=' . $next . '&city='.$City.'> next</a>';
            echo '</div>';
        }
        }
        elseif($line==0){echo '<div class="feedback">No result found.</div>';}
        else{
            echo '<div class="feedback">No result found.Browse to search some.</div>';
        }//没有数据
        ?>

    </div>
</div>

<footer><span class="copyright">Copyright © 2020 Elaine1908 All Right Reserved ICP:19302010075</span></footer>
</body>
</html>