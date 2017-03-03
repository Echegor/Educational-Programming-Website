<?php

  require_once "config.php";
  
  /*
  //Testing
  $myObj = array(
      'testID' => 1,
      'questions'=>
                [
                    'questionID' => 1,
                    'questionID' => 3,
                    'questionID' => 5
                ],
          //'questionID' => 1,      
          'assignedBy' => 2,
        'dateAssigned' => "@{currentdate}",
  );
  $jQbyT = json_decode($myObj, true);
  */
  
  //convert json object to php associative array
  $jQbyT = json_decode(file_get_contents('php://input'), true);
  
  
  //Values passed.
  $questionID = (int)$jQbyT['questionID'];
  $testID = (int)$jQbyT['testID'];
  $assignedBy = (int)$jQbyT['assignedBy'];
  $dateAssigned = $jQbyT['dateAssigned'];

  /* 
  // **** Implement this for release candidate, it will allow one json object to add all questions to a test. ****
  //iterate through parameters array and save to <TblQuestionParameters>.
  for($i=0; $i<count($jQbyT['questions']); $i++) {
    //Get Values
    $questionID = (int)$jQbyT['questions'][$i]["questionID"];
    
    //SQL query tu run against the DB for INSERT.
    $sql = "INSERT INTO TblQuestionByTest (QuestionID, TestID, AssignedBy, DateAssigned) 
            VALUES('".$questionID."', '".$testID."','".$assignedBy."','".$dateAssigned."')";
    
    //Get Result
    $res = mysql_query($sql) or die("Failed to assign questions to test in database " .mysql_error());
    
  } 
  */
  
  //SQL query tu run against the DB for INSERT.
  $sql = "INSERT INTO TblQuestionByTest (QuestionID, TestID, AssignedBy, DateAssigned) 
          VALUES('".$questionID."', '".$testID."','".$assignedBy."','".$dateAssigned."')";
  
  //Get Result
  $res = mysql_query($sql) or die("Failed to assign questions to test in database " .mysql_error());
    
    
  //Check for returned results
  if($res){          
    //Return json with successful transaction
    $jQbyT["TransCompleted"] = 1;
    
    //echo the JSON object
    echo json_encode($jQbyT);
  }else{
    //Return json with successful transaction
    $jQbyT["TransCompleted"] = 0;
    
    //echo the JSON object
    echo json_encode($jQbyT);
  }
    
?>
