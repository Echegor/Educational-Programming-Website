<?php

  require_once "config.php";
  
  //JSON object
  $jQuest = json_decode(file_get_contents('php://input'), true);
  
  //Values passed.
  $title = $jQuest['name'];
  $question = $jQuest['prompt'];
  $rank = $jQuest['rank'];
  $createdBy = (int)$jQuest['createdBy'];
  $subjectId = (int)$jQuest['subjectId'];
  $functionHeader = $jQuest['functionHeader'];
  $qstInput = $jQuest['input'];
  $qstOutput = $jQuest['output'];
  
  
  //SQL query tu run against the DB for INSERT.
  $sql = "INSERT INTO TblQuestion (Question, QstTitle, QstRank, QstCreatedBy, QstSubjectID, QstFunctionHeader, QstInput, QstOutput) 
  VALUES('".$question."','".$title."','".$rank."','".$createdBy."','".$subjectId."', '".$functionHeader."', '".$qstInput."', '".$qstOutput."')";
  
  //Get Result
  $res = mysqli_query($connection, $sql) or die("Failed to save question in database " .mysql_error($connection));
  
  //mysqli_insert_id returns The value of the AUTO_INCREMENT field that was updated by the previous query.
  $questionID = mysqli_insert_id($connection);
  //$questionID = mysql_insert_id();
  
  
  //Reply JSON 
  //$jReply = array();
  $jReply['name'] = $title;
  $jReply['category'] = $subjectId;
  
  //Check for returned results
  if($res){     
  
    $jReply["id"] = $questionID;
    
    //echo the JSON object
    echo json_encode($jReply);
  }else{    
    //echo the JSON object
    echo json_encode($jReply);
  }
  
  //close the db connection
  mysqli_close($connection);
?>