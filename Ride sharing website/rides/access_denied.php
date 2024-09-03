<?php
session_start();
include("functions.php");
include("connection.php");

    $user_data = check_login($con);
        echo "<pre>";
    print_r($user_data);
    echo "</pre>";


 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .error-container {
            text-align: center;
        }
        h1 {
            color: #ff6347;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>Error</h1>
        <p>Sorry, incorrect user type.</p>
        
    </div>
</body>
</html>
