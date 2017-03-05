<?php

$testId = $_REQUEST["testId"];
$userId = $_REQUEST["userId"];
$answers = $_REQUEST["answers"];
$postfieldsRaw = array("testId" => $testId,
						"studentId" => $userId,
						"answers" => $answers);
                    
$postfields = json_encode($postfieldsRaw);
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://web.njit.edu/~lme4/submitTest.php',
    CURLOPT_USERAGENT => 'Submit Test',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => $postfields,
));
$result = curl_exec($curl);
curl_close($curl);
echo $result;

?>
