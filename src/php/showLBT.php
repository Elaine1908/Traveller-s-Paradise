<?php
$conn = new mysqli('localhost','Elaine','IamElaineee','travel');
if ($conn->connect_error) {
    die("Failed connection: " . $conn->connect_error);
}
else {
    $sql = "SELECT * FROM travelimage WHERE
	ImageID >= (
		(SELECT MAX(ImageID) FROM travelimage) - (SELECT MIN(ImageID) FROM travelimage)
	) * RAND() + (SELECT MIN(ImageID) FROM travelimage) LIMIT 5";
    $result = $conn->query($sql);
    $pictures = array();

    if ($result->num_rows > 0) {
        // 输出数据
        for ($i = 0; $i < 6 && $row = $result->fetch_assoc(); $i++) {
            array_push($pictures, $row['PATH']);
        }
    } else {
        echo "0 result";
    }
    function show($pictures)
    {
        for ($i = 0; $i < 5; $i++) {
            echo '<img src="../../travel-images/large/' . $pictures[$i] . '." alt="image">';
        }
    }
    show($pictures);
}
$conn->close();