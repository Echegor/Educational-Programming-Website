<?php
	require_once "logger.php";
	require_once "postHelper.php";
	$input = file_get_contents('php://input');
	//here I check if I got a POST command
	logToFileFrontEnd($input,__FILE__);
	if($input==FALSE){
		echo "BEGIN Dumping php://input. Did not Submit POST";
		var_dump($input);
		echo "DONE OUTPUTTING BAD INPUT";
	}
	else {
		$parsedInput = json_decode($input,true);
		echo "Luis has not gotten to this";
	}
	
?>