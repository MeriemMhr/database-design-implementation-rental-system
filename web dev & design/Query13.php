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
SELECT bi.building_id, bs.overall_score\
FROM Building_Info bi\
JOIN Building_Score bs ON bi.building_score_id = bs.building_score_id\
WHERE bs.overall_score = (\
    SELECT bs.overall_score\
    FROM Building_Score bs\
    JOIN Building_Info bi ON bs.building_score_id = bi.building_score_id\
    WHERE bi.building_id = (\
        SELECT bi.building_id\
        FROM Building_Info bi\
        JOIN Unit_Info ui ON bi.building_id = ui.building_id\
        JOIN Contract_Info ci ON ui.unit_id = ci.unit_id\
        WHERE ci.user_id = 'UID5'\
        LIMIT 1\
    )\
);\
\
$res = mysqli_query($conn, $sql);\
\
echo "<b>Objective of this page: QUERY 13 To find all buildings that have the same overall score as the building where user 'UID5' previously contracted a unit. This would allow rentals.com to suggest other units in similarly rated buildings to that user.</b><br><br>";\
echo "The query was: <br>" . nl2br($sql) . "<br><br>Result:<br><br>";\
\
if ($res) \{\
    while ($newArray = mysqli_fetch_array($res, MYSQLI_ASSOC)) \{\
        echo "Building ID: " . $newArray['building_id'] . "<br>";\
        echo "Overall Score: " . $newArray['overall_score'] . "<br><br>";\
    \}\
\} else \{\
    echo "Query failed: " . mysqli_error($conn);\
\}\
\
mysqli_close($conn);\
\
?>\
}