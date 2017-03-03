<?php

  require_once "config.php";
  /*
  $myObj = array(
		  "TestDescription"  => "Test1",
		  "CreatedBy"     => 1,
	    "DateCreated"  => #2017/05/01#,
  );
  */
  
  
  //JSON object
  $jTest = json_decode(file_get_contents('php://input'), true);
  //$jQuest = json_decode($myObj, true);
  
  //Values passed.
  $testDesc = $jTest['testDesc'];
  $addedBy = $jTest['addedBy'];
  $dateAdded = $jTest['dateAdded'];

  
  //SQL query tu run against the DB for INSERT.
  $sql = "INSERT INTO TblTest (TestDesc, AddedBy, DateAdded) 
  VALUES('".$testDesc."','".$addedBy."','".$dateAdded."')";
  
  //Get Result
  //$res = $mysqli->query($sql) or die("Failed to save question in database " .mysql_error());
  $res = mysql_query($sql) or die("Failed to save test in database " .mysql_error());
  
  //mysqli_insert_id returns The value of the AUTO_INCREMENT field that was updated by the previous query.
  //$questionID = mysqli_insert_id($mysqli);
  $testID = mysql_insert_id();
  
  //Check for returned results
  if($res){      
    
    $jTest["TestID"] = $testID;
    
    //Return json with successful transaction
    $jTest["TransCompleted"] = 1;
    
    
    //echo the JSON object
    echo json_encode($jTest);
  }else{
    //Return json with successful transaction
    $jTest["TransCompleted"] = 0;
    
    //echo the JSON object
    echo json_encode($jTest);
  }
?>
