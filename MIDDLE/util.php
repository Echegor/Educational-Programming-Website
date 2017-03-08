<?php
	date_default_timezone_set('America/New_York');
	function logToFileFrontEnd($inText,$file)
	{
		$debug_export = var_export($inText, true);
		$myfile = fopen("log.txt", "a+") or die("Unable to open file.");
		//echo "BEGIN WRITE TO FILE: " . $myfile . "END WRITE TO FILE";
		fwrite($myfile, date("Y-m-d H:i:s") . " Received from front end to file " . $file . ":" . $debug_export . "\n");
		fclose($myfile);
	}
	function logToFileBackEnd($inText)
	{
		processLines();
		$debug_export = var_export($inText, true);
		$myfile = fopen("log.txt", "a+") or die("Unable to open file.");
		//echo "BEGIN WRITE TO FILE: " . $myfile . "END WRITE TO FILE";
		fwrite($myfile,date("Y-m-d H:i:s") . " Received from back end:" . $debug_export . "\n");
		fclose($myfile);
	}
	function logToFileSendingToBackend($inText,$url)
	{
		processLines();
		$debug_export = var_export($inText, true);
		$myfile = fopen("log.txt", "a+") or die("Unable to open file.");
		//echo "BEGIN WRITE TO FILE: " . $myfile . "END WRITE TO FILE";
		fwrite($myfile,date("Y-m-d H:i:s") . " Middle Sending to backend:" . $url . ":" . $debug_export . "\n");
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
	function processLines(){
		$lines = count(file("log.txt")) - 1;
		if($lines>35){
			unlink("log.txt");
		}
	}
	function postHelper($data,$url){
		$postData = json_encode($data);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$postData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		logToFileBackEnd($result);
		// echo "<br>BEGIN BACKEND raw result:" . $result . "<br>";
		curl_close($ch);
		$assocArray = json_decode($result,true);
		if(empty($assocArray)){
			return 0;
		}	
		return $assocArray;
	}
	function postFromMiddle($data,$url){
		logToFileSendingToBackend(json_encode($data),$url);
		return postHelper($data,$url);
	}
	function debugLog($inText)
	{
		processLines();
		$debug_export = var_export($inText, true);
		$myfile = fopen("debugLog.txt", "a+") or die("Unable to open file.");
		//echo "BEGIN WRITE TO FILE: " . $myfile . "END WRITE TO FILE";
		fwrite($myfile,date("Y-m-d H:i:s") . ":" . $debug_export . "\n");
		fclose($myfile);
	}
?>