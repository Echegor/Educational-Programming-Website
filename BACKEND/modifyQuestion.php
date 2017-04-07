<?php

  require_once "config.php";

  //JSON object
  $jQuest = json_decode(file_get_contents('php://input'), true);
  
  //Values passed.
  $questionId = $jQuest['questionId'];
  $title = $jQuest['name'];
  $weight = (int)$jQuest['weight'];
  $subjectId = (int)$jQuest['category'];
  $question = $jQuest['prompt'];
  $qstInput = $jQuest['input'];
  $qstOutput = $jQuest['output'];
  $functionHeader = $jQuest['functionHeader'];
  
  
    //SQL query tu run against the DB for INSERT.
  $sql = "UPDATE TblQuestion SET QstTitle = '" . $title . "', QstWeight = " . $weight . ", QstSubjectID = " . $subjectId . ", Question = '" . $question . "', QstInput = '" . $qstInput . "', QstOutput = '" . $qstOutput . "', QstFunctionHeader = '" . $functionHeader . "' WHERE QuestionID = " . $questionId;
  
  
  //Get Result
  $res = mysqli_query($connection, $sql) or die("Failed to update question in database. " .mysql_error($connection));
  
  
  //Check for returned results
  if($res){      
    //Return json with successful transaction
    $jResp["response"] = 1;
    
    //echo the JSON object
    echo json_encode($jResp);
  }else{
    //Return json with successful transaction
    $jResp["response"] = 0;
    
    //echo the JSON object
    echo json_encode($jResp);
  }
  
  //close the db connection
  mysqli_close($connection);
?>