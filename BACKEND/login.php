<?php
  require_once "config.php";
  
  //JSON response
  $response = json_decode(file_get_contents('php://input'), true);
  
  //Credentials passed.
  $username = $response['username'];
  $password = $response['password'];
  
  if (isset($username)){
    //SQL query tu run against the DB.
    $sql = "SELECT * FROM TblUser WHERE username = '".$username."' AND password='".$password."'";
    
    //Get Result
    $res = mysql_query($sql) or die("Failed to query database " .mysql_error());
    
    //Check for returned results
    if (mysql_num_rows($res) == 1){
    
      //Get user row.
      $userRow = mysql_fetch_assoc($res); 
      
      //successfully loged in.
      $response["userId"] = (int)$userRow["UserID"];
      $response["firstName"] = $userRow["FirstName"];
      $response["lastName"] = $userRow["LastName"];
      $response["roleId"] = (int)$userRow["RoleID"];
      
      //echo the JSON response
      echo json_encode($response);
  
    }else{
      //Failed to login.
      $response["roleId"] = 0;
      
      //echo the JSON response
      echo json_encode($response);  
    }
  }

?>
