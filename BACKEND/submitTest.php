<?php

  require_once "config.php";  
  
  //JSON object
  $jTestG = json_decode(file_get_contents('php://input'), true);
  
  /*
  //Log File for inputs
  $myfile = fopen("jamesLog.txt", "w") or die("Unable to open file!");
  //$txt = "John Doe\n";
  $txt = "Received from middle tier: " . $jTestG . "\n";
  fwrite($myfile, $txt);
  fclose($myfile);
  //end log file
  */
  
  
  //Values passed.
  $testID = (int)$jTestG['testId'];
  $userID = (int)$jTestG['studentId'];
  
  //Check if test exists for given user. If so, drop it and continue to add it again.
  //SQL query tu run against the DB.
    $sqlValidation = "SELECT * FROM TblTestGrading WHERE TestID = ".$testID." AND UserID=".$userID;
    
    //Get Result
    $res = mysqli_query($connection, $sql) or die("Failed to register user in database " . mysql_error($connection));
    
    //Check for returned results
    if (mysqli_num_rows($res) > 0){
    //SQL query tu run against the DB.
      $sqlDelete = "DELETE FROM TblTestGrading WHERE TestID = ".$testID." AND UserID=".$userID;
      
      //Get Result
      $res = mysqli_query($connection, $sqlDelete) or die("Failed to delete test " .mysqli_error($connection));
    }
    
    //// End validation 
    

  $testSaved = 0;
  
  for($i=0; $i<count($jTestG['answers']); $i++) {
    //Get Values
    $questionID = (int)$jTestG['answers'][$i]['questionId'];
    $answer = $jTestG['answers'][$i]['answer'];
    $grade = $jTestG['answers'][$i]['grade'];
    //$gradeExplanation = clean($jTestG['answers'][$i]['gradeExplanation']);
              
    //SQL query tu run against the DB for INSERT.
    $sql = "INSERT INTO TblTestGrading (TestID, UserID, QuestionID, StudentAns, Grade) VALUES(".$testID.",".$userID.",".$questionID.",'".$answer."',".$grade.")";
 
    //echo $questionID . "-" . $testID . "-" . $userID . "-" . $answer . "-" . $grade , "\n";
    //Get Result
    $res2 = mysqli_query($connection, $sql) or die("Failed to save test taken " . mysql_error($connection));
    
    //Save each testCase
    for($k=0; $k < count($jTestG['answers'][$i]['gradeExplanation']); $k++) {
        //$testInput = clean($jTestG['answers'][$i]['gradeExplanation'][$k]['testInput']);
        //$corOutput = clean($jTestG['answers'][$i]['gradeExplanation'][$k]['correctOutput']);
        //$stdOutput = clean($jTestG['answers'][$i]['gradeExplanation'][$k]['studentOutput']);
        $testInput = 'squared(8)';
        $corOutput = '64';
        $stdOutput = '64';
        $correct = (int)$jTestG['answers'][$i]['gradeExplanation'][$k]['correct'];
        
        //SQL query tu run against the DB for INSERT.
        $sqlTC = "INSERT INTO TblTestGradingTC (TestID, UserID, QuestionID, TestCase, CorrectOuput, StudentOutput, correct) VALUES(".$testID.",".$userID.",".$questionID.",'".$testInput."','".$corOutput."','".$stdOutput."',".$correct.")";
        
        echo stripslashes($sqlTC);
        
        //Get Result
        $resTC = mysqli_query($connection, $sqlTC) or die("Failed to save test cases for test taken " . mysql_error($connection));
        
        
        
        if (!$resTC) {
            echo('Invalid query: ' . mysql_error());
        }
    }
    
    $testSaved = 1;
  }
  
  // Convert MySQL Result Set to PHP Array  
  // Create an array
  $jReply = array();
  
  //Check for returned results
  if($testSaved){      
    
    //Return json with successful transaction
    $jReply["response"] = 1;
    
    //echo the JSON object
    echo json_encode($jReply);
  }else{
    //Return json with successful transaction
    $jReply["response"] = 0;
    
    //echo the JSON object
    echo json_encode($jReply);
  }
  
    //close the db connection
  mysqli_close($connection);
  
  function clean($string) {
   $string = str_replace(' ', '', $string); // Replaces all spaces with hyphens.
   //return $string;
   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
  }
?>
