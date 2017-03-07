<?php

  require_once "config.php";
  //JSON object
  $jTest = json_decode(file_get_contents('php://input'), true);
  
  //Values passed.
  $testName = $jTest['testName'];
  $testDesc = $jTest['testDesc'];
  $createdBy = (int)$jTest['creatorId'];

  //SQL query tu run against the DB for INSERT.
  $sql = "INSERT INTO TblTest (TestName, TestDesc, CreatedBy) 
  VALUES('".$testName."','".$testDesc."','".$createdBy."')";
  
  //Get Result
  $res = mysqli_query($connection, $sql) or die("Failed to save test in database " . mysqli_error($connection));
  
  //mysqli_insert_id returns The value of the AUTO_INCREMENT field that was updated by the previous query.
  $testID = mysqli_insert_id($connection);

  //Reply JSON 
  $jReply["testName"] = $testName;
  $jReply["testid"] = $testID;
  
  //Check for returned results
  if($res){      
    
    //iterate through parameters array and save to <TblQuestionParameters>.
    for($i=0; $i<count($jTest['questionIDs']); $i++) {
      //Get Values
      $questionID = (int)$jTest['questionIDs'][$i]["questionID"];
      $weight = (int)$jTest['questionIDs'][$i]["weight"];
      
      //SQL query tu run against the DB for INSERT.
      $sql = "INSERT INTO TblQuestionByTest (QuestionID, TestID, AssignedBy, tWeight) 
              VALUES('".$questionID."', '".$testID."','".$createdBy."','".$weight."')";
      
      //Get Result
      $res = mysqli_query($connection, $sql) or die("Failed to assign questions to test in database " .mysql_error($connection));
    }
    
    //echo the JSON object
    echo json_encode($jReply);
  }else{
    /*
    //Return json with successful transaction
    $jTest["TransCompleted"] = 0;
    
    //echo the JSON object
    echo json_encode($jTest);
    */
  }
  
  //close the db connection
  mysqli_close($connection);
  
?>