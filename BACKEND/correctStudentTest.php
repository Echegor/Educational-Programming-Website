<?php

  require_once "config.php";  
  
  //JSON object
  $jTestG = json_decode(file_get_contents('php://input'), true);
  
  //Values passed.
  $testID = (int)$jTestG['testId'];
  $userID = (int)$jTestG['studentId'];

  $testSaved = 0;
  
  for($i=0; $i<count($jTestG['questions']); $i++) {
    //Get Values
    $questionID = (int)$jTestG['questions'][$i]["questionId"];
    $newGrade = $jTestG['questions'][$i]["newGrade"];
    $remarks = $jTestG['questions'][$i]["remarks"];
    
    
    //SQL query tu run against the DB for UPDATE.
    $sql = "UPDATE TblTestGrading SET Grade = " . $newGrade . ", remarks = '" . $remarks . "', released = 1 WHERE TestID = " . $testID . " AND UserID = " . $userID . " AND QuestionID = " . $questionID;

    //Get Result
    $res = mysqli_query($connection, $sql) or die("Failed to save test taken " .mysqli_error($connection));
    
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