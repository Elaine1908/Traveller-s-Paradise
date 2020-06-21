<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload</title>
    <link href="../css/reset.css" rel="stylesheet" type="text/css" >
    <link href="../css/upload.css" rel="stylesheet" type="text/css" >
    <link href="../css/nav.css" rel="stylesheet" type="text/css" >
    <link rel="stylesheet" href="../../font-awesome-4.7.0/css/font-awesome.min.css">
    <script src="../js/upload.js"></script>
    <script src="../js/highlight.js"></script>
    <script src="../js/select.js"></script>
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

<div class="upload">UPLOAD</div>


<div id="preview" style="width:320px;height:200px;">
    <?php
    //<script>document.getElementById("modify").setAttribute("value","'.$row['PATH'].'") </script> 路径展示
    //获取所在照片的id
    if(isset($_GET['id'])){
        $imageID = $_GET['id'];

        $conn = new mysqli('localhost','Elaine','IamElaineee','travel');
        $sql = "SELECT PATH from travelimage where ImageID = '$imageID'";

        $sql2 = "SELECT Country_RegionName from geocountries_regions";
        $result2 = $conn->query($sql2);

        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        echo '<img src="../../travel-images/large/'.$row['PATH'].'." alt="image" width="320" height="200"></img>';
        echo '</div><!--用来放预览图片的DIV-->



<div class="input">
    <form action="modify.php?id='.$imageID.'" method="post">
    <input id="modify" class="img" name="upload" type="file" onchange="previewImage(this,320,200)" accept="image/*" /><!--一旦用户选择了图片文件，则触发上方的previewImage函数-->
    
   <div class="border">
    <p>
    Content:
    <select name="content" class="content">
       
        <option value="city" selected>City</option>
        <option value="people">People</option>
        <option value="scenery">Scenery</option>
        <option value="wonder">Wonder</option>
        <option value="animal">Animal</option>
        <option value="building">Building</option>
        <option value="other">Other</option>
    </select></p><br>
        <p>Title of the pic:<br>
            <input type="text" name="title" class="text">
        </p>
        <p>Description:<br>
            <textarea type="text" name="description" ></textarea>
        </p>
        <p>Country:<br>
            <select name="country" class="country" onchange="set_city(this,this.form.city)">
                <option value="0">---select a country---</option>';
        while ($row2 = $result2->fetch_row()){
            echo '<option value="'.$row2[0].'">'.$row2[0].'</option>';
        }
        echo '
                </select>
           
        </p>
        <script src="../js/select.js"></script>
        <p>City:<br>
                <select name="city">
        <option value="">---select a city---</option>
    </select>
            
        </p>

        <p><button name="Submit">Modify</button> </p>
        </div>
    </form>
</div>';
    }
    else{
        $conn = new mysqli('localhost','Elaine','IamElaineee','travel');
        $sql2 = "SELECT Country_RegionName from geocountries_regions";
        $result2 = $conn->query($sql2);
        echo '</div><!--用来放预览图片的DIV-->


<div class="input">
    <form action="uploadCheck.php" method="post">
    <input id="modify" class="img" name="upload" type="file" onchange="previewImage(this,320,200)" accept="image/*" required/><!--一旦用户选择了图片文件，则触发上方的previewImage函数-->
    <div class="border">
    <p>
    Content:
     <select name="content" class="content">
        <option selected>City</option>
        <option>People</option>
        <option>Scenery</option>
        <option>Wonder</option>
        <option>Animal</option>
        <option>Building</option>
        <option>Other</option>
    </select>
    </p><br>
        <p>Title of the pic:<br>
            <input type="text" name="title" class="text">
        </p>
        <p>Description:<br>
            <textarea type="text" name="description"></textarea>
        </p>
        <p>Country:<br>
            <select name="country" class="country" onchange="set_city(this,this.form.city)">
                <option value="0">---select a country---</option>';
        while ($row2 = $result2->fetch_row()){
            echo '<option value="'.$row2[0].'">'.$row2[0].'</option>';
        }
        echo '</select>
           
        </p>
        <script src="../js/select.js"></script>
        <p>City:<br>
         <select name="city">
        <option value="">---select a city---</option>
    </select>
        </p>
        <p><button name="Submit">Upload</button> </p>
        </div>
    </form>
</div>';
    }
     ?>


<footer><span class="copyright">Copyright © 2020 Elaine1908 All Right Reserved ICP:19302010075</span></footer>
</body>
</html>