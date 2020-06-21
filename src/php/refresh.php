<?php
$conn = new mysqli('localhost','Elaine','IamElaineee','travel');
if ($conn->connect_error) {
    die("Failed connection: " . $conn->connect_error);
}
else {
    $sql = "SELECT * FROM travelimage WHERE
	ImageID >= (
		(SELECT MAX(ImageID) FROM travelimage) - (SELECT MIN(ImageID) FROM travelimage)
	) * RAND() + (SELECT MIN(ImageID) FROM travelimage) LIMIT 6";
    $result = $conn->query($sql);
    $pictures = array();
    $titles = array();
    $descriptions = array();
    $imageID = array();
    if ($result->num_rows > 0) {
        // 输出数据
        for ($i = 0; $i < 6 && $row = $result->fetch_assoc(); $i++) {
            array_push($pictures, $row['PATH']);
            array_push($titles, $row['Title']);
            array_push($descriptions, $row['Description']);
            array_push($imageID, $row['ImageID']);
        }
    } else {
        echo "0 result";
    }
    function refresh($pictures, $titles, $descriptions, $imageID)
    {
        echo '<a name="label"></a>';
        for ($i = 0; $i < 6; $i++) {
            if ($descriptions[$i] == "") {
                $descriptions[$i] = "There's no description yet...";
            }
            if ($titles[$i] == "") {
                $titles[$i] = "wonderland";
            }
            echo '<div class="images">
    <h4>' . $titles[$i] . '</h4>
    <a href="details.php?id=' . $imageID[$i] . '"><img src="../../travel-images/large/' . $pictures[$i] . '." alt="image"></a>
    <p class="description">' . $descriptions[$i] . '</p>
</div>';
        }
    }
    refresh($pictures, $titles, $descriptions, $imageID);
}
$conn->close();





