<?php
$conn = new mysqli('localhost','Elaine','IamElaineee','travel');


$sql = "SELECT ImageID, Count(UID) AS NumFavor FROM travelimagefavor 
GROUP BY ImageID
ORDER BY NumFavor DESC";
$result=$conn->query($sql);
$imageID = array();
for ($i = 0; $i < $result->num_rows && $row = $result->fetch_assoc(); $i++) {
    array_push($imageID,$row['ImageID']);

}


$sql2 = "SELECT DISTINCT AsciiName,GeoNameID,ImageID,Count(UID) AS NumFavor from travelimage 
join geocities on geocities.GeoNameID=travelimage.CityCode join travelimagefavor on travelimage.ImageID=travelimagefavor.ImageID GROUP BY ImageID
ORDER BY NumFavor DESC LIMIT 4";
$result2=$conn->query($sql2);
while ($row2=$result2->fetch_row()){
    echo $row2['AsciiName'];
    echo $row2['GeoNameID'];
}