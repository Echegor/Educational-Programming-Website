<?php
/*
	“id” : “string”				// The ID of the test
	“username” : “string”			// Name of the student who took this test
	“answers” : “array of JSON(GradedQuestion)”
	“totalGrade” : “integer”
*/
	require_once "util.php";
	require_once "postHelper.php";

	$parsedInput = processInput(file_get_contents('php://input'));
?>