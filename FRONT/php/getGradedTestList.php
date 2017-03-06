<?php
$studentId = $_REQUEST["studentId"];
$postfieldsRaw = array("studentId" => $studentId);
                    
$postfields = json_encode($postfieldsRaw);
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://web.njit.edu/~lme4/getGradedTestList.php',
    CURLOPT_USERAGENT => 'Get Graded Test List',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => $postfields,
));
$result = curl_exec($curl);
curl_close($curl);
echo $result;

?>
