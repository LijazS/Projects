<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    session_start();
    include("functions.php");
    include("connection.php");

    // Retrieve form data
    $tripId = $_POST['trip_id'];
    $action = $_POST['action'];

    // Debugging: Output user data to inspect session
    echo "<pre>";
    print_r($tripId);
    print_r($action);
    echo "</pre>";
    // Handle accept action
    // Handle accept action
    if ($action === 'accept') {                                                                                             //if request accept
        // Update the status of the trip request to accepted in the trip_requests table
        $query_update = "UPDATE trip_requests SET status = 'accepted' WHERE trip_id = ?";
        $stmt_update = $con->prepare($query_update);
        if (!$stmt_update) {
            die("Error in preparing accept statement: " . $con->error);
        }
        $stmt_update->bind_param("i", $tripId);
        $result_update = $stmt_update->execute();
        if (!$result_update) {
            die("Error in executing accept statement: " . $stmt_update->error);
        }
        $stmt_update->close();
    
        // Increment seats_used in trip_listing table
        $query_increment = "UPDATE trip_listing SET seats_used = seats_used + 1 WHERE trip_id = ?";            //increment seat
        $stmt_increment = $con->prepare($query_increment);
        if (!$stmt_increment) {
            die("Error in preparing increment statement: " . $con->error);
        }
        $stmt_increment->bind_param("i", $tripId);
        $result_increment = $stmt_increment->execute();
        if (!$result_increment) {
            die("Error in executing increment statement: " . $stmt_increment->error);
        }
        $stmt_increment->close();
    } 
// Handle reject action
elseif ($action === 'reject') {                                                                // delete trip request if rejected
    // Delete the trip request from the trip_requests table
    $query = "DELETE FROM trip_requests WHERE trip_id = ?";
    $stmt = $con->prepare($query);
    if (!$stmt) {
        die("Error in preparing reject statement: " . $con->error);
    }
    $stmt->bind_param("i", $tripId);
    $result = $stmt->execute();
    if (!$result) {
        die("Error in executing reject statement: " . $stmt->error);
    }
    $stmt->close();
}


    // Redirect back to the page where the form was submitted
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
} else {
    // Redirect to an error page or display an error message if the form was not submitted
    header("Location: error.php");
    exit;
}
?>
