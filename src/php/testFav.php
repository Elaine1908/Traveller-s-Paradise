<?php
//收藏次数最多的图片
$conn = new mysqli('localhost','Elaine','IamElaineee','travel');
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
else {
    $sql_ = "select ImageID from travelimagefavor";
    $result_ = $conn->query($sql_);
    $fav = [];//存储每个imageID出现的次数
    $info=[[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0],[0,0,0]];//存储6张图各自的path/title/description
    $sql = ['','','','','',''];
    for ($i = 0; $i <= 81; $i++) {
        $fav[$i] = 0;
    }
    $row_ = $result_->fetch_row();
    while ($row_ = $result_->fetch_row()) {
        $fav[$row_[0]-1] += 1;
    }
    arsort($fav);
    $sql2 = "select PATH,Description,Title from travelimage where ImageID = '$fav[0]'";//问题在这里
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_row();
    echo $row2[0];
    $sql3 = "select PATH,Description,Title from travelimage where ImageID = '$fav[1]'";
    $result3 = $conn->query($sql3);
    $row3 = $result3->fetch_row();
    echo $row3[0];

    /**for($k =0;$k<=4;$k++){
    $sql2 = "select PATH,Description,Title from travelimage where ImageID = '$fav[$k]'";
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_row();
    echo $row2[0];


    $info[$k][0]=$row2[0][0];//path
    $info[$k][1]=$row2[1];//des
    $info[$k][2]=$row2[2];//title
    }**/
}

//if($GLOBALS[0][0]!=null){

//}
//else{
echo '<div class="collection" id="collection">
<div class="images">
    <a name="label"></a>
    <h4>'.$info[1][2].'</h4>
    <a href="details.php?id="'.$fav[1].'><img src="../../travel-images/large/"'.$info[1][0].' alt="image"></a>
    <p class="description">'.$info[1][1].'</p>
</div>

<div class="images">
    <h4>'.$info[2][2].'</h4>
    <a href="details.php?id="'.$fav[2].'><img src="../../travel-images/large/"'.$info[2][0].' alt="image"></a>
    <p class="description">'.$info[2][1].'</p>
</div>

<div class="images">
    <h4>'.$info[3][2].'</h4>
    <a href="details.php?id="'.$fav[3].'><img src="../../travel-images/large/"'.$info[3][0].' alt="image"></a>
    <p class="description">'.$info[3][1].'</p>
</div>

<div class="images">
    <h4>'.$info[4][2].'</h4>
    <a href="details.php?id="'.$fav[4].'><img src="../../travel-images/large/"'.$info[4][0].' alt="image"></a>
    <p class="description">'.$info[4][1].'</p>
</div>

<div class="images">
    <h4>'.$info[5][2].'</h4>
    <a href="details.php?id="'.$fav[5].'><img src="../../travel-images/large/"'.$info[5][0].' alt="image"></a>
    <p class="description">'.$info[5][1].'</p>
</div>

<div class="images">
    <h4>'.$info[0][2].'</h4>
    <a href="details.php?id="'.$fav[0].'><img src="../../travel-images/large/"'.$info[0][0].' alt="image"></a>
    <p class="description">'.$info[0][1].'</p>
</div>

</div>';


?>
