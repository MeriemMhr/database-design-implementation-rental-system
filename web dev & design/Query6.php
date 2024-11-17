<?php

$user = "root";
$password = "root";
$db = "project";
$host = "localhost";
$port = 3306;

$conn = mysqli_connect($host, $user, $password, $db, $port);

if (!$conn) {
    echo "Mysql connection failed!<br><br>";
}

$sql = "
SELECT U1.unit_id, U1.unit_number, U1.unit_price, U1.unit_type, U1.building_id
FROM Unit_Info U1
WHERE U1.unit_price > (
    SELECT AVG(U2.unit_price)
    FROM Unit_Info U2
    WHERE U2.unit_type = U1.unit_type AND U2.building_id = U1.building_id
);
";

$res = mysqli_query($conn, $sql);

echo "<b>Objective of this page: Query 6: Rentals.com wants to identify premium units within each building based on their price in comparison to other units of the same type in the same building. This can be used for multiple purposes. 1. Highlighting Premium Listings: Showcasing these premium units on the homepage or giving them a \"premium\" badge to attract potential customers looking for a more luxurious experience. 2.Dynamic Pricing Recommendations: Helping landlords or property managers understand the positioning of their property within their building, which can be useful for setting or adjusting rental or sale prices. 3.Personalized User Experience: Recommending these premium units to users who have shown an interest in luxury accommodations in the past.</b><br><br>";

echo "The query was: <br>" . nl2br($sql) . "<br><br>Result:<br><br>";

if ($res) {
    while ($newArray = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
        echo "Unit ID: " . $newArray['unit_id'] . "<br>";
        echo "Unit Number: " . $newArray['unit_number'] . "<br>";
        echo "Unit Price: " . $newArray['unit_price'] . "<br>";
        echo "Unit Type: " . $newArray['unit_type'] . "<br>";
        echo "Building ID: " . $newArray['building_id'] . "<br><br><br>";
    }
} else {
    echo "Query failed: " . mysqli_error($conn);
}

mysqli_close($conn);

?>

