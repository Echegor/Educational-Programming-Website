<?php
$username= $_REQUEST["username"];
$password = $_REQUEST["password"];
//$password = password_hash($_REQUEST["password"], PASSWORD_DEFAULT);
$accountType = $_REQUEST["accountType"];
$firstName = $_REQUEST["firstName"];
$lastName = $_REQUEST["lastName"];
$postfieldsRaw = array("username" => $username,
                    "password" => $password,
                    "accountType" => $accountType,
		    "firstName" => $firstName,
		    "lastName" => $lastName);
                    
$postfields = json_encode($postfieldsRaw);
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://web.njit.edu/~lme4/addUser.php',
    CURLOPT_USERAGENT => 'Register',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => $postfields,
));
$result = curl_exec($curl);
curl_close($curl);
$decoded = json_decode($result, true);

echo $result;
?>
