<?php

// BASED ON THE FILE TAKEN FROM MOODLE
//readingQuestionsAnswers.php 


include("mysqli_connect.inc.php");
include("questionAnswerClasses.inc.php");

try {
    //fetching all question types from table
    $query = "SELECT * FROM `question_types`";
    $result = $conn->query($query);
} catch (Exception $e) {
    echo "MySQLi Error Code: " . $e->getCode() . "<br />";
    echo "Exception Msg: " . $e->getMessage();
    exit();
}

// this is an associative array containing question types as values and their id as keys
$questionTypeList = array();
while ($var = $result->fetch_assoc()) {
    extract($var);
    $questionTypeList[$questionTypeID] = $questionType;
}


try {
    // joining questions and answers table
    $query = "SELECT * FROM `questions` JOIN `answers` USING(`questionID`)";
    $result = $conn->query($query);
} catch (Exception $e) {
    echo "MySQLi Error Code: " . $e->getCode() . "<br />";
    echo "Exception Msg: " . $e->getMessage();
    exit();
}

// this is the associative array consisting of questions with answers
$questionList = array();
while ($var = $result->fetch_assoc()) {
    extract($var);
    if (!array_key_exists($questionID, $questionList)) $questionList[$questionID] = new question($question, $feedback, $mark, $questionTypeID);
    $questionList[$questionID]->answerList[$answerID] = new answer($answer, $isCorrect);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <a class="navbar-brand" href="#">Question Management System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
    </nav>

    <div class="container">
        <blockquote class="blockquote text-center">
            <h1>List of Questions</h1>
        </blockquote>

        <!-- ADD QUESTİON BUTTON -->
        <button type="button" class="btn btn-success btn-lg btn-block" data-toggle="modal" data-target="#questionAddModal">
            + Add question
        </button>

        <!-- Modal for add question -->
        <div class="modal fade" id="questionAddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create new question</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="createQuestion.php" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="questionTextArea">Question</label>
                                <textarea class="form-control" name="question" id="questionTextArea" rows="2" placeholder="Enter question body" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="feedbackTextArea">Feedback</label>
                                <textarea class="form-control" name="feedback" id="feedbackTextArea" rows="2" placeholder="Enter feedback"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="markInput">Mark</label>
                                <input type="number" class="form-control" name="mark" step="any" id="markInput" min="0" placeholder="Enter mark" required>
                            </div>
                            <div class="form-group">
                                <label for="questiontypeSelect">Question Type</label>
                                <select class="form-control" id="questiontypeSelect" name="questionTypeId" onchange="showAnswers()">
                                    <?php
                                    foreach ($questionTypeList as $questionTypeID => $valueQuestionType) {
                                        echo "<option value=\"" . $questionTypeID . "\">" . $valueQuestionType . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>


                            <!-- answers -->
                            <div class="form-group" id="answerForm1" style="display: block;">
                                <label>Answer and its correctness(%)</label>
                                <div class="row mb-4">
                                    <div class="col">
                                        <div class="form-outline">
                                            <textarea name="answer1" class="form-control" rows="1" placeholder="Enter answer" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-outline">
                                            <label>
                                                <input type="number" name="correctness1" step="any" min="-100" max="100" class="form-control" required />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="answerForm2" style="display: block;">
                                <div class="row mb-4">
                                    <div class="col">
                                        <div class="form-outline">
                                            <textarea name="answer2" id="answer2" class="form-control" rows="1" placeholder="Enter answer"></textarea>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-outline">
                                            <label>
                                                <input type="number" id="correctness2" name="correctness2" step="any" min="-100" max="100" class="form-control" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="answerForm3" style="display: block;">
                                <div class="row mb-4">
                                    <div class="col">
                                        <div class="form-outline">
                                            <textarea name="answer3" id="answer3" class="form-control" rows="1" placeholder="Enter answer"></textarea>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-outline">
                                            <label>
                                                <input type="number" id="correctness3" name="correctness3" step="any" min="-100" max="100" class="form-control" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="createQuestion" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <!-- Modal for DELETE question -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Delete question </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="deleteQuestion.php" method="post">
                        <div class="modal-body">
                            <input type="hidden" name="delete_id" id="delete_id">
                            <p>Are you sure you want to delete this question?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="deleteQuestion" class="btn btn-danger">Yes sir!</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <!-- Modal for UPDATE question -->
        <div class="modal fade" id="questionEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update question</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="#" method="POST" id="updateForm">
                        <div class="modal-body" id="info_update">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="updateQuestion" id="update" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Modal for view -->
        <div class="modal fade" id="questionViewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">View question</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="#" method="POST" id="viewForm">
                        <div class="modal-body" id="info_view">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <br>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>№</th>
                    <th>Question</th>
                    <th>Type</th>
                    <th>Details</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <tbody>
                <?php
                foreach ($questionList as $keyQuestionID => $valueQuestion) {
                    echo "<tr>
                    <td>" . $keyQuestionID . "</td>
                    <td>" . $valueQuestion->question . "</td>
                    <td>" . $questionTypeList[$valueQuestion->questionTypeID] . "</td>
                    <td>
                        <button type=\"button\" id=\"$keyQuestionID\" class=\"btn btn-warning viewbtn\">View</button>
                    </td>
                    <td>
                        <button type=\"button\" id=\"$keyQuestionID\" class=\"btn btn-primary editbtn\">Update</button>
                    </td>
                    <td>
                        <button type=\"button\" class=\"btn btn-danger deletebtn\">Delete</button>
                    </td>
                </tr>";
                }
                ?>
            </tbody>

        </table>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script>
    // this function displays the correct number of answer divs corresponding to the type of question
    function showAnswers() {
        let questionTypeId = document.getElementById("questiontypeSelect").value;
        if (questionTypeId == "1") {
            document.getElementById("answerForm1").style.display = "block";
            document.getElementById("answerForm2").style.display = "block";
            document.getElementById("answerForm3").style.display = "block";

        } else if (questionTypeId == "2" || questionTypeId == "3") {
            document.getElementById("answerForm1").style.display = "block";
            document.getElementById("answerForm2").style.display = "block";
            document.getElementById("answerForm3").style.display = "none";
        } else if (questionTypeId == "4" || questionTypeId == "5") {
            document.getElementById("answerForm1").style.display = "block";
            document.getElementById("answerForm2").style.display = "none";
            document.getElementById("answerForm3").style.display = "none";
        }
    }
</script>
<script>
    $(document).ready(function() {

        //Delete script
        $('.deletebtn').on('click', function() {

            $('#deleteModal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();


            $('#delete_id').val(data[0]);

        });


        // Update script 
        $(document).on('click', '.editbtn', function() {
            var edit_id = $(this).attr('id');
            $.ajax({
                url: "updateQuestion.php",
                type: "post",
                data: {
                    edit_id: edit_id
                },
                success: function(data) {
                    $("#info_update").html(data);
                    $("#questionEditModal").modal('show');
                }
            });

        });


        $(document).on('click', '#update', function() {
            $.ajax({
                url: "saveUpdatedQuestion.php",
                type: "post",
                data: $("#updateForm").serialize(),
                success: function(data) {
                    $("#questionEditModal").modal('hide');
                    location.reload();
                }
            });
        });


        // View script
        $(document).on('click', '.viewbtn', function() {
            var view_id = $(this).attr('id');
            $.ajax({
                url: "viewQuestion.php",
                type: "post",
                data: {
                    view_id: view_id
                },
                success: function(data) {
                    $("#info_view").html(data);
                    $("#questionViewModal").modal('show');
                }
            });

        });

    });
</script>

</html>