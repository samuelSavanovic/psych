<?php
require_once ('general_questions.php');
require_once ('db/database_connect.php');
require_once ('questions.php');

$db_connection = db_connect();

function exec_sql($db_connection, $sql) {
    $statement = $db_connection->prepare($sql);
    $statement->execute();
    return $statement->fetch();
}

$questions = array("Do you like this painting?",
    "Would you hang this painting on your wall?",
    "Do you think this painting is expensive?");

if(!isset($_POST['general_questions_submit']) && !isset($_POST['question_1']) && !isset($_POST['question_2'])) {
    general_questions();
}

if(isset($_POST['general_questions_submit']) && !isset($_POST['question_2']) ) {
    $order = array();
    $sql = "INSERT INTO questions (First_Trial, Gender, Age) VALUES (?, ?, ?)";
    $statement = $db_connection->prepare($sql);
    $statement->execute(array($_POST['first_time_participating'], $_POST['gender'], $_POST['age']));

    $id = exec_sql($db_connection, "SELECT * FROM questions ORDER BY ID DESC LIMIT 1");
    $sql = "SELECT Ordering FROM questions where ID = ?";
    $statement = $db_connection->prepare($sql);
    $last_id = $id[0] - 1;
    $statement->execute(array($last_id));
    $ordering = $statement->fetch();

    if ($ordering == null) {
        $permutation_number = 0;
    }else {
        $permutation_number = get_index(permutations($questions), $ordering[0]);
        $permutation_number++;
        if ($permutation_number > 5){
            $permutation_number = 0;
        }
    }
    $qsts = process(permutations($questions)[$permutation_number]);
    $all_questions = array($qsts[1] . $qsts[2], $qsts[4] . $qsts[5] , $qsts[7] . $qsts[8]);

    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Psych</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
        <body>
            <div style="margin-left: 20%; margin-right: 20%; margin-top: 2%;">
                <div class="row">
                    <div>
                        <img src="data:image/jpeg;base64,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">
                    </div>
              
                
                <div class="row">
                    <form method="post" target="_top">
                        <div class="questions">',$all_questions[0],'</div>
                        <input type="submit" name="question_1" value="Next" style="float: right;">
                        <br>
                        <input type="hidden" name="id" value="',$id[0],'">
                        <input type="hidden" name="ordering" value=',join($order),'>
                    </form>
                </div>
            </div>
        </body>
    </html>
    ';

}

//question 2
if(isset($_POST['question_1'])){
    $order = array();
    $id = exec_sql($db_connection, "SELECT * FROM questions ORDER BY ID DESC LIMIT 1");
    $sql = "SELECT Ordering FROM questions where ID = ?";
    $statement = $db_connection->prepare($sql);
    $last_id = $id[0] - 1;
    $statement->execute(array($last_id));
    $ordering = $statement->fetch();

    if ($ordering == null) {
        $permutation_number = 0;
    }else {
        $permutation_number = get_index(permutations($questions), $ordering[0]);
        $permutation_number++;
        if ($permutation_number > 5){
            $permutation_number = 0;
        }
    }
    $qsts = process(permutations($questions)[$permutation_number]);
    $all_questions = array($qsts[1] . $qsts[2], $qsts[4] . $qsts[5] , $qsts[7] . $qsts[8]);

    $order = $_POST['ordering'];
    $Question_1 = $_POST[$order[0]];
    $statement = $db_connection->prepare("update questions set Question_1 = ? where ID = ?");
    $statement->execute(array($Question_1, $_POST['id']));


    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Psych</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
        <body>
            <div style="margin-left: 20%; margin-right: 20%; margin-top: 2%;">
                <div class="row">
                    <div>
                        <img src="data:image/jpeg;base64,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">
                    </div>
              
                
                <div class="row">
                    <form method="post" target="_top">
                        <div class="questions">',$all_questions[1],'</div>
                        <input type="submit" name="question_2" value="Next" style="float: right;">
                        <br>
                        <input type="hidden" name="id" value="',$id[0],'">
                        <input type="hidden" name="ordering" value=',$order,'>
                    </form>
                </div>
            </div>
        </body>
    </html>
    ';
}

//question 3
if(isset ($_POST['question_2']) ) {
    $order = array();
    $id = exec_sql($db_connection, "SELECT * FROM questions ORDER BY ID DESC LIMIT 1");
    $sql = "SELECT Ordering FROM questions where ID = ?";
    $statement = $db_connection->prepare($sql);
    $last_id = $id[0] - 1;
    $statement->execute(array($last_id));
    $ordering = $statement->fetch();

    if ($ordering == null) {
        $permutation_number = 0;
    }else {
        $permutation_number = get_index(permutations($questions), $ordering[0]);
        $permutation_number++;
        if ($permutation_number > 5){
            $permutation_number = 0;
        }
    }
    $qsts = process(permutations($questions)[$permutation_number]);
    $all_questions = array($qsts[1] . $qsts[2], $qsts[4] . $qsts[5] , $qsts[7] . $qsts[8]);

    $Question_2 = $_POST[$order[1]];
    $statement = $db_connection->prepare("update questions set Question_2 = ? where ID = ?");
    $statement->execute(array($Question_2, $_POST['id']));

    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Psych</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
        <body>
            <div style="margin-left: 20%; margin-right: 20%; margin-top: 2%;">
                <div class="row">
                    <div>
                        <img src="data:image/jpeg;base64,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">
                    </div>
              
                
                <div class="row">
                    <form method="post" action="finish.php" target="_top">
                        <div class="questions">',$all_questions[2],'</div>
                        <input type="submit" name="questionnaire_submit" value="Next" style="float: right;">
                        <br>
                        <input type="hidden" name="id" value="',$id[0],'">
                        <input type="hidden" name="ordering" value='. $_POST['ordering'] .'>
                    </form>
                </div>
            </div>
        </body>
    </html>
    ';
}


