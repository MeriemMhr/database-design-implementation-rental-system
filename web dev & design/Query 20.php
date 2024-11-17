{\rtf1\ansi\ansicpg1252\cocoartf2709
\cocoatextscaling0\cocoaplatform0{\fonttbl\f0\fswiss\fcharset0 Helvetica;}
{\colortbl;\red255\green255\blue255;}
{\*\expandedcolortbl;;}
\margl1440\margr1440\vieww11520\viewh8400\viewkind0
\pard\tx566\tx1133\tx1700\tx2267\tx2834\tx3401\tx3968\tx4535\tx5102\tx5669\tx6236\tx6803\pardirnatural\partightenfactor0

\f0\fs24 \cf0 <?php\
\
$user = "root";\
$password = "root";\
$db = "rental";\
$host = "localhost";\
$port = 8889;\
\
$conn = mysqli_connect($host, $user, $password, $db, $port);\
\
if (!$conn) \{\
    echo "Mysql connection failed!<br><br>";\
\}\
\
$sql = "\
SELECT \
    bi.city,\
    ui.unit_type,\
    AVG(ci.termination_fee) AS average_termination_fee\
FROM \
    Contract_Info ci\
JOIN \
    Unit_Info ui ON ci.unit_id = ui.unit_id\
JOIN\
    Building_Info bi ON ui.building_id = bi.building_id\
JOIN \
    Unit_Features uf ON ui.unit_features_id = uf.unit_feature_id\
GROUP BY \
    bi.city, ui.unit_type\
ORDER BY \
    bi.city, average_termination_fee DESC;\
";\
\
$res = mysqli_query($conn, $sql);\
\
echo "<b>Objective of this page: Query 20</b><br>";\
echo "The objective of this query is to compare the average termination fees for different unit types across various cities. By analyzing the data from the Contract_Info, Unit_Info, Building_Info, and Unit_Features tables, this query aims to provide insights into how termination fees vary based on unit types within each city. The results of this query can assist stakeholders in understanding the relationship between unit types, termination fees, and city locations.<br><br>";\
echo "The query was: <br>" . nl2br($sql) . "<br><br>Result:<br><br>";\
\
if ($res) \{\
    while ($newArray = mysqli_fetch_array($res, MYSQLI_ASSOC)) \{\
        echo "City: " . $newArray['city'] . "<br>";\
        echo "Unit Type: " . $newArray['unit_type'] . "<br>";\
        echo "Average Termination Fee: $" . $newArray['average_termination_fee'] . "<br><br><br>";\
    \}\
\} else \{\
    echo "Query failed: " . mysqli_error($conn);\
\}\
\
mysqli_close($conn);\
\
?>\
}