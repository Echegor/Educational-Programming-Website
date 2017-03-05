<?php
$testName = $_REQUEST["testName"];
$testDescription = $_REQUEST["testDescription"];
$creatorId = $_REQUEST["creatorId"];
$questionList= $_REQUEST["questionList"];

$postfieldsRaw = array("questionList" => $questionList,
						"testName" => $testName,
						"creatorId" => $creatorId,
						"testDescription" => $testDescription);
                    
$postfields = json_encode($postfieldsRaw);
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://web.njit.edu/~lme4/addTest.php',
    CURLOPT_USERAGENT => 'Add Test',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => $postfields,
));
$result = curl_exec($curl);
curl_close($curl);
echo $result;

?>
