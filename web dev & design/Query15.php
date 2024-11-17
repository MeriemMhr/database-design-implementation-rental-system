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
$db = "project";\
$host = "localhost";\
$port = 3306;\
\
$conn = mysqli_connect($host, $user, $password, $db, $port);\
\
if (!$conn) \{\
    echo "Mysql connection failed!<br><br>";\
\}\
\
$sql = "\
SELECT\
    BI.building_id,\
    BI.street,\
    BI.city,\
    BS.transportation_score,\
    BS.park_score\
FROM\
    Building_Info BI\
    JOIN Building_Score BS ON BI.building_score_id = BS.building_score_id\
WHERE\
    BS.transportation_score >= 4\
    AND BS.park_score >= 4;\
";\
\
$res = mysqli_query($conn, $sql);\
\
echo "<b>Objective of this page: Query 15: The goal of this query is to identify buildings that have excellent transportation and park scores. These buildings are likely to be attractive to outdoor enthusiasts who prioritize easy access to transportation and green spaces. The rental platform can use this information for targeted marketing campaigns aimed at individuals who value both convenient commuting options and proximity to parks and recreational areas.</b><br><br>";\
echo "The query was: <br>" . nl2br($sql) . "<br><br>Result:<br><br>";\
\
if ($res) \{\
    while ($newArray = mysqli_fetch_array($res, MYSQLI_ASSOC)) \{\
        echo "Building ID: " . $newArray['building_id'] . "<br>";\
        echo "Street: " . $newArray['street'] . "<br>";\
        echo "City: " . $newArray['city'] . "<br>";\
        echo "Transportation Score: " . $newArray['transportation_score'] . "<br>";\
        echo "Park Score: " . $newArray['park_score'] . "<br><br>";\
    \}\
\} else \{\
    echo "Query failed: " . mysqli_error($conn);\
\}\
\
mysqli_close($conn);\
\
?>\
}