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
    b.city,\
    AVG(ci.security_deposit) AS average_security_deposit\
FROM \
    Contract_Info ci\
JOIN \
    Unit_Info ui ON ci.unit_id = ui.unit_id\
JOIN \
    Building_Info b ON ui.building_id = b.building_id\
GROUP BY \
    b.city\
ORDER BY \
    average_security_deposit DESC\
LIMIT 5;\
";\
\
$res = mysqli_query($conn, $sql);\
\
echo "<b>Objective of this page: Query 19</b><br>";\
echo "\
}