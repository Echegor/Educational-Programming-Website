<?php
$name= $_REQUEST["name"];
$weight = $_REQUEST["weight"];
$category = $_REQUEST["category"];
$prompt = $_REQUEST["prompt"];
$input = $_REQUEST["input"];
$output = $_REQUEST["output"];
$postfieldsRaw = array("title" => $name,
                    "weight" => $weight,
                    "category" => $category,
                    "prompt" => $prompt,
                    "input" => $input,
                    "output" => $output);
                    
$postfields = json_encode($postfieldsRaw);
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://web.njit.edu/~lme4/addQuestion.php',
    CURLOPT_USERAGENT => 'Test',
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => $postfields,
));
$result = curl_exec($curl);
curl_close($curl);
echo $result;
//echo $postfields;

/*$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://jsonplaceholder.typicode.com/posts',
    ));
$result = curl_exec($curl);
curl_close($curl);
echo $result;*/

?>
