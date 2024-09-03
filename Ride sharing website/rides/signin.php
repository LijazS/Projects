<?php
session_start();
include("functions.php");
include("connection.php");

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if(!empty($username) && !empty($password)) {
        $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
        $result = mysqli_query($con, $query);

        if($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            if($user_data['password'] == $password) {
                $_SESSION['user_id'] = $user_data['id'];

                // Check user role
                $role = $user_data['role'];
                $gender = $user_data['gender'];
                if ($role == 'driver') {
                    header("Location: driver.php"); // Redirect for drivers
                } else {
                    if ($gender == 'FEMALE') {
                        header("Location: index_fe.php"); // Redirect for females
                    } else {
                        header("Location: index.php"); // Redirect for others
                    }
                }
                exit; // Ensure script execution stops after redirection
            }
        }
    }
    echo "Please enter valid credentials";
}
?> 


<!DOCTYPE html>
<html
  data-wf-page="6629ffbcab2493b22dab7f8f"
  data-wf-site="6629ffbcab2493b22dab7f94"
>
  <head>
    <meta charset="utf-8" />
    <title>Ride Connect</title>
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="Webflow" name="generator" />
    <link href="css/webflow-style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
      !(function (o, c) {
        var n = c.documentElement,
          t = " w-mod-";
        (n.className += t + "js"),
          ("ontouchstart" in o ||
            (o.DocumentTouch && c instanceof DocumentTouch)) &&
            (n.className += t + "touch");
      })(window, document);
    </script>
    <link href="images/favicon.png" rel="shortcut icon" type="image/x-icon" />
    <link href="images/app-icon.png" rel="apple-touch-icon" />
  </head>
  <body>
    <div class="navbar-logo-left">
      <div class="div-block-2">
        <div
          data-animation="default"
          data-collapse="medium"
          data-duration="400"
          data-easing="ease"
          data-easing2="ease"
          role="banner"
          class="navbar-logo-left-container shadow-three w-nav"
        >
          <div class="container">
            <div class="div-block">
              <nav role="navigation" class="nav-menu-wrapper w-nav-menu">
                <ul role="list" class="nav-menu-two w-list-unstyled">
                  <li><a href="home.html" class="nav-link">Home</a></li>
                  
                  <li>
                    <div
                      data-hover="false"
                      data-delay="0"
                      class="nav-dropdown w-dropdown"
                    >
                     
                       
                    </div>
                  </li>
                  <li><div class="nav-divider"></div></li>
                  
                  <li class="mobile-margin-top-10">
                    <a href="signup.php" class="button-primary w-button">sign UP</a>
                  </li>
                </ul>
              </nav>
              <div class="menu-button w-nav-button">
                <div class="w-icon-nav-menu"></div>
              </div>
            </div>
          </div>
          <a href="#" class="nav-link-accent-copy">RideConnect</a>
        </div>
      </div>
    </div>
    <section class="pricing-overview">
      <div class="container" >
        <p class="pricing-description"><br /></p>
        <div class="pricing-grid" >
          <div
            id="w-node-d1e78cd5-844b-4c44-f133-6b4b42fac7c6-2dab7f8f"
            class="pricing-card-three" style="height: 250px;"
          >
            <div class="div-block-3" >
              <h1 class="heading-copy" style="margin-top: 10px">
                Sign in <strong class="bold-text"></strong>
              </h1>
              <div class="div-block-4">
                <div class="w-form">
                  <form
                     method="post"
                    
                    
                  >
                    <input
                      class="text-field w-input"
                      maxlength="256"
                      name="username"
                      data-name="username"
                      placeholder="Enter Your Username"
                      type="text"
                      id="username"
                      required
                    /><input
                      class="text-field-2 w-input"
                      type="password" placeholder="Enter your password" name="password" required
                    /><input
                      type="submit"
                  
                      class="button-primary-copy w-button"
                      value="Sign in"
                    />
                  </form>
                  <div class="w-form-done">
                    <div>Thank you! Your submission has been received!</div>
                  </div>
                  <div class="w-form-fail">
                    <div>
                      Oops! Something went wrong while submitting the form.
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="footer-dark">
      <div class="container-2">
        <div class="footer-wrapper">
          <div class="footer-content">
            <div
              id="w-node-_3495314c-0493-fd19-8288-7778c7aab390-2dab7f8f"
              class="footer-block"
            >
              <div class="title-small">Company</div>
              <a href="#" class="footer-link">Terms</a
              ><a href="#" class="footer-link">Pricing</a
              ><a href="#" class="footer-link">Docs</a>
            </div>
            <div
              id="w-node-_3495314c-0493-fd19-8288-7778c7aab399-2dab7f8f"
              class="footer-block"
            >
              <div class="title-small">Resources</div>
              <a href="#" class="footer-link">How it Works</a
              ><a href="#" class="footer-link">About Us</a
              ><a href="#" class="footer-link">Help Center</a
              ><a href="#" class="footer-link">Press</a>
            </div>
            <div
              id="w-node-_3495314c-0493-fd19-8288-7778c7aab3a4-2dab7f8f"
              class="footer-block"
            >
              <div class="title-small">About</div>
              <a href="#" class="footer-link">Terms &amp; Conditions</a
              ><a href="#" class="footer-link">Privacy policy</a>
              <div class="footer-social-block">
                <a href="#" class="footer-social-link-2 w-inline-block"
                  ><img
                    src="images/twitter-20small.svg"
                    loading="lazy"
                    alt="" /></a
                ><a href="#" class="footer-social-link-2 w-inline-block"
                  ><img
                    src="images/linkedin-20small.svg"
                    loading="lazy"
                    alt="" /></a
                ><a href="#" class="footer-social-link-2 w-inline-block"
                  ><img src="images/facebook-20small.svg" loading="lazy" alt=""
                /></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-divider"></div>
      <div class="footer-copyright-center">Copyright © 2024 RideConnect</div>
    </section>
    
  </body>
</html>
