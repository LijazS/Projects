<?php


function check_login($con)
{

if(isset(  $_SESSION['user_id']))
  {
      $id = $_SESSION['user_id'];
      $query = "select * from users where id = $id limit 1";

      $result = mysqli_query($con,$query);
      if($result && mysqli_num_rows($result)>0)
      {

        $user_data = mysqli_fetch_assoc($result);
        return $user_data;
      }
  }
//redirect
    header("Location: signin.php");
    die;

}

function random_num($length)
{
  $text = "";
  if($length<2)
  {
    $length=2;
  }

  $len = rand(4,$length);

  for ($i=0; $i < $len; $i++) {
    // code...
    $text .= rand(0,9);
  }

  return $text;

}

function preprocessWaypoint($waypoint) {
  // Strip HTML tags
  $waypoint = strip_tags($waypoint);
  
  // Remove unnecessary details and extra spaces
  $waypoint = preg_replace('/<div.*?<\/div>/', '', $waypoint);
  $waypoint = preg_replace('/[\n\r\t]/', '', $waypoint);
  $waypoint = preg_replace('/<.*?>/', '', $waypoint);
  $waypoint = preg_replace('/\s+/', ' ', $waypoint);
  $waypoint = trim($waypoint);

  // Extract and format relevant instructions
  $pattern = '/(?:Pass by|Turn (?:left|right)|At the roundabout (?:take the \d+(?:st|nd|rd|th) exit)|(?:Continue|Stay) (?:straight|on)|Destination will be on the (?:left|right)).*?(?:,|$)/';
  preg_match_all($pattern, $waypoint, $matches);
  $waypoints = implode(', ', $matches[0]);

  return $waypoints;
}


// Function to calculate price for each passenger based on distance traveled
function calculatePricePerPassenger($distance, $totalDistance, $numPassengers) {
  // Define pricing parameters
  $baseFare = 50; // Base fare in currency
  $farePerKilometer = 5; // Fare per kilometer in currency
  $minPrice = 100; // Minimum price for short rides
  $maxPrice = 10000; // Maximum price for long rides
  $minDistance = 3; // Minimum distance to trigger the minimum price
  $maxDistance = 200; // Maximum distance to trigger the maximum price

  // Calculate the total price based on distance
  $totalPrice = $baseFare + ($farePerKilometer * $totalDistance);

  // Apply minimum and maximum prices
  if ($totalDistance < $minDistance) {
      $totalPrice = $minPrice;
  } elseif ($totalDistance > $maxDistance) {
      $totalPrice = $maxPrice;
  }


   

  // Calculate the price per unit distance
  $pricePerUnitDistance = $totalPrice / $totalDistance;

  // Calculate price per passenger based on their distance traveled
  $pricePerPassenger = round($distance * $pricePerUnitDistance);

  // Return the calculated price per passenger
  return $pricePerPassenger;
}





// Function to get distance using Google Maps Distance Matrix API
function getDistance($origin, $destination) {
  // Google Maps API endpoint URL
  $apiEndpoint = 'https://maps.googleapis.com/maps/api/distancematrix/json?';
  
  // API parameters
  $params = array(
      'origins' => urlencode($origin),
      'destinations' => urlencode($destination),
      'key' => 'AIzaSyBjE1XvpzE2Ho2wPZh2ctTIIXglKA6mf1Y', // Replace with your actual API key
  );

  // Construct the API request URL
  $apiUrl = $apiEndpoint . http_build_query($params);

  // Make the API request
  $response = file_get_contents($apiUrl);

  // Decode the JSON response
  $responseData = json_decode($response, true);

  // Check if the response contains distance data
  if (isset($responseData['rows'][0]['elements'][0]['distance']['value'])) {
      // Extract the distance in meters
      $distanceInMeters = $responseData['rows'][0]['elements'][0]['distance']['value'];

      // Convert distance from meters to kilometers
      $distanceInKilometers = $distanceInMeters / 1000;

      // Return the distance in kilometers
      return $distanceInKilometers;
  } else {
      // Unable to retrieve distance data, return a default value or handle the error
      return null;
  }
}
