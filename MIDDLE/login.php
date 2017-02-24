<?php
	require_once "util.php";
	require_once "postHelper.php";

	$parsedInput = processInput(file_get_contents('php://input'));

	//var_dump($parsedInput);
	//here I add stuff to the associate array I got
	$parsedInput['NJIT'] = loginToNJIT($parsedInput['username'],$parsedInput['password']);
	//just add BACKEND to your $parsedInput with 0 or 1 for the result.
	$parsedInput['BACKEND'] = loginToBackEnd($parsedInput);
	//here is how I reply
	echo json_encode($parsedInput);

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
		$url = "https://web.njit.edu/~jjr27/login.php";
		$parsedResult = postHelper($data,$url);
		if(isset($parsedResult['BACKEND'])){
			//echo "Backend has sent:" . $parsedResult['BACKEND'];
			return $parsedResult['BACKEND'];
		}
		return 0;
	}
?>