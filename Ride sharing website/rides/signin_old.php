<?php
session_start();
include("functions.php");
include("connection.php");

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(!empty($username) && !empty($password)) {
        $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
        $result = mysqli_query($con, $query);

        if($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            if($user_data['password'] == $password) {
                $_SESSION['user_id'] = $user_data['id'];

                // Check user role
                $role = $user_data['role'];
                $gender = $user_data['gender'];
                if ($role == 'driver') {
                    header("Location: driver.php"); // Redirect for drivers
                } else {
                    if ($gender == 'FEMALE') {
                        header("Location: index_fe.php"); // Redirect for females
                    } else {
                        header("Location: index.php"); // Redirect for others
                    }
                }
                exit; // Ensure script execution stops after redirection
            }
        }
    }
    echo "Please enter valid credentials";
}
?>

<!DOCTYPE html>
<!-- Designed by CodingLab - youtube.com/codinglabyt -->
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <title>Ride Share</title>
    <link rel="stylesheet" href="css/signup.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="container">
    <div class="title">Login</div>
    <div class="content">
        <form method="post">
            <div class="user-details">
                <div class="input-box">
                    <span class="details">Username</span>
                    <input type="text" placeholder="Enter your username" name="username" required>
                </div>
                <div class="input-box">
                    <span class="details">Password</span>
                    <input type="password" placeholder="Enter your password" name="password" required>
                </div>
            </div>
            <div class="button">
                <input type="submit" value="Sign in">
            </div>
        </form>
    </div>
</div>
<div><span></span><span> &nbsp Forgot Password?  <a href="signup.php"> Signup</a></span></div>
</body>
</html>
