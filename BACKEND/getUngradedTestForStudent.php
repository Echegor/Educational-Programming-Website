<?php

  require_once "config.php";

  //JSON object
  $jParam = json_decode(file_get_contents('php://input'), true);
  
  //Values passed.
    $testId = (int)$jParam['ungradedTestId'];
    $studentId = (int)$jParam['studentId'];
    //$testId = 48;
    //$studentId = 28;
  
  //fetch table rows from mysql db     “prompt” : string, “questionId” : int, “questionWeight” : int, “questionGrade” : int, “studentAnswer” : string, “remarks” : string
  $sql = "SELECT TTG.QuestionID, TQ.QstTitle, TQ.Question, QBT.tWeight, TTG.StudentAns, TTG.Grade, TTG.gradeExplanation, TTG.errors FROM TblTestGrading TTG Inner Join TblQuestion TQ ON TTG.QuestionID = TQ.QuestionID Inner Join TblQuestionByTest QBT ON TTG.TestID = QBT.TestID AND TTG.QuestionID = QBT.QuestionID WHERE TTG.TestID = " . $testId . " AND TTG.UserID = " . $studentId;
            
  $result = mysqli_query($connection, $sql) or die("Error in Selecting Students " . mysqli_error($connection)); 
    
  if($result){   
      // Convert MySQL Result Set to PHP Array  
      // Create an array
      $jReply = array();
      $jReply["testID"] = $testId;
      $jReply["studentId"] = $studentId;
      $jReply["answers"] = array();

      while($row = mysqli_fetch_assoc($result))
      {
          //$jReply["answers"][] = $row;
          $jReply["answers"][] = array(
            'questionID' => $row['QuestionID'],
            'questionName' => $row['QstTitle'],
            'questionPrompt' => $row['Question'],
            'weight' => $row['tWeight'],
            'answer' => $row['StudentAns'],
            'grade' => $row['Grade'],
            'errors' => $row['errors'],
            'gradeExplanation' => json_decode($row['gradeExplanation'])
          );
      }  
      
      //Convert PHP Array to JSON String
      echo json_encode($jReply);
      
  }else{
    //Return json with successful transaction
    $jTestG["TransCompleted"] = 0;
    
    //echo the JSON object
    echo json_encode($jTestG);
  }
  
  //close the db connection
  mysqli_close($connection);
?>