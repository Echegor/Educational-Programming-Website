<?php
$studentId = $_REQUEST["studentId"];
$gradedTestId = $_REQUEST["testId"];
$postfieldsRaw = array("studentId" => $studentId,
						"gradedTestId" => $gradedTestId);
                    
$postfields = json_encode($postfieldsRaw);
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://web.njit.edu/~lme4/getGradedTest.php',
    CURLOPT_USERAGENT => 'Get Graded Test',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => $postfields,
));
$result = curl_exec($curl);
curl_close($curl);
echo $result;

?>
