<?php
$userId = $_REQUEST["userId"];
$postfieldsRaw = array("userId" => $userId,
						"userid" => $userId); // Having two different versions of this just in case
                    
$postfields = json_encode($postfieldsRaw);
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://web.njit.edu/~lme4/pickTest.php',
    CURLOPT_USERAGENT => 'Get Test List',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => $postfields,
));
$result = curl_exec($curl);
curl_close($curl);
echo $result;

?>
