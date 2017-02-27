<?php
	date_default_timezone_set('America/New_York');
	function logToFileFrontEnd($inText,$file)
	{
		$debug_export = var_export($inText, true);
		$myfile = fopen("log.txt", "a+") or die("Unable to open file.");
		//echo "BEGIN WRITE TO FILE: " . $myfile . "END WRITE TO FILE";
		fwrite($myfile, date("Y-m-d H:i:s") . " Received from front end to file " . $file . ":" . $inText . "\n");
		fclose($myfile);
	}
	function logToFileBackEnd($inText)
	{
		$debug_export = var_export($inText, true);
		$myfile = fopen("log.txt", "a+") or die("Unable to open file.");
		//echo "BEGIN WRITE TO FILE: " . $myfile . "END WRITE TO FILE";
		fwrite($myfile,date("Y-m-d H:i:s") . " Received from back end:" . $inText . "\n");
		fclose($myfile);
	}
	function processInput($input,$file)
	{
		//here I check if I got a POST command
		logToFileFrontEnd($input,$file);
		if($input==FALSE){
			// echo "BEGIN Dumping php://input. Did not Submit POST";
			// var_dump($input);
			// echo "DONE OUTPUTTING BAD INPUT";

			exit($input);
		}
		else {
			$parsedInput = json_decode($input,true);
			//echo "Luis has not gotten to this";
			return $parsedInput;
		}
	}
?>