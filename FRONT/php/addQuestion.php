<?php
$name= $_REQUEST["name"];
$weight = $_REQUEST["weight"];
$subjectId = $_REQUEST["subjectId"];
$prompt = $_REQUEST["prompt"];
$input = $_REQUEST["input"];
$output = $_REQUEST["output"];
$functionHeader = $_REQUEST["functionHeader"];
$createdBy = $_REQUEST["createdBy"];
$postfieldsRaw = array("title" => $name,
                    "weight" => $weight,
                    "subjectId" => $category,
                    "prompt" => $prompt,
                    "input" => $input,
                    "output" => $output,
                    "functionHeader" => $functionHeader,
                    "createdBy" => $createdBy);
                    
$postfields = json_encode($postfieldsRaw);
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://web.njit.edu/~lme4/addQuestion.php',
    CURLOPT_USERAGENT => 'Add Question',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => $postfields,
));
$result = curl_exec($curl);
curl_close($curl);
echo $result;

?>
