<?php

  require_once "config.php";  
  
  //JSON object
  $jTestG = json_decode(file_get_contents('php://input'), true);
  
  //Values passed.
  $testID = (int)$jTestG['testID'];
  $userID = (int)$jTestG['studentId'];

  $testSaved = 0;
  
  for($i=0; $i<count($jTestG['questions']); $i++) {
    //Get Values
    $questionID = (int)$jTestG['questions'][$i]["questionID"];
    $newGrade = $jTestG['answers'][$i]["newGrade"];
    $remarks = $jTestG['answers'][$i]["remaks"];
    
    //SQL query tu run against the DB for INSERT.
    $sql = "UPDATE TblTestGrading SET Grade = " . $newGrde . ", remarks = " . $remaks . " WHERE TestID = " . $testID . " AND UserID = " . $userID . " AND QuestionID = " . $questiongID;
    
    //Get Result
    $res = mysql_query($sql) or die("Failed to save test taken " .mysql_error());
    
    $testSaved = 1;
  }
  
  // Convert MySQL Result Set to PHP Array  
  // Create an array
  $jReply = array();
  
  //Check for returned results
  if($testSaved){      
    
    //Return json with successful transaction
    $jReply["response"] = 1;
    
    //echo the JSON object
    echo json_encode($jReply);
  }else{
    //Return json with successful transaction
    $jReply["response"] = 0;
    
    //echo the JSON object
    echo json_encode($jReply);
  }
  
    //close the db connection
  mysqli_close($connection);
?>