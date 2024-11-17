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
    UF.num_bedroom AS preferred_bedrooms,
    UF.num_bathroom AS preferred_bathrooms,
    UF.furnish_type AS preferred_furnish_type,
    UF.pet_allowed AS preferred_pet_policy,
    UF.parking AS preferred_parking,
    CI.contract_type AS preferred_contract_type,
    CI.security_deposit AS preferred_security_deposit,
    CI.termination_fee AS preferred_termination_fee
FROM
    User U
JOIN
    Contract_Info CI ON U.user_id = CI.user_id
JOIN
    Unit_Info UI ON CI.unit_id = UI.unit_id
JOIN
    Unit_Features UF ON UI.unit_features_id = UF.unit_feature_id
WHERE
    CI.start_date <= CURRENT_DATE
    AND CI.end_date >= CURRENT_DATE;
";

$res = mysqli_query($conn, $sql);

echo "<b>Objective of this page: Query 3: This query aims to study past rental data to find out what renters like in terms of property features, lease lengths, 
and amenities. The goal is to help agents offer properties that match renters' preferences. The analysis will show things like how many bedrooms and bathrooms renters prefer, 
if they want furnished places, if they have pets, and more. Agents can use this information to suggest properties that renters will really like, making them happier 
and improving the rental process.";
echo "The query was: <br>" . nl2br($sql) . "<br><br>Result:<br><br>";

if ($res) {
    while ($newArray = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
        echo "Preferred Bedrooms: " . $newArray['preferred_bedrooms'] . "<br>";
        echo "Preferred Bathrooms: " . $newArray['preferred_bathrooms'] . "<br>";
        echo "Preferred Furnish Type: " . $newArray['preferred_furnish_type'] . "<br>";
        echo "Preferred Pet Policy: " . $newArray['preferred_pet_policy'] . "<br>";
        echo "Preferred Parking: " . $newArray['preferred_parking'] . "<br>";
        echo "Preferred Contract Type: " . $newArray['preferred_contract_type'] . "<br>";
        echo "Preferred Security Deposit: " . $newArray['preferred_security_deposit'] . "<br>";
        echo "Preferred Termination Fee: " . $newArray['preferred_termination_fee'] . "<br><br><br>";
    }
} else {
    echo "Query failed: " . mysqli_error($conn);
}

mysqli_close($conn);

?>
