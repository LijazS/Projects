<?php
session_start();
include("functions.php");
include("connection.php");

// Check if user is logged in
$user_data = check_login($con);

// Check if driver_id is provided in the URL parameter
if (!isset($_GET['driver_id'])) {
    // Redirect if driver_id is not provided
    
    header("Location: error.php");
    exit;
}

// Retrieve driver information
$driver_id = $_GET['driver_id'];
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $driver_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Redirect if driver does not exist
    header("Location: error.php");
    exit;
}

// Fetch driver details
$driver_info = $result->fetch_assoc();
$driver_name = $driver_info['username'];
$driver_email = $driver_info['email'];
$driver_phone = $driver_info['phone_number'];
$driver_gender = $driver_info['gender'];
// Add more driver details if needed

// Fetch driver's reviews and ratings
$query_reviews = "SELECT * FROM reviews WHERE driver_id = ?";
$stmt_reviews = $con->prepare($query_reviews);
$stmt_reviews->bind_param("i", $driver_id);
$stmt_reviews->execute();
$result_reviews = $stmt_reviews->get_result();
?>



<!DOCTYPE html>
<html data-wf-page="6629e1feefef0981cbce147f" data-wf-site="6629e1fcefef0981cbce12e4">

<head>
    <meta charset="utf-8" />
    <title>Ride Connect</title>
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="Webflow" name="generator" />
    <link href="css/webflow-style_4.css" rel="stylesheet" type="text/css" />
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

<body>
    <div class="navbar-logo-left">
        <div class="div-block-2">
            <div data-animation="default" data-collapse="medium" data-duration="400" data-easing="ease"
                data-easing2="ease" role="banner" class="navbar-logo-left-container shadow-three w-nav">
                <div class="container">
                    <div class="div-block">
                        <nav role="navigation" class="nav-menu-wrapper w-nav-menu">
                            <ul role="list" class="nav-menu-two w-list-unstyled">
                                <li><a href="#" class="nav-link">Feature</a></li>
                                <li><a href="#" class="nav-link">User Examples</a></li>
                                <li><a href="#" class="nav-link">Pricing</a></li>
                                <li>
                                    <div data-hover="false" data-delay="0" class="nav-dropdown w-dropdown">
                                        <div class="nav-dropdown-toggle w-dropdown-toggle">
                                            <div class="nav-dropdown-icon w-icon-dropdown-toggle"></div>
                                            <div class="nav-link">Resources</div>
                                        </div>
                                        <nav class="nav-dropdown-list shadow-three mobile-shadow-hide w-dropdown-list">
                                            <a href="#" class="nav-dropdown-link w-dropdown-link">Resource Link 1</a><a
                                                href="#" class="nav-dropdown-link w-dropdown-link">Resource Link 2</a><a
                                                href="#" class="nav-dropdown-link w-dropdown-link">Resource Link 3</a>
                                        </nav>
                                    </div>
                                </li>
                                <li>
                                    <div class="nav-divider"></div>
                                </li>
                                <li><a href="#" class="nav-link">Docs</a></li>
                                <li class="mobile-margin-top-10"><a href="#" class="button-primary w-button">sign UP</a>
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
        <h1 class="heading-4-copy">INFORMATON &amp; REVIEWS</h1>
        <div class="container">
            <div class="pricing-grid">
                <div id="w-node-d1e78cd5-844b-4c44-f133-6b4b42fac7c6-cbce147f" class="pricing-card-three-copy">
                    <div class="div-block-3" style="text-align: left; ">
                        <h1 class="heading-4">Driver Details</h1>
                        <div class="review-section" style="text-align: left; padding-left: 25px;margin-top:150px;background-color: #e8e8e8;height:180px;padding-top:15px;width:295px;margin-left:18px;border-radius:10px">
           
            <p style="margin-bottom:25px; font-size:18px;"><strong>Name:</strong> <?php echo $driver_name; ?></p>
            <p style="margin-bottom:25px; font-size:18px;"><strong>Email:</strong> <?php echo $driver_email; ?></p>
            <p style="margin-bottom:25px; font-size:18px;"><strong>Gender:</strong> <?php echo $driver_gender; ?></p>
            <p style="margin-bottom:25px; font-size:18px;"><strong>Phone Number:</strong> <?php echo $driver_phone; ?></p>
            <!-- Add more driver details here -->
        </div>
                    </div>
                    <div class="div-block-3-copy">
                        <div class="text-block"></div>
                        <div class="w-form">
                           
                            <div class="w-form-done">
                                <div>Thank you! Your submission has been received!</div>
                            </div>
                            <div class="w-form-fail">
                                <div>Oops! Something went wrong while submitting the form.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="w-node-fd83eb41-2e51-92a3-422e-998f52bd64fc-cbce147f" class="pricing-card-three-copy-copy">
                    <div class="div-block-3">
                        <h1 class="heading-4">Customer Reviews</h1>
                        
                    </div>
                    <div class="div-block-5" style="overflow-y: scroll;"> 
                         <?php if ($result_reviews->num_rows > 0) : ?>
                        <?php while ($row_review = $result_reviews->fetch_assoc()) : ?>
                        <div class="review-box" style="    ;
 
   

    background-color: #BEBEBE;
    width: 95%;
    height: 30%;
    margin-top: 15px;
    margin-left: 20px;
    margin-bottom: 15px;
    margin-right: 0;
    padding-top: 10px;
    padding-left: 15px;
    border-radius: 15px;
    text-align : left;

   " >
                        <div class="user-rating">
                        <p class="user"><b>User:</b> <?php echo $row_review['reviewer_id']; ?></p>
                        <p class="rating"><b>Rating:</b> <?php echo $row_review['rating']; ?>/5</p>
                        </div>
                        <div class="comment-box">
                        <p class="comment"><?php echo $row_review['review_text']; ?></p>
                         </div>
                        </div>
                        <?php endwhile; ?>
                            <?php else : ?>
                    <p>No reviews yet.</p>
                    <?php endif; ?></div>
                     </div>
                    </div>
            
            
            
                    <div class="rounded-box">
            <form action="submit_review.php" method="post">
  <label class="field-label" for="comment">REVIEW</label>
    <textarea class="text-field-88" id="comment" name="review_text" required placeholder="Enter Review"></textarea>
    <br>
   
    
   <label class="field-label" for="rating">Rating (1-5):</label>
    <select class="text-field-88" type="number" id="rating" name="rating" min="1" max="5" required>
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>   
      <option value="4">4</option>
      <option value="5">5</option>
    </select>
    <br>
    <input type="hidden" name="driver_id" value="<?php echo $driver_id; ?>">
    <button class="button-primary" type="submit">Submit</button>
    <button class="button-primary" type="reset">Reset</button>
  </form>
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

</html>