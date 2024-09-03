<?php
session_start();
include("functions.php");
include("connection.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the trip ID from the form
    $trip_id = $_POST['trip_id'];
    echo "<pre>";
    print_r($trip_id);
    echo "</pre>";

    // Perform database operation to remove the trip from the trip_listing table
    $query = "DELETE FROM trip_listing WHERE trip_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $trip_id);
    
    // Execute the query
    if ($stmt->execute()) {
        // Trip successfully finished, redirect to driver.php
        header("Location: driver.php");
        exit;
    } else {
        // Error occurred, redirect to an error page or display an error message
        header("Location: error.php");
        exit;
    }
} else {
    // Redirect to an error page or display an error message if the form was not submitted
    header("Location: error.php");
    exit;
}
?>
