<?php
	require_once "util.php";
	$url = "https://web.njit.edu/~jjr27/addQuestion.php";

	$parsedInput = processInput(file_get_contents('php://input'),__FILE__);
	$backend = postHelper($parsedInput,$url);
	//here is how I reply
	echo json_encode($backend);
?>