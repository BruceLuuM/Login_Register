<?php
  $servername = 'localhost';
  $username = 'root';
  $password = '';

  // connecting to SQLiteDatabase
  try{
      $conn = new PDO("mysql:host=$servername;dbname=login_register_db",$username, $password);
      //set the PDO error mode to exception.
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (\Exception $e){
      echo $e->getMessage();
  }
  
?>
