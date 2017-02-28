<?php
$username= $_REQUEST["username"];
$password = $_REQUEST["password"];
//$password = password_hash($_REQUEST["password"], PASSWORD_DEFAULT);
$postfieldsRaw = array("username" => $username,
                    "password" => $password);
                    
$postfields = json_encode($postfieldsRaw);
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://web.njit.edu/~lme4/login.php',
    CURLOPT_USERAGENT => 'Login',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => $postfields,
));
$result = curl_exec($curl);
curl_close($curl);
$decoded = json_decode($result, true);

echo $result;
?>
