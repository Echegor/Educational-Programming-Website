<?php
  require_once "config.php";
  
  //JSON response
  $response = json_decode(file_get_contents('php://input'), true);
    
  //Values passed.
  $firstName = $response['firstName'];
  $lastName = $response['lastName'];
  $username = $response['username'];
  $password = $response['password'];
  $roleId = $response['accountType'];
    
  //if(isset($roleId))
  //{    
    
    //SQL query tu run against the DB for INSERT.
    $sql = "INSERT INTO TblUser (FirstName, LastName, UserName, Password, RoleID) VALUES('".$firstName."','".$lastName."','".$username."','".$password."', '".$roleId."')";
    
    //Get Result
    $res = mysqli_query($connection, $sql) or die("Failed to register user in database " .mysql_error($connection));

    //mysqli_insert_id returns The value of the AUTO_INCREMENT field that was updated by the previous query.
    $testID = mysqli_insert_id($connection);
  /*
    //Check for returned results
    if($res){      
      //Add userID to json obj
      $response["UserID"] = (int)$testID;
    
      //Return json with successful transaction
      $response["TransCompleted"] = 1;
      
      //echo the JSON response
      echo json_encode($response);
    }else{
      //Return json with successful transaction
      $response["TransCompleted"] = 0;
      
      //echo the JSON response
      echo json_encode($response);
    }
    */
    //close the db connection
    mysqli_close($connection);

?>