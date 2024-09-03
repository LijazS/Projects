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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Profile</title>
    <!-- Add your CSS styles here -->
    <style>
        
        /* Add your CSS styles for the driver profile page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 2rem;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 1.5rem;
            color: #333;
        }

        .profile-info {
            margin-bottom: 2rem;
        }

        .profile-info h2 {
            margin-bottom: 0.5rem;
        }

        .review-section {
    margin-top: 2rem;
    background-color: #f9f9f9;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

        .review {
            margin-bottom: 1rem;
            padding: 1rem;
            background-color: #f9f9f9;
            border-radius: 5px;
        }

        .review-box {
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 1rem;
    margin-bottom: 1rem;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}


        .review .user {
            font-weight: bold;
        }

        .review .rating {
            color: #28a745;
            font-weight: bold;
        }

        /* Style the form for writing reviews */
        .review-form {
            margin-top: 2rem;
        }

        .review-form label {
            display: block;
            margin-bottom: 0.5rem;
        }

        .review-form input[type="number"] {
            width: 100px;
        }

        .review-form textarea {
            width: 100%;
            height: 100px;
            margin-bottom: 1rem;
        }

        .review-form button {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            cursor: pointer;
        }

        .review-form button:hover {
            background-color: #218838;
        }

        .user-rating {
    margin-bottom: 1rem;
}

.user-rating p {
    margin: 0;
}

.comment {
    margin: 0;
}

.navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #fff;
        padding: 1rem 2rem;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .navbar-brand {
        font-size: 1.5rem;
        color: #333;
        text-decoration: none;
    }

    .nav-items {
        display: flex;
        align-items: center;
    }

    .nav-item {
        margin-right: 2rem;
        font-size: 1.2rem;
        color: #333;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .nav-item:hover {
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

    @media (max-width: 768px) {
        .navbar {
            flex-direction: column;
            padding: 1rem;
        }

        .nav-items {
            margin-top: 1rem;
            justify-content: flex-start; /* Updated to align links to the left */
        }

        .nav-item {
            margin-right: 0;
            margin-bottom: 1rem;
        }

    </style>
</head>
<body>

<div class="navbar">
    <a class="navbar-brand" href="#">RIDE SHARE</a>
    <div class="nav-items">
        <a class="nav-item" href="index.php">Home</a>
        <a class="nav-item" href="accepted_trip.php">My trip</a>
        <div class="user-info">
            <span class="user-name">Hello, <?php echo $user_data['username']; ?></span>
            <i class="fas fa-user user-icon"></i>
        </div>
    </div>
</div>

    <div class="review-section">
        
        <div class="review-section">
            <h2>Driver Profile</h2>
            <p><strong>Name:</strong> <?php echo $driver_name; ?></p>
            <p><strong>Email:</strong> <?php echo $driver_email; ?></p>
            <p><strong>Gender:</strong> <?php echo $driver_gender; ?></p>
            <p><strong>Phone Number:</strong> <?php echo $driver_phone; ?></p>
            <!-- Add more driver details here -->
        </div>
        
        <div class="review-section">
    <h2>Reviews and Ratings</h2>
    <?php if ($result_reviews->num_rows > 0) : ?>
        <?php while ($row_review = $result_reviews->fetch_assoc()) : ?>
            <div class="review-box">
                <div class="user-rating">
                    <p class="user">User: <?php echo $row_review['reviewer_id']; ?></p>
                    <p class="rating">Rating: <?php echo $row_review['rating']; ?>/5</p>
                </div>
                <div class="comment-box">
                    <p class="comment"><?php echo $row_review['review_text']; ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else : ?>
        <p>No reviews yet.</p>
    <?php endif; ?>
</div>


            <!-- Review Form -->
            <div class="review-form">
                <h2>Write a Review</h2>
                <form action="submit_review.php" method="post">
                    <label for="rating">Rating (1-5):</label>
                    <input type="number" id="rating" name="rating" min="1" max="5" required>

                    <label for="comment">Comment:</label>
                    <textarea id="comment" name="review_text" required></textarea>
                    
                    <input type="hidden" name="driver_id" value="<?php echo $driver_id; ?>">
                    <button type="submit">Submit Review</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
