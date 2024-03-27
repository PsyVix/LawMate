<?php
// Include database connection
include 'db_connection.php';

// Get the lawyer's email from the query parameters
$email = $_GET['email'];

// Fetch the profile photo path from the database
$sql = "SELECT profile_photo FROM lawyer WHERE email = '$email'";
$result = pg_query($conn, $sql);

if ($result && pg_num_rows($result) > 0) {
    $row = pg_fetch_assoc($result);
    $profilePhotoPath = $row['profile_photo'];
    
    // Output the image with the correct content type
    header('Content-Type: image/jpeg'); // Adjust the content type based on your image format
    readfile($profilePhotoPath);
} else {
    // Output a placeholder image or an error image
   echo"NO PROFILE PHOTO"
}

// Close database connection
pg_close($conn);
?>
