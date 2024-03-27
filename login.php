<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
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

// Check if the form is submitted
    $username = $_POST['username'];
    $password = $_POST['password'];
    $choice = $_POST['choice'];

    // Check if all fields are filled
    if (empty($username) || empty($password) || empty($choice)) {
        echo "<script>alert('Error: Please fill all fields.'); window.location.href = 'login.html';</script>";
        exit;
    }

    // Determine the table based on user choice
    $table = ($choice == 'lawyer') ? 'lawyer' : 'customer';

    // Prepare SQL statement using parameterized query to prevent SQL injection
    $sql = "SELECT * FROM $table WHERE email = $1";
    $result = pg_query_params($conn, $sql, array($username));

    // Check if user exists
    if ($result && pg_num_rows($result) > 0) {
        $row = pg_fetch_assoc($result);
        $hashed_password = $row['password'];
        
        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, set session variables
            $_SESSION['username'] = $username;
            $_SESSION['user_type'] = $choice;

            // Redirect to appropriate landing page
            if ($_SESSION['user_type'] === 'lawyer') {
                header("Location:lawyer_profile.php");
                exit;
            } else {
                header("Location:customer_profile.php");
                exit;
            }
        } else {
            // Incorrect password or username
            echo "<script>alert('Error: Incorrect Password Or UserName.'); window.location.href = 'login.html';</script>";
            exit;
        }
    } else {
        // User not found
        echo "<script>alert('Error: User Not Found'); window.location.href = 'login.html';</script>";
        exit;
    }

// Close database connection
pg_close($conn);
?>

