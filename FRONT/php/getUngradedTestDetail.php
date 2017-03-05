<?php
$ungradedTestId = $_REQUEST["ungradedTestId"];
$postfieldsRaw = array("ungradedTestId" => $ungradedTestId);
                    
$postfields = json_encode($postfieldsRaw);
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://web.njit.edu/~lme4/getUngradedTestDetail.php',
    CURLOPT_USERAGENT => 'Get Ungraded Test Detail',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => $postfields,
));
$result = curl_exec($curl);
curl_close($curl);
echo $result;

?>
