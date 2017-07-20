<?php
require_once 'db/database_connect.php';
$db_connection = db_connect();

if (isset($_POST['questionnaire_submit'])) {
    $order = $_POST['ordering'];

    $Question_3 = $_POST[$order[2]];
    $statement = $db_connection->prepare("update questions set Question_3 = ?, Ordering = ? where ID = ?");
    $statement->execute(array($Question_3, $order, $_POST['id']));
    echo '
        <!DOCTYPE html>
        <html>
        <head>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Psych</title>
            <link rel="stylesheet" type="text/css" href="css/style.css">
        </head>
        <body>
        </body>
            <div class="center">
                <h3 class="heading">Believe it or not, that\'s it!</h3>
                <p> Thank you for your participation! If you wish to know more about this study, feel free to
contact me at: <br><a href="mailto:monika@qc-research.science">monika@qc-research.science</a></p>
                <p>Monika Svogor <br>
Masters student<br>
Department of Psychology<br>
Faculty of Humanities and Social Sciences<br>
Rijeka, Croatia</p>
            </div>
        </html>
    ';
}