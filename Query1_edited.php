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
    LA.years_of_experience,
    COUNT(DISTINCT CI.unit_id) AS rental_history,
    COUNT(DISTINCT UI.unit_id) AS active_listings,
    COUNT(DISTINCT CD.contract_info_id) AS completed_deals
FROM Listing_Agent LA
LEFT JOIN Unit_Info UI ON LA.agent_id = UI.agent_id
LEFT JOIN Contract_Info CI ON LA.agent_id = CI.agent_id
LEFT JOIN Contract_Info CD ON LA.agent_id = CD.agent_id AND CD.end_date < CURDATE()
GROUP BY LA.agent_id, LA.first_name, LA.last_name, LA.years_of_experience
ORDER BY completed_deals DESC;
";

$res = mysqli_query($conn, $sql);

echo "<b>Objective of this page: Query 1: In the context of rentals.com, the goal of this query is to retrieve essential information about listing agents, including their rental history, active listings, completed deals. 
By collecting and analyzing these metrics, the query aims to provide insights into the overall performance of each agent. This information is crucial for evaluating agents' effectiveness in terms of their rental activities and customer feedback. 
It assists in making informed decisions about agent assignments and improving customer satisfaction by identifying high-performing agents.";
echo "The query was: <br>" . nl2br($sql) . "<br><br>Result:<br><br>";

if ($res) {
    while ($newArray = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
        echo "Agent ID: " . $newArray['agent_id'] . "<br>";
        echo "First Name: " . $newArray['first_name'] . "<br>";
        echo "Last Name: " . $newArray['last_name'] . "<br>";
        echo "Years of Experience: " . $newArray['years_of_experience'] . "<br>";
        echo "Rental History: " . $newArray['rental_history'] . "<br>";
        echo "Active Listings: " . $newArray['active_listings'] . "<br>";
        echo "Completed Deals: " . $newArray['completed_deals'] . "<br><br><br>";
    }
} else {
    echo "Query failed: " . mysqli_error($conn);
}

mysqli_close($conn);

?>

