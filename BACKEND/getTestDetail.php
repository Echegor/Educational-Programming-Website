<?php

  require_once "config.php";

  //JSON object
  $jParam = json_decode(file_get_contents('php://input'), true);
  
  //Values passed.
  //$studentId = $jParam['studentId'];
  $testID = (int)$jParam['testId'];
  
  //fetch table rows from mysql db     questionId, questionPrompt, questionWeight, studentAnswer, studentGrade
  $sql = "SELECT TestName AS testName, TestDesc, CreatedBy AS creatorID FROM TblTest WHERE TestID = " . $testID;
            
  $test = mysqli_query($connection, $sql) or die("Error in Selecting Students " . mysqli_error($connection));
     
  // Convert MySQL Result Set to PHP Array  
  // Create an array
  $jReply = array();
  
  $row = mysqli_fetch_assoc($test);
  $jReply["testName"] = $row["testName"];
  $jReply["TestDesc"] = $row["TestDesc"];
  $jReply["CreatedBy"] = $row["creatorID"];
  

      
  //fetch table rows from mysql db     questionId, questionPrompt, questionWeight, studentAnswer, studentGrade
  $sqlQts = "SELECT Question AS prompt, TblQuestionByTest.QuestionID AS questionID, tWeight AS weight FROM TblQuestionByTest Inner Join TblQuestion ON TblQuestionByTest.QuestionID = TblQuestion.QuestionID WHERE TestID = " . $testID;
                  
  $qsts = mysqli_query($connection, $sqlQts) or die("Error in Selecting Students " . mysqli_error($connection));  
  
  while($quest = mysqli_fetch_assoc($qsts))
  {
    //array of questions
    $jReply['questionIDs'][] = $quest;
  } 
  
  //Convert PHP Array to JSON String
  echo json_encode($jReply);
  
  //close the db connection
  mysqli_close($connection);
?>
