<?php
	require_once "util.php";
	require_once "postHelper.php";

	$parsedInput = processInput(file_get_contents('php://input'),__FILE__);

	$url = "https://web.njit.edu/~jjr27/addUser.php";
	$backend = postHelper($parsedInput,$url);
	//here is how I reply
	echo json_encode($backend);
?>