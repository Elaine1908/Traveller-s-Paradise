<?php
$conn = new mysqli('localhost','Elaine','IamElaineee','travel');
$sql = "UPDATE travelimage SET Title=36,Description=3
WHERE ImageID=0";
$result = $conn->query($sql);
if($result){echo 'right';}







