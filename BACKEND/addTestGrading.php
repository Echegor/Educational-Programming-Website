<?php

  require_once "config.php";
  
  //JSON object
  $jTestG = json_decode(file_get_contents('php://input'), true);
  
  //Values passed.
  $testID = (int)$jTestG['testID'];
  $userID = (int)$jTestG['userID'];
  $questionID = (int)$jTestG['questionID'];
  $studentAns = $jTestG['studentAns'];
  $grade = $jTestG['grade'];
  $dateTaken = $jTestG['dateTaken'];
  
  //SQL query to run against the DB for INSERT.
  $sql = "INSERT INTO TblTestGrading (testID, userID, questionID, studentAns, grade, dateTaken) 
        VALUES('".$testID."','".$userID."','".$questionID."','".$studentAns."','".$grade."','".$dateTaken."')";
  
  //Get Result
  $res = mysqli_query($connection, $sql) or die("Failed to save test gradings in database " .mysql_error($connection));
  
  //Check for returned results
  if($res){      
    
    //Return json with successful transaction
    $jTestG["TransCompleted"] = 1;
    
    //echo the JSON object
    echo json_encode($jTestG);
  }else{
    //Return json with successful transaction
    $jTestG["TransCompleted"] = 0;
    
    //echo the JSON object
    echo json_encode($jTestG);
  }
  
    //close the db connection
  mysqli_close($connection);
?>