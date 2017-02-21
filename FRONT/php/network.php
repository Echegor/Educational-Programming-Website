<?php
$username= $_REQUEST["ucid"];
$password = $_REQUEST["password"];
$postfieldsRaw = array("username" => $username,
                    "password" => $password);
                    
$postfields = json_encode($postfieldsRaw);
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://web.njit.edu/~lme4/index.php',
    CURLOPT_USERAGENT => 'Test',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => $postfields,
));
$result = curl_exec($curl);
curl_close($curl);
$decoded = json_decode($result, true);

echo $result;
?>