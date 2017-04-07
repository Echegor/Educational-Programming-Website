<?php

  require_once "config.php";

  //JSON object
  $jParam = json_decode(file_get_contents('php://input'), true);
  
  //Values passed.
  $studentId = $jParam['studentId'];
  
  //fetch table rows from mysql db     questionId, questionPrompt, questionWeight, studentAnswer, studentGrade
  $sql = "SELECT Distinct TblTestGrading.TestID, TblTest.TestName FROM TblTestGrading Inner Join TblTest ON TblTestGrading.TestID = TblTest.TestID WHERE TblTestGrading.released = 1 AND TblTestGrading.UserID = " . $studentId;
            
  $result = mysqli_query($connection, $sql) or die("Error in Selecting Students " . mysqli_error($connection));
    
  // Convert MySQL Result Set to PHP Array  
  // Create an array
  $jReply = array();
  while($row =mysqli_fetch_assoc($result))
  {
      $jReply[] = $row;
  }  
  
  //Convert PHP Array to JSON String
  echo json_encode($jReply);
  
  //close the db connection
  mysqli_close($connection);
?>