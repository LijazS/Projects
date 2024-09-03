<?php
session_start();
include("functions.php");
include("connection.php");

  if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $gender = $_POST['gender'];
    $adhar_no = $_POST['adhar_no'];
    $phone_number = $_POST['phone_number'];

    if(!empty($username) && !empty($password))
    {
      //save to DATABASE
        $id = random_num(3);
        $query =  "insert into users (id,username,email,password,role,gender,adhar_no,phone_number) values('$id','$username','$email','$password','$role','$gender','$adhar_no','$phone_number')";

        mysqli_query($con,$query);

        header("Location: signin.php");
        die;
    }
    else
    {
      echo "please enter some valid information";
    }
  }

 ?>