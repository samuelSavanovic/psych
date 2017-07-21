<?php
require_once ('db/database_connect.php');
$db_connection = db_connect();
function update_order($order) {
    for ($i = 0; $i < 3; $i++) {
        switch ($order[$i]) {
            case '0':
                $order[$i] = 'A';
                break;
            case '1':
                $order[$i] = 'B';
                break;
            case '2':
                $order[$i] = 'C';
                break;
        }
    }
    return $order;
}
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=data.csv');


$sql = "SELECT * FROM questions ORDER BY ID;";

$STH = $db_connection->prepare($sql);
$STH->execute();
$fp = fopen('php://output', 'w');

$first_row = $STH->fetch(PDO::FETCH_ASSOC);
$first_row['Ordering'] = update_order($first_row['Ordering']);
$headers = array_keys($first_row);
fputcsv($fp, $headers);
fputcsv($fp, array_values($first_row));
while ($row = $STH->fetch(PDO::FETCH_NUM))  {
    $row[7] =update_order($row[7]);
    fputcsv($fp,$row); // push the rest
}
fclose($fp);