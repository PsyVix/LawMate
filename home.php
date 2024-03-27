<?php
// Include the database connection file
include 'db_connection.php';

// Retrieve form data
$name = $_POST['name'];
$email = $_POST['mail'];
$message = $_POST['ques'];

// Prepare SQL statement to insert data into the database
$sql = "INSERT INTO news (name, mail, msg) VALUES ('$name', '$email', '$message')";

// Execute SQL statement
$result = pg_query($conn, $sql);

if ($result) {
    // Send success response
    echo "<scrpit>alert('success in newsletter Subscribe'); window.location.href = 'home.html';</script>";
    exit;
} else {
    // Send error response
        echo "<scrpit>alert('Error in newsletter Subscribe'); window.location.href = 'home.html';</script>";
        exit;
}

// Close database connection
pg_close($conn);
?>

