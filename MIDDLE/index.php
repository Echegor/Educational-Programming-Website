<?php
	//error_reporting(E_ALL); ini_set('display_errors','1');
	$input = file_get_contents('php://input');

	//here I check if I got a POST command
	logToFileFrontEnd($input);
	if($input==FALSE){
		echo "BEGIN Dumping php://input due to bad input<br>";
		var_dump($input);
		echo "DONE OUTPUTTING BAD INPUT";
	}
	else {
		$parsedInput = json_decode($input,true);
		//var_dump($parsedInput);

		//here I add stuff to the associate array I got
		$parsedInput['NJIT'] = loginToNJIT($parsedInput['username'],$parsedInput['password']);

		//just add BACKEND to your $parsedInput with 0 or 1 for the result.
		$parsedInput['BACKEND'] = loginToBackEnd($parsedInput);

		//here is how I reply
		echo json_encode($parsedInput);
	}

	function logToFileFrontEnd($inText)
	{
		$debug_export = var_export($inText, true);
		$myfile = fopen("log.txt", "a+") or die("Unable to open file.");
		//echo "BEGIN WRITE TO FILE: " . $myfile . "END WRITE TO FILE";
		fwrite($myfile,date("Y-m-d H:i:s"));
		fwrite($myfile, " Received from front end:");
		fwrite($myfile, $inText);
		fwrite($myfile, "\n");
		fclose($myfile);
	}
	function logToFileBackEnd($inText)
	{
		$debug_export = var_export($inText, true);
		$myfile = fopen("log.txt", "a+") or die("Unable to open file.");
		//echo "BEGIN WRITE TO FILE: " . $myfile . "END WRITE TO FILE";
		fwrite($myfile,date("Y-m-d H:i:s"));
		fwrite($myfile, " Received from back end:");
		fwrite($myfile, $inText);
		fwrite($myfile, "\n");
		fclose($myfile);
	}

	function loginToNJIT($username, $password){
		$infoArray = array(
			"user" => $username,
			"pass" => $password,
			"uuid" => "0xACA021"
		);

		$goodUrl = "loginok.html";
		//url econde the data looks like this: 
		//pass=MYPASSWORD&user=lme4&uuid=0xACA021 
		//what is uuid?? 
		$output = http_build_query($infoArray);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://cp4.njit.edu/cp/home/login");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$output);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		//echo "<br>START result<br>" . $result . "<br>DONE RESULT <br>";
		curl_close($ch);

		/*
		<html>
			<head>
				<script Language="JavaScript">
					document.location="http://cp4.njit.edu/cps/welcome/loginok.html";
				</script>
			</head>
			<body></body>
		</html>
		*/
		logoutNJIT();
		if(strpos($result, $goodUrl) !== false){
			return 1;
		}
		else 
			return 0;
	}
	function logoutNJIT(){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://cp4.njit.edu/up/Logout?uP_tparam=frm&frm=");
		curl_exec($ch);
		curl_close($ch);
	}

	function loginToBackEnd($data)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~jjr27/login.php");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($ch);
		logToFileBackEnd($result);
		//echo "<br>BEGIN BACKEND raw result:" . $result . "<br>";
		$parsedResult = json_decode($result,true);
		curl_close($ch);

		if(isset($parsedResult['BACKEND'])){
			//echo "Backend has sent:" . $parsedResult['BACKEND'];
			return $parsedResult['BACKEND'];
		}

		echo "<br>DONE BACKEND raw result:";
		echo "<br>BEGIN BACKEND JSON DUMP:";
		var_dump($parsedResult); 
		echo "<br>DONE BACKEND JSON DUMP<br>";
		

		return 0;
	}

?>

