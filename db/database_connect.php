<?php
function db_connect() {
    global $dbcon;

    $dbInfo['server'] = "127.0.0.1";
    $dbInfo['database'] = "psych";
    $dbInfo['username'] = "root";
    $dbInfo['password'] = "";

    $con = "mysql:host=" . $dbInfo['server'] . "; dbname=" . $dbInfo['database'];
    $dbcon = new PDO($con, $dbInfo['username'], $dbInfo['password']);
    $dbcon->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $error = $dbcon->errorInfo();

    if($error[0] != "" && $error[0] != "0000") {
        print "<p>DATABASE CONNECTION ERROR:</p>";
        print_r($error);
    }
    return $dbcon;
}