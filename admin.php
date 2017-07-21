<?php
require_once ('db/database_connect.php');
$db_connection = db_connect();
$statement = $db_connection->prepare("SELECT * FROM questions;");
$statement->execute();
$db_data = $statement->fetchAll();

echo '
    <DOCTYPE! HTML>
    <html>
    <head> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Psych</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <div class="center">
            <table>
            <tr>
            <th>ID</th>
            <th>First_Trial</th>
            <th>Gender</th>
            <th>Age</th>
            <th>Question_1</th>
            <th>Question_2</th>
            <th>Question_3</th>
            <th>Order</th>
            </tr>';
foreach ($db_data as $outer_key => $row_data){
    echo '<tr>';
    echo '<td>'. $row_data['ID'] . '</td>';
    echo '<td>'. $row_data['First_Trial'] . '</td>';
    echo '<td>'. $row_data['Age'] . '</td>';
    echo '<td>'. $row_data['Gender'] . '</td>';
    echo '<td>'. $row_data['Question_1'] . '</td>';
    echo '<td>'. $row_data['Question_2'] . '</td>';
    echo '<td>'. $row_data['Question_3'] . '</td>';
    echo '<td>'. $row_data['Ordering'] . '</td>';
    echo '</tr>';
}



echo '            </table>
        </div>
    </body>
    </html>
';