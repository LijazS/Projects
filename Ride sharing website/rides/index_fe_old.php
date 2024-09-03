<?php
session_start();
include("functions.php");
include("connection.php");

    $user_data = check_login($con);
    
    if (!isset($user_data['role']) || $user_data['role'] !== 'regular'  || $user_data['gender'] !== 'FEMALE') {
        header("Location: access_denied.php");
        exit;
    }
    
    // Regenerate session ID
    session_regenerate_id(true);
    
    // Debugging: Output user data to inspect session
    //echo "<pre>";
   // print_r($user_data);
    //echo "</pre>";
    
 ?>

 <!DOCTYPE html>
 <html lang="en">
     <head>
         <meta charset="utf-8" />
         <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
         <meta name="description" content="" />
         <meta name="author" content="" />
         <title>RIDE SHARE</title>
         <!-- Favicon-->
         <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
         <!-- Bootstrap icons-->
           <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
         <!-- Core theme CSS (includes Bootstrap)-->
         <link href="css/styles.css" rel="stylesheet" />
     </head>
     <body>
         <!-- Navigation-->
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
         <!-- Header-->
         
         <!-- Section-->
         
         <div class="container">
        <h2>Whats your destination</h2>
<form action="get_waypoints.php" method="POST">
    <div class="form-group">
        <label for="origin">Origin:</label>
        <input type="text" name="origin" id="origin" required>
    </div>
    <div class="form-group">
        <label for="destination">Destination:</label>
        <input type="text" name="destination" id="destination" required>
    </div>
    <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="femaleOnly" name="femaleOnly">
            <label class="form-check-label" for="femaleOnly">
                Female Only
            </label>
        </div>
    <button type="submit">SEARCH TRIPS</button>
</form>
    </div>


         
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

     </body>
 </html>
