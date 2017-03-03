<?php

  require_once "config.php";
  /*
  $myObj = array(
		  "question"  => "question1",
		  "title"     => "Question1",
	    "question"  => "This is the first question.",
	    "alternAns" => "",
	    "weight"    => 5,
	    "CreatedBy" => 1,
	    "creationDate" => "2014-03-12T13 => 37 => 27+00 => 00",
	    "subjectId" => 1,
	    "qstParameters" =>  array(
	        array("parameter" => "pm1", "parameterType" => "string" ),
	        array("parameter" => "pm2", "parameterType" => "int" ),
	        array("parameter" => "pm3", "parameterType" => "bool" )
	                      ),
	    "expectedOutput" => "Here is the OUTPUT"
  );
  */
  
  
  //JSON object
  $jQuest = json_decode(file_get_contents('php://input'), true);
  //$jQuest = json_decode($myObj, true);
  
  //Values passed.
  $title = $jquest['title'];
  $question = $jQuest['prompt'];
  $alterAns = $jQuest['alterAns'];
  $weight = $jQuest['weight'];
  $createdBy = $jQuest['createdBy'];
  $creationDate = $jQuest['creationDate'];
  $subjectId = $jQuest['subjectId'];
  $expectedOutput = $jQuest['expectedOutput'];
  
  //SQL query tu run against the DB for INSERT.
  $sql = "INSERT INTO TblQuestion (Question, QstTitle, QstAlternativeAns, QstWeight, QstCreatedBy, QstCreationDate, QstSubjectID, QstExpectedOutput) 
  VALUES('".$question."','".$title."','".$alterAns."','".$weight."','".$createdBy."', '".$creationDate."','".$subjectId."', '".$expectedOutput."')";
  
  //Get Result
  //$res = $mysqli->query($sql) or die("Failed to save question in database " .mysql_error());
  $res = mysql_query($sql) or die("Failed to save question in database " .mysql_error());
  
  //mysqli_insert_id returns The value of the AUTO_INCREMENT field that was updated by the previous query.
  $questionID = mysqli_insert_id($mysqli);
  //$questionID = mysql_insert_id();
  
  //Check for returned results
  if($res){      
      //iterate through parameters array and save to <TblQuestionParameters>.
      for($i=0; $i<count($jQuest['qstParameters']); $i++) {
        //Get Values
        $param = $jQuest['qstParameters'][$i]["parameter"];
        $paramType = $jQuest['qstParameters'][$i]["parameterType"];
        
        //SQL query tu run against the DB for INSERT parameters into TblQuestionParameters
        $sqlParam = "INSERT INTO TblQuestionParameters (QuestionID, Parameter, ParameterType) VALUES('".$questionID."','".$param."','".$paramType."')";
        
        //Get Result
        $mysqli->query($sqlParam) or die("Failed to save question parameters in database " .mysql_error());
        //$pRes = mysql_query($sqlParam) or die("Failed to save question parameters in database " .mysql_error());
      }
  
    //Return json with successful transaction
    $jQuest["TransCompleted"] = 1;
    
    
    //echo the JSON object
    echo json_encode($jQuest);
  }else{
    //Return json with successful transaction
    $jQuest["TransCompleted"] = 0;
    
    //echo the JSON object
    echo json_encode($jQuest);
  }
?>
