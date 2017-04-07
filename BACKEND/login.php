<?php
  require_once "config.php";
  
  
  //JSON response
  $response = json_decode(file_get_contents('php://input'), true);
  
  //Credentials passed.
  $username = $response['username'];
  $password = $response['password'];
  
  if (isset($username)){
    //SQL query tu run against the DB.
    $sql = "SELECT * FROM TblUser WHERE username = '".$username."'";
    
    //Get Result
    $res = mysqli_query($connection, $sql) or die("Failed to query database " .mysql_error());
    
    //Check for returned results
    if (mysqli_num_rows($res) == 1){
    
      //Get user row.
      $userRow = mysqli_fetch_assoc($res); 
      
      // Get the password from the database and compare it to a variable (for example post)
      $hashedPasswordFromDB = trim($userRow["Password"]);
      
      if (password_verify($password, $hashedPasswordFromDB)) {
      //if (password_verify('123', '$2y$10$wRZ/PExgPdhbUqzyKZfja.EoxTIOpyVrMX28K8di1m/')) {
          //successfully loged in.
          $response["userId"] = (int)$userRow["UserID"];
          $response["firstName"] = $userRow["FirstName"];
          $response["lastName"] = $userRow["LastName"];
          $response["roleId"] = (int)$userRow["RoleID"];
      } else {
          //Failed to login.
          $response["roleId"] = 0;
      }
      
      //echo the JSON response
      echo json_encode($response);
  
    }else{
      //Failed to login.
      $response["roleId"] = 0;
      
      //echo the JSON response
      echo json_encode($response);  
    }
  }
  
   //close the db connection
  mysqli_close($connection);

?>