<?php

  require_once "config.php";
  /*
  $myObj = array(
		  "TestDescription"  => "Test1",
		  "CreatedBy"     => 1,
	    "DateCreated"  => "@{currentdate}",
  );
  */
  
  
  //JSON object
  $jTest = json_decode(file_get_contents('php://input'), true);
  //$jQuest = json_decode($myObj, true);
  
  //Values passed.
  $testName = $jTest['dateAdded'];
  $testDesc = $jTest['TestDesc'];
  $createdBy = (int)$jTest['creatorID'];

  //SQL query tu run against the DB for INSERT.
  $sql = "INSERT INTO TblTest (TestName, TestDesc, CreatedBy) 
  VALUES('".$testName."','".$testDesc."','".$addedBy."')";
  
  //Get Result
  $res = mysqli_query($connection, $sql) or die("Failed to save test in database " .mysql_error());
  
  //mysqli_insert_id returns The value of the AUTO_INCREMENT field that was updated by the previous query.
  $testID = mysqli_insert_id($mysqli);

  //Reply JSON 
  $jReply["testName"] = $title;
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
      $res = mysql_query($sql) or die("Failed to assign questions to test in database " .mysql_error());
      
    }
    
    //echo the JSON object
    echo json_encode($jReply);
  }else{
    /*
    //Return json with successful transaction
    $jTest["TransCompleted"] = 0;
    
    //echo the JSON object
    echo json_encode($jTest);
    /*
  }
  
  //close the db connection
  mysqli_close($connection);
  v
?>