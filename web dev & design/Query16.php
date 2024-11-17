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
    ROUND((\
        BS.transportation_score * 0.4 +\
        BS.park_score * 0.3 +\
        BS.coffee_score * 0.3\
    ), 2) AS weighted_score\
FROM\
    Building_Info BI\
    JOIN Building_Score BS ON BI.building_score_id = BS.building_score_id\
ORDER BY\
    weighted_score DESC;\
";\
\
$res = mysqli_query($conn, $sql);\
\
echo "<b>Objective of this page: In this query, buildings are ranked based on a calculated weighted score that considers transportation, park, and coffee scores. This ranking allows the rental platform to highlight buildings that are likely to appeal to individuals who value these specific attributes. The platform can then prioritize promoting these high-scoring buildings to users who are interested in factors such as convenient transportation options, proximity to parks, and nearby coffee shops. Query 16</b><br><br>";\
echo "The query was: <br>" . nl2br($sql) . "<br><br>Result:<br><br>";\
\
if ($res) \{\
    $rank = 1;\
    while ($newArray = mysqli_fetch_array($res, MYSQLI_ASSOC)) \{\
        echo "Rank: " . $rank . "<br>";\
        echo "Building ID: " . $newArray['building_id'] . "<br>";\
        echo "Street: " . $newArray['street'] . "<br>";\
        echo "City: " . $newArray['city'] . "<br>";\
        echo "Weighted Score: " . $newArray['weighted_score'] . "<br><br>";\
        $rank++;\
    \}\
\} else \{\
    echo "Query failed: " . mysqli_error($conn);\
\}\
\
mysqli_close($conn);\
\
?>\
}