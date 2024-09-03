<?php
session_start();
include("functions.php");
include("connection.php");

    $user_data = check_login($con);
    
    if (!isset($user_data['role']) || $user_data['role'] !== 'regular') {
        header("Location: access_denied.php");
        exit;
    }
    
    // Regenerate session ID
    session_regenerate_id(true);

    $query = "SELECT status FROM trip_requests WHERE user_id = ?"; // Assuming 'user_id' is the column storing the user's ID
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $user_data['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && $row['status'] === 'accepted') {
        // Redirect the user to another page if the trip request status is 'accepted'
        header("Location: accepted_trip.php");
        exit;
}
    
    // Debugging: Output user data to inspect session
    echo "<pre>";
    print_r($user_data);
    echo "</pre>";
    
 ?>