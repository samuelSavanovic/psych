<?php
require_once ('general_questions.php');
require_once ('db/database_connect.php');
require_once ('questions.php');
require_once ('util.php');

session_start();


global $questions;

check_for_javascript();

if(!isset($_POST['general_questions_submit']) && !isset($_POST['question_1']) && !isset($_POST['question_2'])) {
    general_questions();
}
$id = null;

$order = array();

if (isset($_POST['general_questions_submit'])) {
    $all_questions = get_all_questions();
    $_SESSION['all_questions'] = $all_questions;
    $_SESSION['id'] = $id[0];
    $db_connection = db_connect();
    $statement = $db_connection->prepare("update questions set Ordering = ? where ID = ?");
    $statement->execute(array(
        join($order),
        $_SESSION['id']));
   $db_connection = null;
}

if(isset($_POST['general_questions_submit']) && !isset($_POST['question_2']) ) {

    $all_questions = $_SESSION['all_questions'];

    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Psych</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
        <body>
            <div style="margin-left: auto; margin-right: auto; margin-top: 2%; max-width: 500px;">
                <div class="row">
                    <div>
                        <img src="pic.jpg">
                    </div>
              
                
                <div class="row">
                    <form method="post" target="_top">
                        <div class="questions">',$all_questions[0],'</div>
                        <input onclick="window.onbeforeunload=undefined;" type="submit" name="question_1" value="Next" style="float: right;" id="question_button" disabled>
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
    $all_questions =  $_SESSION['all_questions'];

    $order = $_POST['ordering'];
    $Question_1 = $_POST[$order[0]];
    $_SESSION['question_1'] = $Question_1;

    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Psych</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
        <body>
            <div style="margin-left: auto; margin-right: auto; margin-top: 2%; max-width: 500px;">
                <div class="row">
                    <div>
                        <img src="pic.jpg
">
                    </div>
              
                
                <div class="row">
                    <form method="post" target="_top">
                        <div class="questions">',$all_questions[1],'</div>
                        <input type="submit" onclick="window.onbeforeunload=undefined;" name="question_2" value="Next" style="float: right;" id="question_button" disabled>
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

    $all_questions = $_SESSION['all_questions'];
    $order = $_POST['ordering'];
    $Question_2 = $_POST[$order[1]];
    $_SESSION['question_2'] = $Question_2;


    echo '
    <!DOCTYPE html>
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Psych</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
        <body>
            <div style="margin-left: auto; margin-right: auto; margin-top: 2%; max-width: 500px;">
                <div class="row">
                    <div>
                        <img src="pic.jpg
">
                    </div>
              
                
                <div class="row">
                    <form method="post" action="finish.php" target="_top">
                        <div class="questions">',$all_questions[2],'</div>
                        <input type="submit" onclick="window.onbeforeunload=undefined;" name="questionnaire_submit" value="Next" style="float: right;" id="question_button" disabled>
                        <br>
                        <input type="hidden" name="id" value="',$_SESSION['id'],'">
                        <input type="hidden" name="ordering" value='. $_POST['ordering'] .'>
                        <input type="hidden" name="question_1" value='. $_SESSION['question_1'] .'>
                        <input type="hidden" name="question_2" value='. $_SESSION['question_2'] .'>

                    </form>
                </div>
            </div>
        </body>
    </html>
    ';

}
