<?php

include("mysqli_connect.inc.php");
include("questionAnswerClasses.inc.php");


if (isset($_POST['createQuestion'])) {
    try {
        // insert question
        $query = "INSERT INTO `questions` (`question`, `feedback`, `mark`, `questionTypeID`) VALUES ('" . $_POST['question'] . "', '" . $_POST['feedback'] . "', " . $_POST['mark'] . ", " . $_POST['questionTypeId'] . " );";
        $result = $conn->query($query);

        // get the id of last inserted question
        $question_id = $conn->insert_id;
        // type id
        $questionTypeId = $_POST['questionTypeId'];

        // depending on type number of answers differ

        for ($a = 1; $a <= 3; $a++) {
            ${"answer" . $a} = $_POST['answer' . $a];
            ${"correctness" . $a} =  $_POST['correctness' . $a];
            // check if the answer is not empty
            if ("" != trim(${"answer" . $a})) {
                // if the correctness not given, take at 0
                if("" == trim(${"correctness" . $a})) ${"correctness" . $a}=  0;
                $query = "INSERT INTO `answers` (`answer`, `isCorrect`, `questionID`) VALUES ('" . ${"answer" . $a} . "', " .${"correctness" . $a} . ", " . $question_id . ");";
                $result = $conn->query($query);
            }
        }
    } catch (Exception $e) {
        echo "MySQLi Error Code: " . $e->getCode() . "<br />";
        echo "Exception Msg: " . $e->getMessage();
        exit();
    }

    // redirect to main page
    if ($result) {
        header('location:readingQuestionsAnswers.php');
    } else {
        die(mysqli_error($conn));
    }
}
