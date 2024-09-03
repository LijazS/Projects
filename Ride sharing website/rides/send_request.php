<?php
// Include your database connection file
session_start();
include("functions.php");
include("connection.php");

// Check if the request is sent via POST method
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the driver ID and user ID from the POST data
    $driver_id = $_POST['driver_id'];
    $user_id = $_POST['user_id'];
    $trip_id = $_POST['trip_id'];
    $price = $_POST['price'];
    
    // Perform any additional validation if needed
    
    // Insert the request into the database
    $query = "INSERT INTO trip_requests (driver_id, user_id, trip_id,price, status) VALUES (?, ?, ?,?, 'pending')";
    $stmt = $con->prepare($query);
    
    if (!$stmt) {
        // Query preparation failed
        echo json_encode(array("success" => false, "message" => "Query preparation failed: " . $con->error));
        exit; // Terminate script execution
    }
    
    $stmt->bind_param("iiii", $driver_id, $user_id, $trip_id,$price);
    
    if ($stmt->execute()) {
        // Request inserted successfully
        // You can optionally return a success message or any other data
        echo json_encode(array("success" => true, "message" => "Request sent successfully"));
    } else {
        // Failed to insert request
        // You can optionally return an error message or any other data
        echo json_encode(array("success" => false, "message" => "Failed to send request: " . $stmt->error));
    }
} else {
    // Invalid request method
    // You can return an error response
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("success" => false, "message" => "Invalid request method"));
}

// Close the database connection
$con->close();
header("Location: waiting.php");
?>
