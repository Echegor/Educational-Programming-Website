<?php
  //James Restrepo
  //CS-490
  //Back End - ConfigFile
  //Spring 2017

  //Database connection.
  $host = "sql1.njit.edu";
  $user = "jjr27";
  $pass = "JS6RYpHk";
  $db = "jjr27";

  //MySQL Connection
  $connection = mysqli_connect($host,$user,$pass,$db) or die("Error " . mysqli_error($connection));

?>
