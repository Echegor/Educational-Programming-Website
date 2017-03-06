<?php

  require_once "config.php";

  //JSON object
  $jParam = json_decode(file_get_contents('php://input'), true);
  
  //Values passed.
  $testId = $jParam['gradedTestId'];
  $studentId = $jParam['studentId'];
  
  //fetch table rows from mysql db     “prompt” : string, “questionId” : int, “questionWeight” : int, “questionGrade” : int, “studentAnswer” : string, “remarks” : string
  $sql = "SELECT QT.QuestionID, QT.Question AS prompt, QBT.tWeight AS questionWeight, TTG.Grade AS questionGrade, TTG.StudentAns as studentAnswer, TTG.Remarks FROM TblTestGrading TTG Inner Join TblQuestionByTest QBT ON TTG.TestID = QBT.TestID AND TTG.QuestionID = QBT.QuestionID Inner Join TblQuestion QT ON QBT.QuestionID = QT.QuestionID WHERE TTG.TestID = " . $testId . " AND TTG.UserID = " . $studentId . " Group by QT.QuestionID";
            
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