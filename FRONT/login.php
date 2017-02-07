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

/*echo "<br>";
echo 'NJIT:' . $decoded['NJIT'] . "<br>"; 
echo 'BACKEND:' . $decoded['BACKEND'] . "<br><br>"; 
echo "Information Passed In: <br>";
echo 'username:' . $postfieldsRaw['username'] . "<br>";
echo 'password:' . $postfieldsRaw['password'] . "<br><br>";
echo "Raw Response: <br>" . $result . "<br>";*/
echo $result;
?>
