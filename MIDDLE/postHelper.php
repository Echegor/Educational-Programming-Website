<?php 
	require_once "logger.php";
	function postHelper($data,$url){
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