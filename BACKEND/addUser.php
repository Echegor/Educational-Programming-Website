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
    
  if(isset($roleId))
  {    
    
    //SQL query tu run against the DB for INSERT.
    $sql = "INSERT INTO TblUser (FirstName, LastName, UserName, Password, RoleID) VALUES('".$firstName."','".$lastName."','".$username."','".$password."', '".$roleId."'");
    
    //Get Result
    $res = mysql_query($sql) or die("Failed to register user in database " .mysql_error());

    //Check for returned results
    if($res){      
      //Return json with successful transaction
      $response["TransCompleted"] = 1
      
      //echo the JSON response
      echo json_encode($response);
    }else{
      //Return json with successful transaction
      $response["TransCompleted"] = 0
      
      //echo the JSON response
      echo json_encode($response);
    }
    
  }else{
    echo "No role ID";
  }
?>
