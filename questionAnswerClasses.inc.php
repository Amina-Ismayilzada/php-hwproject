<?php

// FILE TAKEN FROM MOODLE
// i took the database sample structure from moodle as well
// and honestly, i didn't use this file much, which is i guess bad
// but thanks for patience while checking my 'clean' code :)

//questionAnswerClasses.inc.php
//questionID and answerID are not needed as properties,
//because already used as an index of arrays

//properties are the columns of the questions table  
class question
{
	public $question;
	public $feedback;
	// float value
	public $mark;
	public $questionTypeID; //type of question
	public $answerList;  //list of answers

	public function __construct($question, $feedback, $mark, $questionTypeID)
	{
		$this->question = $question;
		$this->feedback = $feedback;
		$this->questionTypeID = $questionTypeID;
		$this->mark = floatval($mark);
		$this->answerList = array();
	}
}

//properties are the columns of the answers table  
class answer
{
	public $answer;
	// float value
	public $isCorrect; // correctness persentage 

	public function __construct($answer, $isCorrect)
	{
		$this->answer = $answer;
		// make sure this is a float value, since the correctness maybe 33.3333 for example
		$this->isCorrect = floatval($isCorrect);
	}
}
