<?php

  require_once "config.php";

  //JSON object
  $jParam = json_decode(file_get_contents('php://input'), true);
  
  //Values passed.
  $studentId = $jParam['studentId'];
  
  //fetch table rows from mysql db     “testId” : int, “name” : string, “description” : string
  $sql = "SELECT TestID as testId, TestName as name, TestDesc AS description FROM TblTest";
            
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