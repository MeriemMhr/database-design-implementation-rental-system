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
SELECT DISTINCT UI.unit_id, UI.unit_number, BI.street, BI.city
FROM Unit_Info UI
-- Join for sold units
INNER JOIN Contract_Info CI_SOLD ON UI.unit_id = CI_SOLD.unit_id AND CI_SOLD.contract_type = 'Sale'
  AND CI_SOLD.start_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 2 YEAR) AND CURDATE()
  
-- Join for rented units
INNER JOIN Contract_Info CI_RENTED ON UI.unit_id = CI_RENTED.unit_id AND CI_RENTED.contract_type = 'Lease'
  AND CI_RENTED.start_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 2 YEAR) AND CURDATE()
  
INNER JOIN Building_Info BI ON UI.building_id = BI.building_id;
";

$res = mysqli_query($conn, $sql);

echo "<b>Objective of this page: Query 8: Rentals.com aims to identify units with high turnover. Understanding which units have been both sold and rented within a short span can offer insights into the market dynamics and preferences of renters and buyers. Such information can:
1.Aid in Decision-making for Investors: If certain units are being frequently bought and then put up for rent, they might be lucrative for investors.
2.Understand Market Dynamics: Rapid turnover might indicate either high demand for the unit or dissatisfaction with the purchase leading to it being put up for rent.
3.Strategic Promotion: High turnover units can be promoted differently, offering potential buyers insights into potential rental income or alerting them to do more due diligence before purchasing.
</b><br><br>";
echo "The query was: <br>" . nl2br($sql) . "<br><br>Result:<br><br>";

if ($res) {
    while ($newArray = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
        echo "Unit ID: " . $newArray['unit_id'] . "<br>";
        echo "Unit Number: " . $newArray['unit_number'] . "<br>";
        echo "Street: " . $newArray['street'] . "<br>";
        echo "City: " . $newArray['city'] . "<br><br><br>";
    }
} else {
    echo "Query failed: " . mysqli_error($conn);
}

mysqli_close($conn);

?>

