<?php

include("mysqli_connect.inc.php");

//checking if the URL variable exists
if (isset($_POST['deleteQuestion'])) {
    try {
        $delete_id = intval($_POST['delete_id']);
        // delete record from question table according to the question id 
        $query = "DELETE FROM `questions` WHERE `questions`.`questionID` =  $delete_id ;";
        $result = $conn->query($query);

        // delete answers corresponding to the question id
        $query = "DELETE FROM `answers` WHERE `questionID` = $delete_id ;";
        $result = $conn->query($query);

        // redirect to main page
        if ($result) {
            header('location:readingQuestionsAnswers.php');
        }
    } catch (Exception $e) {
        echo "MySQLi Error Code: " . $e->getCode() . "<br />";
        echo "Exception Msg: " . $e->getMessage();
        exit();
    }
} else {
    exit();
}
