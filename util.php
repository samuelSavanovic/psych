<?php
require_once ('db/database_connect.php');
$db_connection = db_connect();

$questions = array("Do you like this painting?",
    "Would you hang this painting on your wall?",
    "Do you think this painting is expensive?");

function check_for_javascript() {
    echo '<script type="text/javascript">window.onbeforeunload = function (e) {
    var e = e || window.event;
  //IE & Firefox
  if (e) {
    e.returnValue = \'Are you sure?\';
  }

  // For Safari
  return \'Are you sure?\';
    };
    </script>';
    echo '<noscript> <META HTTP-EQUIV="Refresh" CONTENT="0;URL=error_page.html"></noscript>';
    function exec_sql($db_connection, $sql) {
        $statement = $db_connection->prepare($sql);
        $statement->execute();
        return $statement->fetch();
    }

}

function check_last_non_null($id, $db_connection) {
    $sql = "SELECT Ordering FROM questions where ID = ? FOR UPDATE";
    $statement = $db_connection->prepare($sql);
    $statement->execute(array($id));
    $ordering = $statement->fetch();
    if ($id <= 0) {
        return null;
    }
    if ($ordering[0] != null) {

        return $ordering;
    }
    return check_last_non_null($id-1, $db_connection);
}

function get_all_questions() {
    global $db_connection;
    global $questions;
    $sql = "INSERT INTO questions (First_Trial, Gender, Age) VALUES (?, ?, ?)";
    $statement = $db_connection->prepare($sql);
    $statement->execute(array($_POST['first_time_participating'], $_POST['gender'], $_POST['age']));
    global $id;
    $id = exec_sql($db_connection, "SELECT * FROM questions ORDER BY ID DESC LIMIT 1 FOR UPDATE");
    $ordering = check_last_non_null($id[0], $db_connection);

    if ($ordering == null) {
        echo 'here';
        $permutation_number = 0;
    }else {
        $permutation_number = get_index(permutations($questions), $ordering[0]);
        $permutation_number++;
        if ($permutation_number > 5){
            $permutation_number = 0;
        }
    }
    $qsts = process(permutations($questions)[$permutation_number]);
    $db_connection = null;
    return array($qsts[1] . $qsts[2], $qsts[4] . $qsts[5] , $qsts[7] . $qsts[8]);
}

