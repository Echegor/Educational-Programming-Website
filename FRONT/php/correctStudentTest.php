<?php
$testId = $_REQUEST["testId"];
$studentId = $_REQUEST["studentId"];
$questions = $_REQUEST["questions"];
$postfieldsRaw = array("testId" => $testId,
						"studentId" => $studentId,
						"questions" => $questions);
                    
$postfields = json_encode($postfieldsRaw);
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://web.njit.edu/~lme4/correctStudentTest.php',
    CURLOPT_USERAGENT => 'Correct Student Test',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => $postfields,
));
$result = curl_exec($curl);
curl_close($curl);
echo $result;

?>
