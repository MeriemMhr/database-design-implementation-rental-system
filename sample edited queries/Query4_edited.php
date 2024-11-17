<?php
$user = "if0_34866024";
$password = "idksDqUhhZey0";
$db = "if0_34866024_rentalca";
$host = "sql108.infinityfree.com";
$port = 3306;

$conn = mysqli_connect($host, $user, $password, $db, $port);

if (!$conn) {
    echo "Mysql connection failed!<br><br>";
}

$sql = "
SELECT
    LA.agent_id,
    LA.first_name,
    LA.last_name,
    COUNT(UI.unit_id) AS total_listings,
    AVG(UI.unit_price) AS average_unit_price
FROM
    Listing_Agent LA
JOIN
    Unit_Info UI ON LA.agent_id = UI.agent_id
GROUP BY
    LA.agent_id, LA.first_name, LA.last_name
ORDER BY
    average_unit_price DESC;
";

$res = mysqli_query($conn, $sql);

echo "<b>Objective of this page: Query 4: This query aims to analyze the performance of listing agents based on the average prices of the units they handle. The goal is to gain insights into agents' capabilities in managing properties with different price ranges. 
By calculating the average unit price handled by each agent, this query helps in understanding their market positioning, clientele, and ability to cater to various price segments. 
This information is valuable for making informed decisions about agent assignments and tailoring marketing strategies to target specific customer segments effectively.";
echo "The query was: <br>" . nl2br($sql) . "<br><br>Result:<br><br>";

if ($res) {
    while ($newArray = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
        echo "Agent ID: " . $newArray['agent_id'] . "<br>";
        echo "First Name: " . $newArray['first_name'] . "<br>";
        echo "Last Name: " . $newArray['last_name'] . "<br>";
        echo "Total Listings: " . $newArray['total_listings'] . "<br>";
        echo "Average Unit Price: " . $newArray['average_unit_price'] . "<br><br><br>";
    }
} else {
    echo "Query failed: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
