<?php

  require_once "config.php";
  
  //open connection to mysql db
  //$connection = mysqli_connect($host,$user,$pass,$db) or die("Error " . mysqli_error($connection));

  //fetch table rows from mysql db
  $sql = "SELECT TestID, TestDesc, UserID As CreatedByID, CONCAT_WS(' ', FirstName, LastName) AS CreatedByName, DateCreated FROM TblTest Inner Join TblUser ON TblTest.CreatedBy = TblUser.UserID";
            
  $result = mysqli_query($connection, $sql) or die("Error in Selecting Tests " . mysqli_error($connection));
    
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
