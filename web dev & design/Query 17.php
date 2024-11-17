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
SELECT\
    a.first_name,\
    a.last_name,\
    COUNT(CASE WHEN c.contract_type = 'Lease' THEN 1 END) AS num_leases,\
    COUNT(CASE WHEN c.contract_type = 'Sale' THEN 1 END) AS num_sales,\
    ROUND(COUNT(CASE WHEN c.contract_type = 'Lease' THEN 1 END) / COUNT(*), 2) AS percent_leases\
FROM Contract_Info c\
JOIN Listing_Agent a ON c.agent_id = a.agent_id\
GROUP BY a.first_name, a.last_name\
ORDER BY percent_leases DESC;\
";\
\
$res = mysqli_query($conn, $sql);\
\
echo "<b>Objective of this page: Query 17</b><br>";\
echo "The primary objective of this query is to provide insights into the performance of listing agents on the rentals.com website. It achieves this by calculating and presenting key metrics related to the contracts managed by each listing agent. Specifically, the query calculates the number of leases and sales contracts handled by each agent, as well as the percentage of contracts that are leases among all the contracts they've managed. This information helps in evaluating the agents' effectiveness in handling different types of contracts.<br><br>";\
echo "The query was: <br>" . nl2br($sql) . "<br><br>Result:<br><br>";\
\
if ($res) \{\
    while ($newArray = mysqli_fetch_array($res, MYSQLI_ASSOC)) \{\
        echo "First Name: " . $newArray['first_name'] . "<br>";\
        echo "Last Name: " . $newArray['last_name'] . "<br>";\
        echo "Number of Leases: " . $newArray['num_leases'] . "<br>";\
        echo "Number of Sales: " . $newArray['num_sales'] . "<br>";\
        echo "Percent Leases: " . $newArray['percent_leases'] . "<br><br><br>";\
    \}\
\} else \{\
    echo "Query failed: " . mysqli_error($conn);\
\}\
\
mysqli_close($conn);\
\
?>\
}