<?php
include("mysqli_connect.inc.php");

//checking if the URL variable exists
if (isset($_POST['edit_id'])) {
    try {
        $edit_id = $_POST['edit_id'];
        // fetch the question to edit
        $query = "SELECT * FROM `questions` WHERE `questions`.`questionID` =  $edit_id";
        $result = $conn->query($query);

        // fetch its data
        while ($row = mysqli_fetch_array($result)) {
            $question = $row['question'];
            $feedback = $row['feedback'];
            $mark = $row['mark'];
        }

        // fetch question's answers
        $query = "SELECT * FROM `answers` WHERE `answers`.`questionID` =  $edit_id";
        $result = $conn->query($query);

        // store them in dinamically named variables 
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <!-- This is UPDATE modal body -->
    <input type="hidden" name="edit_id" id="edit_id" value="<?php echo $edit_id ?>">

    <div class="form-group">
        <label for="questionTextArea">Question</label>
        <textarea class="form-control" name="question" id="questionTextArea" rows="2" placeholder="Enter question body" required><?php echo $question ?></textarea>
    </div>
    <div class="form-group">
        <label for="feedbackTextArea">Feedback</label>
        <textarea class="form-control" name="feedback" id="feedbackTextArea" rows="2" placeholder="Enter feedback"><?php echo $feedback ?></textarea>
    </div>
    <div class="form-group">
        <label for="markInput">Mark</label>
        <input type="number" class="form-control" name="mark" step="any" id="markInput" min="0" placeholder="Enter mark" value="<?php echo $mark ?>" required>
    </div>

    <div class="form-group" id="answerForm1" style="display: block;">
        <label>Answer and its correctness(%)</label>
        <div class="row mb-4">
            <div class="col">
                <div class="form-outline">
                    <textarea name="answer1" class="form-control" rows="1" placeholder="Enter answer" required><?php echo $answer1 ?></textarea>
                </div>
            </div>
            <div class="col">
                <div class="form-outline">
                    <label>
                        <input type="number" name="correctness1" step="any" min="-100" max="100" class="form-control" value="<?php echo $correctness1 ?>" required />
                    </label>
                </div>
            </div>
        </div>
    </div>

    <?php
    // check if question has another answer
    if (isset($answer2)) {
    ?>
        <div class="form-group" id="answerForm2" style="display: block;">
            <div class="row mb-4">
                <div class="col">
                    <div class="form-outline">
                        <textarea name="answer2" id="answer2" class="form-control" rows="1" placeholder="Enter answer"><?php echo $answer2 ?></textarea>
                    </div>
                </div>
                <div class="col">
                    <div class="form-outline">
                        <label>
                            <input type="number" id="correctness2" name="correctness2" step="any" min="-100" max="100" class="form-control" value="<?php echo $correctness2 ?>" />
                        </label>
                    </div>
                </div>
            </div>
        </div>

    <?php
    }
    ?>

    <?php
    // check if question has 3rd answer
    if (isset($answer3)) {
    ?>
        <div class="form-group" id="answerForm3" style="display: block;">
            <div class="row mb-4">
                <div class="col">
                    <div class="form-outline">
                        <textarea name="answer3" id="answer3" class="form-control" rows="1" placeholder="Enter answer"><?php echo $answer3 ?></textarea>
                    </div>
                </div>
                <div class="col">
                    <div class="form-outline">
                        <label>
                            <input type="number" id="correctness3" name="correctness3" step="any" min="-100" max="100" class="form-control" value="<?php echo $correctness3 ?>" />
                        </label>
                    </div>
                </div>
            </div>
        </div>

    <?php
    }
    ?>
</body>

</html>