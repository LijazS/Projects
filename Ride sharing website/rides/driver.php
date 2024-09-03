<?php
session_start();
include("functions.php");
include("connection.php");

    $user_data = check_login($con);

    if (!isset($user_data['role']) || $user_data['role'] !== 'driver') {
        header("Location: access_denied.php");
        exit;
    }
    
    // Regenerate session ID
    session_regenerate_id(true);
    
    // Debugging: Output user data to inspect session
    //echo "<pre>";
   // print_r($user_data);
    //echo "</pre>";

// Fetch trip requests meant for the specific user
$query = "SELECT tr.*, tl.*,tr.user_id AS user_name
          FROM trip_requests tr
          INNER JOIN trip_listing tl ON tr.driver_id = tl.user_id 
          WHERE tr.status = 'pending' AND tr.driver_id = ?";

$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_data['id']); // Assuming 'user_id' is the correct key in $user_data
$stmt->execute();
$result = $stmt->get_result();



 ?>



<!DOCTYPE html>
<html data-wf-page="6629e1feefef0981cbce147f" data-wf-site="6629e1fcefef0981cbce12e4">

<head>
    <meta charset="utf-8" />
    <title>Ride Connect</title>
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
</head>

<body bgcolor="black">
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
    <section class="pricing-overview">
        <div class="container">
            <div class="div-block-5">
                <div class="div-block-4">
                    <h2 class="centered-heading">Hi,</h2>
                </div>
                <div class="w-form">
                    <form id="email-form" name="email-form" data-name="Email Form" method="get"
                        data-wf-page-id="6629e1feefef0981cbce147f"
                        data-wf-element-id="0fed311c-82e4-6654-70ce-d3f75a93803b"><label for="name"
                            class="field-label"><?php echo $user_data['username']?></label></form>
                    <div class="w-form-done">
                        <div>Thank you! Your submission has been received!</div>
                    </div>
                    <div class="w-form-fail">
                        <div>Oops! Something went wrong while submitting the form.</div>
                    </div>
                </div>
            </div>
            <div class="pricing-grid">
                <div id="w-node-_2bda493d-21fc-326b-af38-25fee1a5f1f9-cbce147f" class="text-block">Help others with your
                    journey!<br /><br />Offer rides to passengers going your way.</div>
                <div id="w-node-d1e78cd5-844b-4c44-f133-6b4b42fac7d0-cbce147f" class="pricing-card-three">
                    <div class="w-form">                                                                                        <!--form is here -->
                        <form id="email-form-2" name="email-form-2" data-name="Email Form 2" method="POST" action="ride_listing.php" class="form"
                            data-wf-page-id="6629e1feefef0981cbce147f"
                            data-wf-element-id="e008b9d4-9298-d737-30f9-5fe92a3d7fff">
                            <h3 class="heading-3">Where are you going ? </h3>
                            <div class="div-block-3"><img src="images/location.png" loading="lazy"
                                    id="w-node-_959bd618-c576-3947-35e3-7120fce5a93a-cbce147f" sizes="20px" alt=""
                                    srcset="images/location-p-500.png 500w, images/location.png 512w" class="image" />
                                <div id="w-node-d326b215-1f23-f4e7-5373-d44aff150ab1-cbce147f" class="text-block-2">
                                    Starting Trip :</div>
                            </div><input type="text" name="origin" data-name="origin" id="origin" class="select-field w-select">
                                
                            <div class="div-block-3"><img src="images/location.png" loading="lazy"
                                    id="w-node-_4410b993-acc4-0968-2d55-75bcb4897f5c-cbce147f" sizes="20px" alt=""
                                    srcset="images/location-p-500.png 500w, images/location.png 512w" class="image" />
                                <div id="w-node-_4410b993-acc4-0968-2d55-75bcb4897f5d-cbce147f" class="text-block-2">
                                    Ending Trip :</div>
                            </div><input type="text" name="destination" data-name="destination" id="destination" class="select-field w-select">
                               
                            <div class="div-block-3-copy"><img src="images/car.png" loading="lazy"
                                    id="w-node-_57cdd5aa-e9b7-1c45-c6b9-bb5ce6777af0-cbce147f" alt=""
                                    class="image-copy" />
                                <div id="w-node-_57cdd5aa-e9b7-1c45-c6b9-bb5ce6777af1-cbce147f" class="text-block-2">
                                    Seats :</div>
                            </div><select id="seats" name="seats" data-name="seats" class="select-field w-select">
                                <option value="">Select one...</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>
                            <div class="div-block-3-copy-copy"><img src="images/calendar.png" loading="lazy"
                                    id="w-node-_7751a090-f8fc-96b3-47cc-3c57586140a2-cbce147f" alt=""
                                    class="image-copy" />
                                <div id="w-node-_7751a090-f8fc-96b3-47cc-3c57586140a3-cbce147f"
                                    class="text-block-2-copy">Date :</div><img src="images/clock.png" loading="lazy"
                                    id="w-node-_16b82275-97e0-06f6-2cee-541495b388ba-cbce147f" sizes="20px" alt=""
                                    srcset="images/clock-p-500.png 500w, images/clock.png 512w" class="image-copy" />
                                <div id="w-node-_80f3244b-6641-431b-e16b-f774c76593cf-cbce147f"
                                    class="text-block-2-copy">Time :</div>
                            </div>
                            <div class="div-block-6"><input id="field-2" type="date" name="field-2" data-name="Field 2"
                                    class="select-field w-node-_6408d1ba-5c63-e1d6-2b7e-f0606cbf6dc0-cbce147f w-select">
                                    
                                    
                                    
                               <input type="time" id="field-2" name="field-2" data-name="Field 2"
                                    class="select-field w-node-_4694de79-9d1e-eaad-766e-f4238bb91b47-cbce147f w-select">
                                    
                                </div>
                                <button type="submit" class="button-primary w-button" style="margin-top: 20px;">SUBMIT</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="hero-stack">
    <div class="container-3">
        <div class="hero-wrapper-two">
            <h2 class="centered-heading2"><centre>AVAILABLE REQUESTS</centre></h2>
            
            <!-- Trip requests form -->
            <form method="post" action="handle_requests.php">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                        $user_name = $row['user_name'];
                       
                         


                        echo "<div style='
                        background-color: #f3f3f3;
                        border: 0 solid #302b2b;
                        border-radius: 19px;
                        width: 1150px;
                        height: 125px;
                        margin-bottom: 20px;
                        padding-top: 30px;
                        
                      '>";
                        echo "<p  style='margin-bottom:10px;text-align: center; font-size:18px;font-weight: bold;';>New trip request from " . $row['user_name'] . "</p>";
                        echo "<input type='hidden' name='trip_id' value='" . $row['trip_id'] . "'>";
                        echo "<button type='submit' name='action' value='accept' style='margin-right:30px' class='button-primary w-button'>Accept</button>";
                        echo "<button type='submit' name='action' value='reject' class='button-primary w-button'>Reject</button>";
                        echo "</div>";
                    }
                } else {
                    echo "<p class='no-requests-text'>No new trip requests.</p>";
                }
                ?>
            </form>
        </div>
    </div>
</section>



    <section class="hero-heading-right">
        <div class="container-2">
            <div class="hero-wrapper">
                <div class="hero-split"><img src="images/image-20-1-.png" loading="lazy"
                        sizes="(max-width: 479px) 34vw, (max-width: 767px) 36vw, (max-width: 991px) 258px, 13vw"
                        srcset="images/image-20-1-p-500.png 500w, images/image-20-1-.png 512w" alt=""
                        class="shadow-two" /></div>
                <div class="hero-split">
                    <h1 class="heading"><strong class="bold-text">Trust who you travel with</strong></h1>
                    <p class="margin-bottom-24px">We take the time to get to know each of our members and bus partners.
                        We check reviews, profiles and IDs, so you know who you’re travelling with and can book your
                        ride at ease on our secure platform.</p>
                </div>

                
            </div>
            <div class="hero-wrapper">
                <div class="hero-split"><img src="images/image.png" loading="lazy"
                        sizes="(max-width: 479px) 27vw, (max-width: 767px) 29vw, (max-width: 991px) 223px, 12vw"
                        srcset="images/image-p-500.png 500w, images/image.png 512w" alt="" class="shadow-two" /></div>
                <div class="hero-split">
                    <h1 class="heading-copy"><strong class="bold-text-2">Your pick of rides at low prices</strong></h1>
                    <p class="margin-bottom-24px">No matter where you’re going, by bus or carpool, find the perfect ride
                        from our wide range of destinations and routes at low prices.</p>
                </div>
            </div>
        </div>
    </section>

   

    <section class="footer-dark">
        <div class="container-2">
            <div class="footer-wrapper">
                <div class="footer-content">
                    <div id="w-node-dd1de879-0890-5ac7-5659-466e3fc48be9-cbce147f" class="footer-block">
                        <div class="title-small">Company</div><a href="#" class="footer-link">Terms</a><a href="#"
                            class="footer-link">Pricing</a><a href="#" class="footer-link">Docs</a>
                    </div>
                    <div id="w-node-dd1de879-0890-5ac7-5659-466e3fc48bf2-cbce147f" class="footer-block">
                        <div class="title-small">about</div><a href="#" class="footer-link">How it works</a><a href="#"
                            class="footer-link">About Us</a><a href="#" class="footer-link">Help Centre</a><a href="#"
                            class="footer-link">Press</a>
                    </div>
                    <div id="w-node-dd1de879-0890-5ac7-5659-466e3fc48bfd-cbce147f" class="footer-block">
                        <div class="title-small">About</div><a href="#" class="footer-link">Terms &amp; Conditions</a><a
                            href="#" class="footer-link">Privacy policy</a>
                        <div class="footer-social-block"><a href="#" class="footer-social-link-2 w-inline-block"><img
                                    src="images/twitter-20small.svg" loading="lazy" alt="" /></a><a href="#"
                                class="footer-social-link-2 w-inline-block"><img src="images/linkedin-20small.svg"
                                    loading="lazy" alt="" /></a><a href="#"
                                class="footer-social-link-2 w-inline-block"><img src="images/facebook-20small.svg"
                                    loading="lazy" alt="" /></a></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-divider"></div>
        <div class="footer-copyright-center">Copyright © 2024  RideConnect</div>
    </section>
    <script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/webflow-script.js" type="text/javascript"></script>
</body>



 <!-- Footer-->
         
         <!-- Bootstrap core JS-->
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
         <!-- Core theme JS-->
         <script src="js/scripts.js"></script>

         <!-- google maps places api- location suggestion during typing-->
         <script src="https://maps.googleapis.com/maps/api/js?key= AIzaSyAEXPKTjfD67iIZl7_AY99DGyrf2LSpIoo&libraries=places"></script>
         <script>
    document.addEventListener('DOMContentLoaded', function() {
        var originInput = document.getElementById('origin');
        var destinationInput = document.getElementById('destination');

        var options = {
            componentRestrictions: { country: 'IN' } 
        };

        var autocompleteOrigin = new google.maps.places.Autocomplete(originInput, options);
        var autocompleteDestination = new google.maps.places.Autocomplete(destinationInput, options);
    });
</script>

 <!-- Script for fetching new trip requests -->
 <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to fetch new trip requests
            function fetchNewRequests() {
                fetch("fetch_new_trip_requests.php")
                    .then(response => response.json())
                    .then(data => {
                        const notificationList = document.getElementById("notification-list");
                        notificationList.innerHTML = ""; // Clear previous notifications
                        data.forEach(request => {
                            const requestElement = document.createElement("div");
                            requestElement.classList.add("notification-item");
                            requestElement.textContent = `New trip request from ${request.driver_id}: ${request.origin} to ${request.destination}`;
                            notificationList.appendChild(requestElement);
                        });
                    })
                    .catch(error => {
                        console.error("Error fetching new trip requests:", error);
                    });
            }

            // Fetch new trip requests initially and then every 30 seconds
            fetchNewRequests();
            setInterval(fetchNewRequests, 30000); // 30 seconds
        });
    </script>

</html>