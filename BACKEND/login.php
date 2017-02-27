//James Restrepo
//CS-490
//Back End - Login
//Spring 2017

<?php
/*
//Database connection.
$host = "sql1.njit.edu";
$user = "jjr27";
$pass = "JS6RYpHk";
$db = "jjr27";

mysql_connect($host, $user, $pass);
mysql_select_db($db);
*/

//Include Configuration File.
include('config.php');

if (isset($_POST['username'])){
  //JSON response
  $response = json_decode(file_get_contents('php://input'), true);
  
  //Credentials passed.
  $username = $_POST['username'];
  $password = $_POST['password'];
  
  //SQL query to run against the DB.
  $sql = "SELECT * FROM TblUserCredentials WHERE username = '".$username."' AND password='".$password."'";
  //Get Result
  $res = mysql_query($sql) or die("Failed to query database " .mysql_error());
  
  //Check for returned results
  if (mysql_num_rows($res) == 1){
  
    //successfully loged in.
    $response["BACKEND"] = 1;
    //$response["message"] = "Welcome. You have successfully loged in!!";
    
    //echo the JSON response
    echo json_encode($response);

  }else{
  
    //Failed to login.
    $response["BACKEND"] = 0;
    //$response["message"] = "Invalid login information. Please return to previous page.";
    
    //echo the JSON response
    echo json_encode($response);
    
  }
}

?>
