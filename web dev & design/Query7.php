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
SELECT BI.building_id, BI.street, BI.city, BI.province, COUNT(UI.unit_id) AS number_of_units, BS.overall_score
FROM Building_Info BI
INNER JOIN Building_Score BS ON BI.building_score_id = BS.building_score_id
LEFT JOIN Unit_Info UI ON BI.building_id = UI.building_id
WHERE BS.overall_score > (
    SELECT AVG(overall_score)
    FROM Building_Score
)
GROUP BY BI.building_id, BI.street, BI.city, BI.province, BS.overall_score
ORDER BY number_of_units DESC;
";

$res = mysqli_query($conn, $sql);

echo "<b>Objective of this page: Query 7: Rentals.com aims to highlight buildings that have an above-average overall score. This can serve various strategic purposes:
1. Promoting Superior Properties: Identifying top-tier properties to feature them prominently on the platform, ensuring potential renters or buyers are aware of the best offerings.
2. Partnerships and Collaborations: Engaging building owners or managers of highly rated buildings for potential partnerships, discounts, or promotional activities.
3. Insightful Data for Landlords: Providing landlords or property managers with insights about how their property stands in comparison to the average, helping them make informed decisions on potential improvements or setting rental/sale prices.
</b><br><br>";
echo "The query was: <br>" . nl2br($sql) . "<br><br>Result:<br><br>";

if ($res) {
    while ($newArray = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
        echo "Building ID: " . $newArray['building_id'] . "<br>";
        echo "Street: " . $newArray['street'] . "<br>";
        echo "City: " . $newArray['city'] . "<br>";
        echo "Province: " . $newArray['province'] . "<br>";
        echo "Number of Units: " . $newArray['number_of_units'] . "<br>";
        echo "Overall Score: " . $newArray['overall_score'] . "<br><br><br>";
    }
} else {
    echo "Query failed: " . mysqli_error($conn);
}

mysqli_close($conn);

?>

