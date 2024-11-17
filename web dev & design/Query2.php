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
SELECT
    LA.first_name || ' ' || LA.last_name AS agent_name,
    BI.city,
    COUNT(UI.unit_id) AS num_listings,
    AVG(UI.unit_price) AS avg_price,
    AVG(UF.num_bedroom) AS avg_bedrooms,
    AVG(UF.num_bathroom) AS avg_bathrooms,
    UF.pet_allowed,
    UF.parking
FROM
    Listing_Agent AS LA
JOIN
    Unit_Info AS UI ON LA.agent_id = UI.agent_id
JOIN
    Building_Info AS BI ON UI.building_id = BI.building_id
JOIN
    Unit_Features AS UF ON UI.unit_features_id = UF.unit_feature_id
GROUP BY
    LA.agent_id, BI.city, UF.pet_allowed, UF.parking
ORDER BY
    num_listings DESC;
";

$res = mysqli_query($conn, $sql);

echo "<b>Objective of this page: Query 2:This query is designed to give us a clear picture of how well listing agents are doing and what types of properties 
they handle. It helps us see how many properties they list on average, the average prices, bedrooms, and bathrooms. Additionally, it shows if pets are allowed 
and if there's parking available in these properties. This information helps us understand agents' performance and the kind of properties they manage, which is 
useful for making better decisions about property management and offerings.";
echo "The query was: <br>" . nl2br($sql) . "<br><br>Result:<br><br>";

if ($res) {
    while ($newArray = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
        echo "Agent Name: " . $newArray['agent_name'] . "<br>";
        echo "City: " . $newArray['city'] . "<br>";
        echo "Number of Listings: " . $newArray['num_listings'] . "<br>";
        echo "Average Price: " . $newArray['avg_price'] . "<br>";
        echo "Average Bedrooms: " . $newArray['avg_bedrooms'] . "<br>";
        echo "Average Bathrooms: " . $newArray['avg_bathrooms'] . "<br>";
        echo "Pet Allowed: " . $newArray['pet_allowed'] . "<br>";
        echo "Parking Available: " . $newArray['parking'] . "<br><br><br>";
    }
} else {
    echo "Query failed: " . mysqli_error($conn);
}

mysqli_close($conn);

?>
