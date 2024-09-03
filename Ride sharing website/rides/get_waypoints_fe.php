<?php
// Include necessary files and initialize session if required
session_start();
include("functions.php");
include("connection.php");

// Check if user is logged in
$user_data = check_login($con);

// Function to fetch directions and waypoints from Google Maps Directions API
// Function to fetch directions and waypoints from Google Maps Directions API
function getDirectionsAndWaypoints($origin, $destination) {
    $api_key = 'AIzaSyBjE1XvpzE2Ho2wPZh2ctTIIXglKA6mf1Y';
    $encoded_origin = urlencode($origin);
    $encoded_destination = urlencode($destination);
    $url = "https://maps.googleapis.com/maps/api/directions/json?origin=$encoded_origin&destination=$encoded_destination&key=$api_key";

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL request
    $response = curl_exec($ch);

    // Check for errors
    if ($response === false) {
        // Handle HTTP request failure
        echo "Failed to fetch directions from Google Maps API: " . curl_error($ch);
        return false;
    }

    // Close cURL session
    curl_close($ch);

    // Decode JSON response
    $data = json_decode($response, true);

    // Check response status
    if ($data['status'] == 'OK') {
        $waypoints = array();

        // Extract waypoints from response
        foreach ($data['routes'][0]['legs'][0]['steps'] as $step) {
            if (isset($step['html_instructions'])) {
                $waypoint = preprocessWaypoint($step['html_instructions']);
                $waypoints[] = $waypoint;
            }
        }

        return $waypoints;
    } else {
        // Handle API response status other than 'OK'
        echo "Error: " . $data['status'];
        return false;
    }
}



// Handle form submission
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get origin and destination from the form
    $origin = $_POST['origin'];
    $destination = $_POST['destination'];

    // Get waypoints from Google Maps API
    $waypoints = getDirectionsAndWaypoints($origin, $destination);

    if ($waypoints !== false) {
        // Concatenate waypoints into a single string
        $all_waypoints = implode(', ', $waypoints);

        // Perform necessary database operations to store waypoints
        $user_id = $user_data['id']; // Assuming 'id' is the primary key of the 'users' table
        $origin = mysqli_real_escape_string($con, $origin);
        $destination = mysqli_real_escape_string($con, $destination);
        $all_waypoints = mysqli_real_escape_string($con, $all_waypoints);

        $sql = "INSERT INTO search_trip (user_id, origin, destination, waypoint) VALUES ('$user_id', '$origin', '$destination', '$all_waypoints')";
        if (mysqli_query($con, $sql)) {
            echo "Waypoints stored successfully!<br>";
        } else {
            echo "Error storing waypoints: " . mysqli_error($con) . "<br>";
        }
    } else {
        echo "Error fetching waypoints from Google Maps API.";
    }
}
header("Location: available_rides.php");
?>
