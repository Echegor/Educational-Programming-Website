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
		processLines();
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
	function processLines(){
		$lines = count(file("log.txt")) - 1;
		if($lines>35){
			unlink("log.txt");
		}
	}
	function postHelper($data,$url){
		$data = json_encode($data);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		logToFileBackEnd($result);
		//echo "<br>BEGIN BACKEND raw result:" . $result . "<br>";
		curl_close($ch);	
		return json_decode($result,true);
	}
?>