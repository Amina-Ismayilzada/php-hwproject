<?php

include("mysqli_connect.inc.php");

// get updated values
$edit_id = $_POST['edit_id'];
$question = $_POST['question'];
$feedback = $_POST['feedback'];
$mark = $_POST['mark'];

try{
    // update question
    $query = "UPDATE `questions` SET `question`='$question', `feedback`='$feedback', `mark`=$mark WHERE `questionID` = $edit_id";
    $result = $conn->query($query);


    // select corresponding answers
    $query = "SELECT * FROM `answers` WHERE `answers`.`questionID` =  $edit_id";
    $result = $conn->query($query);

    // put them on array for convenience  (it's a lie, it just didn't work otherwise :) 
    $answerArray = array();
    while ($var = $result->fetch_assoc()) {
        extract($var);
        $answerArray[$answerID] = $answer;
    }

    // update answers
    $a = 1;
    foreach ($answerArray as $keyAnswerID => $valueAnswer) {
        // store in the variables for convenience
        ${"edited_answer" . $a} = $_POST['answer' . $a];
        ${"edited_correctness" . $a} = $_POST['correctness' . $a];
        // check if the updated answer is not empty
        if("" != trim(${"edited_answer" . $a}) ){
            // if correctness is empty take it as 0
            if("" == trim(${"edited_correctness" . $a})) ${"edited_correctness" . $a}=0;
            $query = "UPDATE `answers` SET `answer`= '" . ${"edited_answer" . $a} . "', `isCorrect`= " . ${"edited_correctness" . $a}  . "  WHERE `answerID` =  $keyAnswerID";
            $result = $conn->query($query);
        }
        else{
            // delete the answer if its empty
            $query = "DELETE FROM `answers` WHERE `answerID` =  $keyAnswerID";
            $result = $conn->query($query);
        }
        $a += 1;
    }
} catch (Exception $e) {
    echo "MySQLi Error Code: " . $e->getCode() . "<br />";
    echo "Exception Msg: " . $e->getMessage();
    exit();
}
