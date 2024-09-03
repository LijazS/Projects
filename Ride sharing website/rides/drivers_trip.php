<?php 

session_start();
include("functions.php");
include("connection.php");

$user_data = check_login($con);

if (!isset($user_data['role']) || $user_data['role'] !== 'driver') {
    header("Location: access_denied.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="Webflow" name="generator" />
    <link href="css/webflow-style_3.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin="anonymous" />
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
    <script
        type="text/javascript">WebFont.load({ google: { families: ["Inconsolata:400,700", "Ubuntu:300,300italic,400,400italic,500,500italic,700,700italic"] } });</script>
    <script
        type="text/javascript">!function (o, c) { var n = c.documentElement, t = " w-mod-"; n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n.className += t + "touch") }(window, document);</script>
    <link href="images/favicon.png" rel="shortcut icon" type="image/x-icon" />
    <link href="images/app-icon.png" rel="apple-touch-icon" />
    <style>
    

    body {
  color: #333;
  background-color: black;
  min-height: 100%;
  margin: 0;
  font-family: Arial, sans-serif;
  font-size: 14px;
  line-height: 20px;
}
    .container_5 {
        background-color: #e6e6e6;
       
        border-radius: 10px; /* Rounded corners for a modern look */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
    padding: 2rem; /* Reduced padding for a cleaner appearance */
        
      
       
        margin-left:-300px;
        margin-right:-600px;
        margin-bottom:-50px;
        margin-top:-50px;
        position: relative; /* Ensure the z-index works */
    z-index: 999; /* Set a high z-index value to bring it on top */
    }

    .container_5 h1 {
    font-size: 2rem; /* Larger font size for the title */
    margin-bottom: 1rem;
    margin-top: 1rem; /* Spacing below the title */
}

.container_5 p {
    font-size: 1.1rem; /* Slightly increased font size for better readability */
    margin-bottom: 0.5rem; /* Spacing between paragraphs */
}

.container_5 form {
    margin-top: 1.5rem; /* Increased spacing between content and form */
}

.container_5 button {
    background-color: #007bff; /* Blue button color */
    color: #fff; /* White text color */
    border: none;
    padding: 0.75rem 1.5rem; /* Padding for button */
    border-radius: 5px; /* Rounded corners for button */
    cursor: pointer;
    font-size: 1.1rem; /* Font size for button */
    transition: background-color 0.3s; /* Smooth transition for hover effect */
}

.container_5 button:hover {
    background-color: #0056b3; /* Darker blue color on hover */
}

    .container_6 {
        width: calc(60% - 10px); /* Adjust the width as needed */
    display: inline-block;
    margin-right: 20px; 
    margin-top: 200px;/* Adjust the margin between containers */
    vertical-align: top; /* Align containers at the top */
        max-width: 1800px;
    margin: 0 auto 40px auto; /* Set margin for horizontal alignment */
    padding: 20px;
    border: 1px solid #ddd; /* Add border with a slight color */
    border-radius: 30px; /* Add border radius for rounded corners */
    box-shadow: 0 2px 2px rgba(0, 0, 0, 0.1); /* Add box shadow for a slight elevation */
    
    }

    #accepted-users-container {
    float: left; /* Float the container to the left */
    margin-left:10px;
}

#new-trip-requests-container {
    float: right;
    width: 700px; /* Float the container to the right */
    margin-right: 20px;
    
}

.container_7 {
    background-color: #A9A9A9;
        
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding: 5rem;
        margin-bottom: 2rem;
    
    }

    h1, h2 {
        color: #333;
        margin-bottom: 1rem;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
        color: #333;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .price {
        font-weight: bold;
        color: #28a745;
    }

  
    

    

    .user-info {
        display: flex;
        align-items: center;
    }

    .user-name {
        margin-right: 1rem;
        font-weight: bold;
        color: #333;
    }

    .user-icon {
        font-size: 1.5rem;
        color: #333;
    }

   
    
</style>

</head>
<body   background-color: black>

<div class="navbar-logo-left">
        <div class="div-block-2">
            <div data-animation="default" data-collapse="medium" data-duration="400" data-easing="ease"
                data-easing2="ease" role="banner" class="navbar-logo-left-container shadow-three w-nav">
                <div class="container">
                    <div class="div-block">
                        <nav role="navigation" class="nav-menu-wrapper w-nav-menu">
                            <ul role="list" class="nav-menu-two w-list-unstyled">
                            <li><a href="driver.php" class="nav-link">Home</a></li>
                            <li><a href="drivers_trip.php" class="nav-link">Your trip</a></li>
                                
                                <li>
                                    <div class="nav-divider"></div>
                                </li>
                                
                                <a class="button-primary w-button" aria-current="page" href="signin.php">LOGOUT</a>
                                </li>
                            </ul>
                        </nav>
                        <div class="menu-button w-nav-button">
                            <div class="w-icon-nav-menu"></div>
                        </div>
                    </div>
                </div><a href="#" class="nav-link-accent-copy">RideConnect</a>
            </div>
        </div>
    </div>
    

<?php
// Assuming you have already established a database connection

// Fetch trip details from the trip_listing table
$query_trip_details = "SELECT origin, destination, seats, seats_used,trip_id FROM trip_listing WHERE user_id = ?";
$stmt_trip_details = $con->prepare($query_trip_details);
$stmt_trip_details->bind_param("i", $user_data['id']); // Assuming $trip_id holds the trip ID
$stmt_trip_details->execute();
$result_trip_details = $stmt_trip_details->get_result();

// Check if there are any trips listed for the driver
if ($result_trip_details->num_rows > 0) {
    // If there are trips listed, proceed to display trip details
    $row_trip_details = $result_trip_details->fetch_assoc();

    // Assign fetched values to variables
    $origin = $row_trip_details['origin'];
    $destination = $row_trip_details['destination'];
    $seats = $row_trip_details['seats'];
    $seats_used = $row_trip_details['seats_used'];
    $trip_id = $row_trip_details['trip_id'];
    // Calculate available seats
    $seats_available = $seats - $seats_used;
?>

<section class="pricing-overview">
        <div class="container">
            <div class="div-block-5">
                <div class="div-block-4">
                    
                </div>
                <div class="w-form">
                    
                    <div class="w-form-done">
                        <div>Thank you! Your submission has been received!</div>
                    </div>
                    <div class="w-form-fail">
                        <div>Oops! Something went wrong while submitting the form.</div>
                    </div>
                </div>
            </div>
            <div class="pricing-grid">
               
                
                    <div class="container_5">
    <h1>Trip Details</h1>
    <p><strong>Origin:</strong> <?php echo $origin; ?></p>
    <p><strong>Destination:</strong> <?php echo $destination; ?></p>
    <p><strong>Seats:</strong> <?php echo $seats; ?></p>
    <p><strong>Seats Used:</strong> <?php echo $seats_used; ?></p>
    <p><strong>Seats Available:</strong> <?php echo $seats_available; ?></p>
    <!-- Add Google Maps view here -->
    <form method="post" action="finish_trip.php">
        <input type="hidden" name="trip_id" value="<?php echo $trip_id; ?>">
        <button type="submit" class="button-primary w-button" style="    color: var(--black);
    letter-spacing: 2px;
    text-transform: uppercase;
    background-color: #80e0a9;
    border-radius: 20px;
    padding: 12px 25px;
    font-size: 12px;
    line-height: 20px;
    transition: all .2s;">Finish Trip</button>
    </form>
</div>

                </div>
            
        </div>
    </section>


<div class="container_6" style="margin-right: 200px;margin-top: 20px;border-radius:10px;transform: translate( 175px,0);width:1350px; background: white" id="accepted-users-container">
    <h1>Accepted Users</h1>
    <table>
        <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Retrieve passenger details from the trip_requests table
            $query = "SELECT tr.user_id, u.username, u.email, tr.price
                      FROM trip_requests tr
                      INNER JOIN users u ON tr.user_id = u.id
                      WHERE tr.status = 'accepted'";
            $result = mysqli_query($con, $query);

            // Output accepted users and their prices
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['user_id'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td class='price'>$" . $row['price'] . "</td>"; // Display price per passenger
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<div class="container_6" style="border-radius:10px;transform: translate( -350px,0);width:1350px; margin-bottom:30px;background: white" id="new-trip-requests-container">
    <h2>New Trip Requests</h2>
    <div id="notification-section">
        <div id="notification-list">
            <form method="post" action="handle_requests.php">
                <?php
                $query = "SELECT tr.*, tl.*,tr.user_id AS user_name
                FROM trip_requests tr
                INNER JOIN trip_listing tl ON tr.driver_id = tl.user_id 
                WHERE tr.status = 'pending' AND tr.driver_id = ?";
      
      $stmt = $con->prepare($query);
      $stmt->bind_param("i", $user_data['id']); // Assuming 'user_id' is the correct key in $user_data
      $stmt->execute();
      $result = $stmt->get_result();
      
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                        $user_name = $row['user_name'];
                        echo "<div class='notification-item'>";
                        echo "<span style='color: var(--black); font-size:1rem; font-weight:bold;'>New trip request from &nbsp" . $row['user_name'] . "</span>";
                        // Add accept and reject buttons with hidden inputs for trip id
                        echo "<input type='hidden' name='trip_id' value='" . $row['trip_id'] . "'>";
                        echo "<button type='submit' name='action' value='accept' style='background-color: #80e0a9; color: var(--black); padding: 10px 20px; border: none; border-radius: 20px; margin-right: 5px; margin-left:10px;'>Accept</button>";
                        echo "<button type='submit' name='action' value='reject' style='background-color: red; color: var(--black); padding: 10px 20px; border: none; border-radius: 20px;'>Reject</button>";

                        echo "</div>";
                    }
                } else {
                    echo "No new trip requests.";
                }
                ?>
            </form>
        </div>
    </div>
</div>

<?php
} else {
    // If there are no trips listed, display a message
?>
<div class="container_7">
    <style>
        .body{
            background-color:#fff;
        }
        </style>
    <h1>No Trips Listed</h1>
    <p>You currently have no trips listed.</p>
</div>
<?php
}
?>

<script>
    setTimeout(function() {
        window.location.reload();
    }, 5000); // Refresh every 5 seconds (5000 milliseconds)
</script>

</body>
</html>
