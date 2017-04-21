<?php

  require_once "config.php";
  
    //JSON response
  $tstParameter = json_decode(file_get_contents('php://input'), true);
  
  //Credentials passed.
  $testID = $tstParameter['testID'];

  //fetch table rows from mysql db
  $sql = "SELECT QuestionID, Question, QstAlternativeAns, QstRank, UserID As CreatedByUser, CONCAT_WS(' ', FirstName, LastName) AS CreatedByName, QstCreationDate, QstSubjectID,                    SjtDescription, QstExpectedOutput FROM TblQuestion Inner Join TblUser ON TblQuestion.QstCreatedBy = TblUser.UserID Inner Join TblSubject ON TblQuestion.QstSubjectID = TblSubject.SubjectID Inner Join TblTest ON WHERE TblTest.TestID = '".$username."'";
            
  $result = mysqli_query($connection, $sql) or die("Error in Selecting Questions " . mysqli_error($connection));
    
  // Convert MySQL Result Set to PHP Array  
  // Create an array
  $empArray = array();
  while($row =mysqli_fetch_assoc($result))
  {
      $empArray[] = $row;
  }  
  
  //Convert PHP Array to JSON String
  echo json_encode($empArray);
  
  //close the db connection
  mysqli_close($connection);
?>