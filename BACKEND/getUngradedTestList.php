<?php

  require_once "config.php";

  //JSON object
  $jQuest = json_decode(file_get_contents('php://input'), true);
  
  //Values passed.
  $userID = (int)$jQuest['instructorId'];
  
  //fetch table rows from mysql db
  //$sql = "SELECT TT.TestID AS UngradedTestID, TT.TestName as UngradedTestName FROM TblTest TT Inner Join TblTestGrading TTG ON TT.TestID = TTG.TestID WHERE TTG.";
  $sql = "SELECT TT.TestID AS UngradedTestID, TT.TestName as UngradedTestName FROM TblTest TT";
  
  $result = mysqli_query($connection, $sql) or die("Error in Selecting Tests " . mysqli_error($connection));
    
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