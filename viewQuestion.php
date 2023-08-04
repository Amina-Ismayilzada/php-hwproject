<?php

include("mysqli_connect.inc.php");

//checking if the URL variable exists
if (isset($_POST['view_id'])) {
  try {
    $view_id = intval($_POST['view_id']);

    // fetch the question with its question type
    $query = "SELECT * FROM `questions` JOIN `question_types` USING (`questionTypeID`) WHERE `questionID`=$view_id";
    $result = $conn->query($query);

    // create php variables which hold the corresponding data
    while ($row = mysqli_fetch_array($result)) {
      $question = $row['question'];
      $feedback = $row['feedback'];
      $mark = $row['mark'];
      $questionType = $row['questionType'];
    }

    // fetch the answers corresponding to given question id
    $query = "SELECT * FROM `answers` WHERE `questionID`=$view_id";
    $result = $conn->query($query);


    // create php variables(answer1, answer2, ...) which hold the corresponding data
    $a = 1;
    while ($row = mysqli_fetch_array($result)) {
      ${"answer" . $a} = $row['answer'];
      ${"correctness" . $a} = $row['isCorrect'];
      $a++;
    }
  } catch (Exception $e) {
    echo "MySQLi Error Code: " . $e->getCode() . "<br />";
    echo "Exception Msg: " . $e->getMessage();
    exit();
  }
} else {
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
  <h1>Question № <?php echo $view_id ?> </h1>
  <br>
  <h5>Question :</h5>
  <article><?php echo $question ?></article>
  <br>
  <h5>Feedback : </h5>
  <article>
    <?php
    // check if feedback is empty
    if ("" == trim($feedback)) {
      echo "--";
    } else {
      echo $feedback;
    }
    ?>
  </article>
  <br>
  <h5>Type : </h5>
  <p><?php echo $questionType ?></p>
  <br>
  <h5>Mark : </h5>
  <p><?php echo $mark ?></p>
  <h5>Answers : </h5>
  <ol>
    <?php
    for ($a = 1; $a <= 3; $a++) {
      // if there is an answer and its correctness is bigger than 0, then it's the correct answer
      if (isset(${"answer" . $a}) && ${"correctness" . $a} > 0) {
        echo "<li><p style=\"color: blue;\">" . ${"answer" . $a} . " ✓ </p></li>";
      } 
      // if there is an answer and its correctness is less or equal to 0, then it's the wrong answer
      else if (isset(${"answer" . $a}) && ${"correctness" . $a} <= 0) {
        echo "<li><p style=\"color: red;\">" . ${"answer" . $a} . " ✗ </p></li>";
      }
    }
    ?>
  </ol>
</body>

</html>