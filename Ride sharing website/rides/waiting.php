<?php
session_start();
include("functions.php");
include("connection.php");

// Check if user is logged in
$user_data = check_login($con);

// Check if the user has a regular role
if (!isset($user_data['role']) || $user_data['role'] !== 'regular') {
    header("Location: access_denied.php");
    exit;
}

// Regenerate session ID for security
session_regenerate_id(true);

// Retrieve trip request status for the current user
$query = "SELECT status FROM trip_requests WHERE user_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_data['id']);
$stmt->execute();
$result = $stmt->get_result();

// Fetch status from the result
$row = $result->fetch_assoc();
$status = isset($row['status']) ? $row['status'] : '';

// Check if status is 'accepted' or not
if ($status === 'accepted') {
    // Redirect to accepted page if status is 'accepted'
    header("Location: accepted_trip.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Waiting for Confirmation</title>
<style>
    /* Center the content vertically and horizontally */
    body, html {
        height: 100%;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f5f5f5;
    }

    /* Style for the waiting text */
    .waiting-container {
        text-align: center;
    }

    .waiting-text {
        font-size: 24px;
        color: #333;
        margin-bottom: 20px;
    }

    /* Style for the loading spinner */
    .loading-spinner {
        border: 4px solid #f3f3f3; /* Light grey */
        border-top: 4px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 2s linear infinite; /* Spin animation */
        margin: 0 auto; /* Center horizontally */
    }

    /* Spin animation */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
</head>
<body>

<div class="waiting-container">
    <p class="waiting-text">Waiting for Confirmation</p>
    <div class="loading-spinner"></div>
</div>

<script>
    setTimeout(function() {
        window.location.reload();
    }, 5000); // Refresh every 5 seconds (5000 milliseconds)
</script>




</body>
</html>
