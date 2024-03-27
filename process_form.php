<?php
// Include the database connection file
include 'db_connection.php';

// Retrieve form data
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// Prepare SQL statement to insert data into the database
$sql = "INSERT INTO form_data (name, email, message) VALUES ('$name', '$email', '$message')";

// Execute SQL statement
$result = pg_query($conn, $sql);

if ($result) {
    // Send success response
    echo "success";
} else {
    // Send error response
    echo "error";
}

// Close database connection
pg_close($conn);
?>
