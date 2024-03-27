<?php
// PostgreSQL database connection parameters
$host = "localhost";
$port = "5432";
$dbname = "lawmate";
$user = "postgres";
$password = "postgres";

// Connect to PostgreSQL database
$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

// Check connection
if (!$conn) {
    echo "Failed to connect to PostgreSQL database.";
    exit;
}
?>
