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
    UA.first_name AS agent_first_name,
    UA.last_name AS agent_last_name,
    UA.email AS agent_email,
    UA.unit_id,
    UA.unit_number,
    UI.unit_type,
    UA.unit_price,
    COUNT(DISTINCT V.user_id) AS traffic,
    COUNT(DISTINCT IQ.user_id) AS inquiries,
    COUNT(DISTINCT CI.user_id) AS conversions
FROM
    Unit_Info UI
JOIN
    Listing_Agent UA ON UI.agent_id = UA.agent_id
LEFT JOIN
    View_Log v ON UI.unit_id = V.unit_id
LEFT JOIN
    Inquiry IQ ON UI.unit_id = IQ.unit_id
LEFT JOIN
    Contract_Info CI ON UI.unit_id = CI.unit_id
GROUP BY
    UA.agent_id, UI.unit_id
ORDER BY
    conversions DESC, inquiries DESC, traffic DESC;
";

$res = mysqli_query($conn, $sql);

echo "<b>Objective of this page: Query 4:This query aims to determine which listings excel in attracting traffic, inquiries, and conversions, while also linking 
these outcomes to responsible agents. By ranking agents and their associated listings based on their performance, the query provides insights into each agent's 
effectiveness in generating interest, engaging users, and achieving successful conversions. This information helps identify top-performing agents and enhance 
strategies to increase listing visibility, user engagement, and conversion rates.";
echo "The query was: <br>" . nl2br($sql) . "<br><br>Result:<br><br>";

if ($res) {
    while ($newArray = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
        echo "Agent First Name: " . $newArray['agent_first_name'] . "<br>";
        echo "Agent Last Name: " . $newArray['agent_last_name'] . "<br>";
        echo "Agent Email: " . $newArray['agent_email'] . "<br>";
        echo "Unit ID: " . $newArray['unit_id'] . "<br>";
        echo "Unit Number: " . $newArray['unit_number'] . "<br>";
        echo "Unit Type: " . $newArray['unit_type'] . "<br>";
        echo "Unit Price: " . $newArray['unit_price'] . "<br>";
        echo "Traffic: " . $newArray['traffic'] . "<br>";
        echo "Inquiries: " . $newArray['inquiries'] . "<br>";
        echo "Conversions: " . $newArray['conversions'] . "<br><br><br>";
    }
} else {
    echo "Query failed: " . mysqli_error($conn);
}

mysqli_close($conn);

?>
