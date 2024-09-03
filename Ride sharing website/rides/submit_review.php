<?php
session_start();
include('functions.php');
include('connection.php');

// Check if the user is logged in
$user_data = check_login($con);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $driver_id = $_POST['driver_id'];
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
    $review_text = isset($_POST['review_text']) ? htmlspecialchars($_POST['review_text']) : '';
    echo "<pre>";
    print_r($driver_id);
    echo "</pre>";

    // Validate rating (1-5) and review text
   // if ($rating < 1 || $rating > 5 || empty($review_text)) {
        // Redirect with error message
    //    header("Location: driver_profile.php?error=invalid_input");
    //    exit;
   // }

    // Insert review into the database
    echo "<pre>";
    print_r($driver_id);
    echo "</pre>";
    $query = "INSERT INTO reviews (driver_id, reviewer_id, rating, review_text, created_at)
              VALUES (?, ?, ?, ?, NOW())";
    $stmt = $con->prepare($query);
    $stmt->bind_param("iiis", $driver_id, $user_data['id'], $rating, $review_text);
    $stmt->execute();

   

    // Redirect back to the driver profile page
    header("Location: driver_profile.php?success=review_submitted&driver_id=" . $driver_id);
    exit;
} else {
    // Redirect if accessed directly
    header("Location: driver_profile.php");
    exit;
}
?>
