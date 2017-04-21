<?php

$url = 'https://api.sendgrid.com/';
$user = 'azure_c5300a5f42aaf518c976ee5aa9e0aa2d@azure.com';
$pass = 'aA123456789)';

$params = array(
 'api_user' => $user,
 'api_key' => $pass,
 'to' =>'ad473@njit.edu',
 'subject' => 'Test of Smart Home Email Notification',
 'html' => '<h1> IMPORTANT!! This is an alert. (generated from jjr27 site) </h1>',
 'text' => 'E-Mail Alerts System TEST*',
 'from' => 'james.restrepo@outlook.com'
);

$request = $url.'api/mail.send.json';

// Generate curl request
$session = curl_init($request);

// Tell curl to use HTTP POST
curl_setopt ($session, CURLOPT_POST, true);

// Tell curl that this is the body of the POST
curl_setopt ($session, CURLOPT_POSTFIELDS, $params);

// Tell curl not to return headers, but do return the response
curl_setopt($session, CURLOPT_HEADER, false);
curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

// obtain response
$response = curl_exec($session);
curl_close($session);

// print everything out
//print_r($response);

?>