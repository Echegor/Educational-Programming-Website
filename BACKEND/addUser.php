<?php
  //Include Configuration File
  //include('config.php');
  
  //Database connection.
  $host = "sql1.njit.edu";
  $user = "jjr27";
  $pass = "JS6RYpHk";
  $db = "jjr27";
  
  mysql_connect($host, $user, $pass);
  mysql_select_db($db);
  
  
  if(isset($_POST['username']))
  {    
    //JSON response
    $response = json_decode(file_get_contents('php://input'), true);
    
    //Values passed.
    $firstName = $_POST['firstName'];
    $lastName = $_POSt['lastName'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $roleId = $_POSt['AccountType'];
    
    //SQL query tu run against the DB for INSERT.
    $sql = "INSERT INTO TblUser (FirstName, LastName, UserName, Password, RoleID) VALUES('".$firstName."','".$lastName."','".$username."','".$password."', '".$roleId."'");
    
    //Get Result
    $res = mysql_query($sql) or die("Failed to register user in database " .mysql_error());
    echo $roleId
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
    
  }

?>
