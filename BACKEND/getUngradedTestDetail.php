<?php

  require_once "config.php";

  //JSON object
  $jParam = json_decode(file_get_contents('php://input'), true);
  
  //Values passed.
  $testID = $jParam['ungradedTestId'];
  
  //fetch table rows from mysql db
  $sql = "SELECT DISTINCT USR.UserID as studentId, CONCAT(FirstName, " ", LastName) AS studentName FROM TblTestGrading TTG Inner Join TblUser USR ON TTG.UserID = USR.UserID WHERE TTG.TestID = " . $testID;
            
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