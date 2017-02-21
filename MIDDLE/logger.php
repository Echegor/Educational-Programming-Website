<?php
	date_default_timezone_set('America/New_York');
	function logToFileFrontEnd($inText,$file)
	{
		$debug_export = var_export($inText, true);
		$myfile = fopen("log.txt", "a+") or die("Unable to open file.");
		//echo "BEGIN WRITE TO FILE: " . $myfile . "END WRITE TO FILE";
		fwrite($myfile,date("Y-m-d H:i:s") . " Received from front end to file " . $file . ":" . $inText . "\n");
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
?>