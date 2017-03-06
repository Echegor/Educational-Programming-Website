<?php

  require_once "config.php";

  //JSON object
  $jQuest = json_decode(file_get_contents('php://input'), true);
  
  //Values passed.
  $userID = (int)$jquest['userid'];
  
  //fetch table rows from mysql db
  $sql = "SELECT QuestionID AS id, QstTitle as name, SjtDescription as category FROM TblQuestion Inner Join TblUser ON TblQuestion.QstCreatedBy = TblUser.UserID Inner Join TblSubject ON TblQuestion.QstSubjectID = TblSubject.SubjectID WHERE TblUser.UserID = " . $userID;
            
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