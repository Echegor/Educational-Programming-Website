<?php

  require_once "config.php";

  //JSON object
  $jQuest = json_decode(file_get_contents('php://input'), true);
  
  //Values passed.
  $questID = (int)$jQuest['questionId'];
  
  //fetch table rows from mysql db
  $sql = "DELETE from TblQuestion WHERE QuestionID = " . $questID;
            
  $result = mysqli_query($connection, $sql) or die("Failed to delete question. Check that this question is not already assigned to a test. " . mysqli_error($connection));
    
  //Check for returned results
  if($result){      
    
    //Return json with successful transaction
    $jResp["response"] = 1;
    
    //echo the JSON object
    echo json_encode($jResp);
  }else{
    //Return json with successful transaction
    $jResp["response"] = 0;
    
    //echo the JSON object
    echo json_encode($jResp);
  }
  
  //close the db connection
  mysqli_close($connection);
?>