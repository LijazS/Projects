<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="" />
         <meta name="author" content="" />
         <title>MOVIE DATABASE</title>
         <!-- Favicon-->
         <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
         <!-- Bootstrap icons-->
           <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
         <!-- Core theme CSS (includes Bootstrap)-->
         <link href="css/styles9.css" rel="stylesheet" />
    <style>
        /* Basic styling for the cards */
        
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
             <div class="container px-4 px-lg-5">
               <a class="navbar-brand" href="#!">Movies Now</a>
               <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                   <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                       <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>

                       <li class="nav-item dropdown">
                         <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Movies</a>
                         <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                             <li><a class="dropdown-item" href="#!">All</a></li>
                             <li><hr class="dropdown-divider" /></li>
                             <li><a class="dropdown-item" href="genres.php">Genre</a></li>
                             <li><a class="dropdown-item" href="#!">Year</a></li>
                            
                           </ul>
                       </li>
                       <li class="nav-item dropdown">
                         <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Languages</a>
                         <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                             <li><a class="dropdown-item" href="#!">English</a></li>
                             <li><hr class="dropdown-divider" /></li>
                             <li><a class="dropdown-item" href="#!">Malayalam</a></li>

                           </ul>
                       </li>
                   </ul>
                         </li>
                     </ul>
                     <form class="d-flex">
                         <button class="btn btn-outline-dark" type="submit">
                             <i class="bi-cart-fill me-1"></i>
                             Watchlist
                             <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                         </button>
                     </form>
                     <a class="nav-link active" aria-current="page" href="signin.php">&nbsp  Hello</a>
                 </div>
             </div>
         </nav>
 
 
         <div class="card-container"> 

<?php
session_start();
include("functions.php");
include("connection.php");

    $user_data = check_login($con);
 

// Fetch data from the database
$sql = "SELECT * FROM ride WHERE genre = 'action'";
$result = $con->query($sql);

// Display cards
if ($result->num_rows > 0) {
    $counter = 0;
    while ($row = $result->fetch_assoc()) {
        


        echo '<div class="card">';
        echo '<a href=" '. $row['mpage'] . '" class="card-link">';
        echo '<h2>' . $row['name'] . '</h2>';
        echo '<img src="' . $row['image'] . '" alt="' . $row['lang'] . '">';
        echo '</div>';
        $counter++;
    }
} else {
    echo "No cards found in the database.";
}

// Close connection

?>
</div>
</body>
</html>
