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
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="Webflow" name="generator" />
    <link href="css/webflow-style_7.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin="anonymous" />
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js" type="text/javascript"></script>
    <script
        type="text/javascript">WebFont.load({ google: { families: ["Inconsolata:400,700", "Ubuntu:300,300italic,400,400italic,500,500italic,700,700italic"] } });</script>
    <script
        type="text/javascript">!function (o, c) { var n = c.documentElement, t = " w-mod-"; n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n.className += t + "touch") }(window, document);</script>
    <link href="images/favicon.png" rel="shortcut icon" type="image/x-icon" />
    <title>Accepted Trip</title>
    <!-- Add your CSS styles here -->
    <style>

iframe {
    width: 100%;
    max-width: 800px;
    height: 400px;
    border: 1px solid #ccc;
    border-radius: 8px;
    margin-left: 20px;
    margin-top:10px;
    margin-bottom:50px;
    border:20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Add box shadow */
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


.container_7 {
    background-color: #A9A9A9;
        
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding: 5rem;
        margin-bottom: 2rem;
}


.trip-info {
    background-color: #f9f9f9;
    border-radius: 8px;
    padding: 30px;
    margin-top:20px;
}

.trip-info h2 {
    font-size: 24px;
    margin-bottom: 20px;
}

.driver-info {
    font-size: 16px;
}

.driver-detail {
    margin-bottom: 10px;
}

.detail-label {
    font-weight: bold;
    color: #333;
}

.detail-value {
    color: #666;
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

    
    .payment-info {
            margin-top:20px;
            font-size: 1.5rem;

    }

    .price-value {
        color: #188431;
    }


    
button.reached-destination-button{
    background-color: #9CC0F9; /* Green */
    border: none;
    color: black;
    padding: 12px 24px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    transition-duration: 0.4s;
    cursor: pointer;
    border-radius: 20px;

}

    button.pay-now-button {
    background-color: #80E0A9; /* Green */
    border: none;
    color: black;
    padding: 12px 24px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    transition-duration: 0.4s;
    cursor: pointer;
    border-radius: 20px;
}


button.reached-destination-button:hover{

    background-color: #30BFFD;
}

button.pay-now-button:hover
 {
    background-color: #45a049; /* Darker green */
}

button.pay-now-button:active,
button.reached-destination-button:active {
    background-color: #4CAF50; /* Green */
    box-shadow: 0 5px #666;
    transform: translateY(4px);
}

.popup-container {
  display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color:#ff0000 ; /* Red background color */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Shadow */
    z-index: 9999; /* Ensure it's on top of other elements */
}

.popup-content {
    text-align: center;
    color: white;
}

.popup-content p {
    font-size: 18px;
    margin-bottom: 20px;
}

.call-now-btn, .cancel-btn {
    padding: 10px 20px;
    margin: 0 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.call-now-btn {
    background-color: #33cc33; /* Green */
}

.cancel-btn {
    background-color: #ffa500; /* Red */
}

.call-now-btn:hover, .cancel-btn:hover {
    background-color: #333; /* Darken on hover */
}


</style>
</head>
<body>

<div class="navbar-logo-left">
        <div class="div-block-2">
            <div data-animation="default" data-collapse="medium" data-duration="400" data-easing="ease"
                data-easing2="ease" role="banner" class="navbar-logo-left-container shadow-three w-nav">
                <div class="container">
                    <div class="div-block">
                        <nav role="navigation" class="nav-menu-wrapper w-nav-menu">
                            <ul role="list" class="nav-menu-two w-list-unstyled">
                            <li><a href="index.php" class="nav-link">Home</a></li>
                            <li><a href="accepted_trip.php" class="nav-link">My trip</a></li>
                                
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
</div>
    

<?php
// Retrieve trip information including driver details
$query = "SELECT tl.origin, tl.destination, tl.user_id AS driver_id, u.username AS driver_username,u.gender AS driver_gender,u.phone_number AS driver_phone,tr.price,tr.trip_id
FROM trip_requests tr
INNER JOIN trip_listing tl ON tr.trip_id = tl.trip_id
INNER JOIN users u ON tl.user_id = u.id
WHERE tr.user_id = ? AND tr.status = 'accepted'";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_data['id']); // Assuming 'id' is the correct key in $user_data
$stmt->execute();
$result = $stmt->get_result();

// Fetch trip information
if ($result->num_rows > 0) {
$row = $result->fetch_assoc();
$origin = $row['origin'];
$destination = $row['destination'];
$driver_id = $row['driver_id'];
$driver_name = $row['driver_username'];
$driver_gender = $row['driver_gender'];
$driver_phone = $row['driver_phone'];
$price = $row['price'];
$trip_id  = $row['trip_id'];
// $driver_contact_info = $row['driver_contact_info'];

// Google Maps API configuration
$api_key = "AIzaSyBjE1XvpzE2Ho2wPZh2ctTIIXglKA6mf1Y";
$origin_encoded = urlencode($origin);
$destination_encoded = urlencode($destination);
$map_url = "https://www.google.com/maps/embed/v1/directions?key=$api_key&origin=$origin_encoded&destination=$destination_encoded";

// HTML output
?>



<div class="popup-container">
                <div class="popup-content">
                    <p>Emergency detected. Please contact help now.</p>
                    <form method="post">
                        <button type="submit" name="call_now" class="call-now-btn">Call Now</button>
                        <button type="button" class="cancel-btn" onclick="closePopup()">Cancel</button>
                    </form>
                </div>
            </div>

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
    <div class="trip-info">
        <h2>You are now in a trip with:</h2>
        <div class="driver-info">
            <div class="driver-detail">
                <span class="detail-label">Driver ID:</span>
                <a href="driver_profile.php?driver_id=<?php echo $driver_id; ?>" class="detail-value"><?php echo $driver_id; ?></a>
            </div>
            <div class="driver-detail">
                <span class="detail-label">Driver Name:</span>
                <span class="detail-value"><?php echo $driver_name; ?></span>
            </div>
            <div class="driver-detail">
                <span class="detail-label">Driver Gender:</span>
                <span class="detail-value"><?php echo $driver_gender; ?></span>
            </div>
            <div class="driver-detail">
                <span class="detail-label">Driver Contact Information:</span>
                <span class="detail-value"><?php echo $driver_phone; ?></span>
            </div>
        </div>
    </div>
    </div>
            
        </div>
    </section>

    <div class="payment-info">
        
    <div class="driver-detail">
                <span class="detail-label">Amount:</span>
                <span class="price-value"><?php echo $price; ?></span>$
            </div>
            
        <button class="pay-now-button">Pay Now</button>
        <form id="reached-destination-form" action="handle_reached_destination.php" method="post">
    <input type="hidden" name="trip_id" value="<?php echo $trip_id; ?>">
    <button type="submit" class="reached-destination-button">Reached Destination</button>
    <a class="button-primary w-button" style="background-color: red;" style="margin-left:100px;"  aria-current="page" onclick="showPopup()">EMERGENCY</a>
</form>

    </div>

</div>

    <h2>Directions:</h2>
    <iframe width="600" height="450" frameborder="0" style="border:0" src="<?php echo $map_url; ?>" allowfullscreen></iframe>

    <script>
        function showPopup() {
            document.querySelector(".popup-container").style.display = "block";
        }

        function closePopup() {
            document.querySelector(".popup-container").style.display = "none";
        }
    </script>
</body>
</html>
<?php
} else {
    // If no trip could be fetched, display a message
   
   echo "<div class='container_7'>";
   echo "<h1>You are not currently in a trip.</h1>";
   
echo "</div>";


    
}
?>