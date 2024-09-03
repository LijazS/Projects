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
    
    // Debugging: Output user data to inspect session
    //echo "<pre>";
    //print_r($user_data);
   //echo "</pre>";
    
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matched Entries</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
             <div class="container px-4 px-lg-5">
               <a class="navbar-brand" href="#!">RIDE SHARE</a>
               <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                   <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                       <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                       <li class="nav-item"><a class="nav-link active" aria-current="page" href="accepted_trip.php">My Trip</a></li>

                       
                       
                   </ul>
                         </li>
                     </ul>
                     
                     <a class="nav-link active" aria-current="page" href="signin.php">&nbsp  Hello, <?php echo $user_data['username']?></a>
                 </div>
             </div>
         </nav>


         <style>
        .card {
    border: 2px solid #000000; /* Add border to the card */
    border-radius: 8px; /* Add border radius to the card */
    margin-bottom: 50px; /* Add margin to separate each card */
    padding: 8px; /* Add padding for content spacing */
}

.card-header {
    background-color: #14913e; /* Change header background color */
    color: #fff; /* Change header text color */
    padding: 8px 10px; /* Add padding to header */
    border-top-left-radius: 8px; /* Add border radius to top-left corner */
    border-top-right-radius: 8px; /* Add border radius to top-right corner */
}

.card-content {
    padding: 10px 0; /* Add padding to content */
}

.card-footer {
    padding-top: 30px;
}

.button-group {
    display: flex;
    justify-content: flex-end;
}

.view-button,
.request-button {
    background-color: #2e6868; /* Change button background color */
    color: #fff; /* Change button text color */
    border: none;
    padding: 8px 16px; /* Adjust button padding */
    border-radius: 4px; /* Add button border radius */
    margin-left: 8px;
    cursor: pointer;
    font-size: 14px; /* Increase button font size */
}

.view-button:hover,
.request-button:hover {
    background-color: #218838; /* Change button hover background color */
}

.view-button:focus,
.request-button:focus {
    outline: none;
}


        
    </style>


<?php
// Connect to MySQL database




$user_id = $_SESSION['user_id'];

// Retrieve waypoints, origin, and destination from the first table
$query1 = "SELECT id,origin, destination, waypoint,female_only FROM search_trip WHERE user_id = '$user_id' ORDER BY created_at DESC LIMIT 1";
$result1 = mysqli_query($con, $query1);
$row1 = mysqli_fetch_assoc($result1);
$first_origin = $row1['origin'];
$first_destination = $row1['destination'];
$first_waypoints = explode(', ', $row1['waypoint']);
$female_only = $row1['female_only'];

// Get distance using Google Maps Distance Matrix API
$distance = getDistance($first_origin, $first_destination);     //distance of passenger travelling


$waypoints_weight = 1; // Default weight for waypoints
$origin_weight = 1;   // Weight for origin (20% more than waypoints)
$destination_weight = 1.4; // Weight for destination (20% more than waypoints)


// Retrieve waypoints, origin, and destination from the second table
// Construct the query based on the value of $female_only
if ($female_only == 1) {
    $query2 = "SELECT tl.user_id, u.username, tl.origin, tl.destination, tl.waypoint, tl.trip_id, u.gender ,tl.seats_used,tl.seats
               FROM trip_listing AS tl 
               INNER JOIN users AS u ON tl.user_id = u.id 
               WHERE u.gender = 'FEMALE'  AND tl.seats_used < tl.seats" ;
} else {
    $query2 = "SELECT tl.user_id, u.username, tl.origin, tl.destination, tl.waypoint, tl.trip_id, u.gender ,tl.seats_used,tl.seats
               FROM trip_listing AS tl 
               INNER JOIN users AS u ON tl.user_id = u.id
               WHERE tl.seats_used < tl.seats";
}

$result2 = mysqli_query($con, $query2);

// Iterate through each entry in the second table
while ($row2 = mysqli_fetch_assoc($result2)) {
    $second_id = $row2['user_id'];
    $second_name = $row2['username'];
    $second_origin = $row2['origin'];
    $trip_id = $row2['trip_id'];
    $second_destination = $row2['destination'];
    $second_waypoints = explode(', ', $row2['waypoint']);
    $seats_used = $row2['seats_used'];
    $seats = $row2['seats'];

    $totalDistance = getDistance($second_origin, $second_destination);   //calculating total distance
    $numPassengers = $seats_used + 1 ;  //total no.of passengers already in car + 1

    // Calculate similarity score between waypoints, origin, and destination
    $waypoints_match = similar_text(implode(', ', $first_waypoints), implode(', ', $second_waypoints), $percent1);
    $origin_match = similar_text($first_origin, $second_origin, $percent2);
    $destination_match = similar_text($first_destination, $second_destination, $percent3);

    // Calculate combined score with weighted averages
    $combined_score = (($waypoints_weight * $percent1) + ($origin_weight * $percent2) + ($destination_weight * $percent3))
                    / ($waypoints_weight + $origin_weight + $destination_weight);

    // Inside the while loop where you iterate through each matched trip



// Calculate price based on distance
$price = calculatePricePerPassenger($distance, $totalDistance, $numPassengers);

    // Check if combined score is above 70%
    if ($combined_score >= 70) {
        echo '<div class="container">';
        echo '<div class="card">';
        echo '<div class="card-header">Matched Driver ID: ' . $second_id . '</div>';
        echo '<div class="card-content">';
        echo "<p><strong>Name:</strong> $second_name</p>";
        echo "<p><strong>Origin:</strong> $second_origin</p>";
        echo "<p><strong>Destination:</strong> $second_destination</p>";
        echo "<p><strong>Total seats:</strong> $seats</p>";
        echo "<p><strong>Seats Used:</strong> $seats_used</p>";
        echo "<p><strong>PRICE: $<span style='color: #14913E;'>$price</span></strong></p>";
        echo '</div>';
        echo '<div class="card-footer">';
        echo '<div class="button-group">';

        echo '<div style="margin-right: 10px;"></div>'; // Add a margin between the buttons
        echo '<form id="requestForm" method="POST" action="send_request.php">'; // Set action to the PHP script
        echo '<input type="hidden" name="driver_id" value="' . $second_id . '">';
        echo '<input type="hidden" name="user_id" value="' . $user_id . '">';
        echo '<input type="hidden" name="trip_id" value="' . $trip_id . '">';
        echo '<input type="hidden" name="price" value="' . $price . '">';
        echo '<button type="submit" class="request-button">Request</button>'; // Change type to submit
        echo '</form>';

        // Add some space between the buttons
echo '<div style="margin-right: 10px;"></div>'; // Add a margin between the buttons
    
        // Add View Driver button
        echo '<form action="driver_profile.php?driver_id=' . $second_id . '" method="POST">';
echo '<button type="submit" class="view-button">View Driver</button>';
echo '</form>';

    
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    
    
    
}    

// Close MySQL connection
mysqli_close($con);
?>




</body>
</html>
