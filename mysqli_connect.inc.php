<?php
//display_errors
ini_set("display_errors", 1);

//arguments, parameters
$host = "localhost";
$user = "id20096670_root";
$passwd = "3@9+ws&pZN}}-|tx";
$db = "id20096670_backend_hw_project";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    //instance of mysqli class
    $conn = new mysqli($host, $user, $passwd, $db);
    //set_charset("utf8"), method of mysqli class
    mysqli_set_charset($conn, "utf8");
} catch (mysqli_sql_exception $e) {
    echo "MySQLi Error Code: " . $e->getCode() . "<br />";
    echo "Exception Msg: " . $e->getMessage();
    exit();
}