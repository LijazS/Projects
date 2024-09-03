<?php

  $dbhost = "localhost";
  $dbuser = "root";
  $dbpass = "";
  $dbname = "ride";

  if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
  {

    die("failed to connect");
  }

 ?>
