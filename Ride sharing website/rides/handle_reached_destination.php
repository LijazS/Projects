<?php
session_start();
include("connection.php");

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "error";
    exit;
}

// Get user_id from session
$user_id = $_SESSION['user_id'];

// Get trip_id from POST data
$trip_id = $_POST['trip_id'];

// Delete trip request
$query_delete = "DELETE FROM trip_requests WHERE user_id = ? AND trip_id = ?";
$stmt_delete = $con->prepare($query_delete);
$stmt_delete->bind_param("ii", $user_id, $trip_id);
if ($stmt_delete->execute()) {
    // Decrement seats_used in trip_listing table
    $query_decrement = "UPDATE trip_listing SET seats_used = seats_used - 1 WHERE trip_id = ?";
    $stmt_decrement = $con->prepare($query_decrement);
    $stmt_decrement->bind_param("i", $trip_id);
    $stmt_decrement->execute();
    // Redirect back to the page or any other action you want
    header("Location: index.php");
    exit;
} else {
    // Handle error
    echo "error";
}
?>
