<?php
require_once("config.php");
$pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
$sql = "SELECT travelimagefavor.ImageID, Count(travelimagefavor.UID) AS NumFavor, travelimage.PATH, travelimage.Title, travelimage.Description  
FROM travelimage JOIN travelimagefavor ON travelimagefavor.ImageID=travelimage.ImageID
GROUP BY travelimagefavor.ImageID 
ORDER BY NumFavor DESC";
$result = $pdo->query($sql);
$pictures = array();
$titles = array();
$descriptions = array();
$imageID = array();
for ($i = 0; $i < 6 && $row = $result->fetch(); $i++) {
    array_push($pictures, $row['PATH']);
    array_push($titles, $row['Title']);
    array_push($descriptions, $row['Description']);
    array_push($imageID,$row['ImageID']);
}
function changePics($pictures, $titles, $descriptions,$imageID)
{
    echo '<a name="label"></a>';
    for ($i = 0; $i < 6; $i++) {
        if($descriptions[$i]==""){$descriptions[$i]="There's no description yet...";}
        if($titles[$i]==""){$titles[$i]="wonderland";}
    echo '<div class="images">
    <h4>'.$titles[$i].'</h4>
    <a href="details.php?id='.$imageID[$i].'"><img src="../../travel-images/large/'.$pictures[$i].'." alt="image"></a>
    <p class="description">'.$descriptions[$i].'</p>
</div>';
    }
}
changePics($pictures, $titles, $descriptions,$imageID);
$pdo = null;
