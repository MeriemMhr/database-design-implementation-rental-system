<?php

$user = "root";
$password = "root";
$db = "project";
$host = "localhost";
$port = 3306;

$conn = mysqli_connect($host,$user,$password,$db,$port);

if (!$conn) {
    echo "Mysql connection failed!<br><br>";
}

$sql = "
SELECT ui.unit_id, ui.unit_number, ui.unit_price, ui.date_posted, ui.unit_type
FROM Unit_Info ui
INNER JOIN Building_Info bi ON ui.building_id = bi.building_id
WHERE bi.building_score_id IN (
    SELECT DISTINCT b.building_score_id
    FROM Contract_Info ci
    INNER JOIN Unit_Info ui ON ci.unit_id = ui.unit_id
    INNER JOIN Building_Info b ON ui.building_id = b.building_id
    WHERE ci.user_id = 'UID5'
)
AND ui.unit_id NOT IN (
    SELECT unit_id
    FROM Contract_Info
    WHERE user_id = 'UID5'
)
ORDER BY ui.date_posted DESC;
";

$res = mysqli_query($conn, $sql);

echo "<b>Objective of this page: Query 5: The team at rentals.com wants to provide personalized suggestions to their returning clients. To achieve this, the website curates a list of units available in buildings that have similar ratings (or scores) to those the user 'UID5' has previously contracted. This way, the user gets recommendations based on their historical preferences, increasing the chances of them making another rental or purchase decision. The query ensures that previously contracted units by the user are not shown again, providing a fresh set of recommendations every time.
</b><br><br>";
echo "The query was: <br>" . nl2br($sql) . "<br><br>Result:<br><br>";

if ($res) {
    while ($newArray = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
        echo "Unit ID: " . $newArray['unit_id'] . "<br>";
        echo "Unit Number: " . $newArray['unit_number'] . "<br>";
        echo "Unit Price: " . $newArray['unit_price'] . "<br>";
        echo "Date Posted: " . $newArray['date_posted'] . "<br>";
        echo "Unit Type: " . $newArray['unit_type'] . "<br><br><br>";
    }
} else {
    echo "Query failed: " . mysqli_error($conn);
}

mysqli_close($conn);

?>
