<?php
require_once ('db/database_connect.php');
$db_connection = db_connect();


if (!isset($_POST['preview_delete_null_rows'])){
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
        echo '<td>'. $row_data['Gender'] . '</td>';
        echo '<td>'. $row_data['Age'] . '</td>';
        echo '<td>'. $row_data['Question_1'] . '</td>';
        echo '<td>'. $row_data['Question_2'] . '</td>';
        echo '<td>'. $row_data['Question_3'] . '</td>';
        echo '<td>'. $row_data['Ordering'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';

    echo '<form method="post"> 
            <input type="submit" name="preview_delete_null_rows" value="Delete Null Rows">  
          </form>';
    echo '<form method="post"> 
            <input type="submit" name="export_to_csv" value="Export to CSV">
          </form>';

}



if(isset($_POST['export_to_csv'])) {
    header("location: download_csv.php");
    unset($_POST['export_to_csv']);
}

if (isset($_POST['preview_delete_null_rows']) &&!isset($_POST['confirm_delete_null_rows'])) {
    $preview_null_rows = 'SELECT * FROM questions WHERE (Question_1 IS NULL)
                                                      OR (Question_2 IS NULL) 
                                                      OR (Question_3 IS NULL)
                                                      OR (Ordering IS NULL);';

    $statement = $db_connection->prepare($preview_null_rows);
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
        <div class="center">
            <h4>Are you sure you want to delete following rows?</h4>
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
    echo '
        </table>
        <form method="post" action="admin.php">
            <input type="submit" name="confirm_delete_null_rows" value = "Confirm Deletion">
        </form>
        
        </div>
        ';
}
if (isset($_POST['confirm_delete_null_rows'])) {
    $delete_null_rows_query = 'DELETE FROM questions WHERE (Question_1 IS NULL)
                                                      OR (Question_2 IS NULL) 
                                                      OR (Question_3 IS NULL)
                                                      OR (Ordering IS NULL);';
    $statement =$db_connection->prepare($delete_null_rows_query);
    $statement->execute();
    echo '<script type="text/javascript">window.location.replace("admin.php")</script>';
}


echo '
        </div>
    </body>
    </html>
';
