<?php
// PostgreSQL connection parameters
include 'db_connection.php'; // Assuming this file contains the connection parameters

// Function to sanitize input data
function sanitize($data) {
    global $conn; // Access the database connection within the function
    $data = trim($data);
    $data = pg_escape_string($conn, $data); // Use pg_escape_string() with the connection parameter
    return $data;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check which form was submitted
    if (isset($_POST['di_submit'])) { // Lawyer Registration Form
        // Sanitize input data
        $name = sanitize($_POST['di_name']);
        $email = sanitize($_POST['di_email']);
        $password = password_hash($_POST['di_password'], PASSWORD_DEFAULT);
        $phone = sanitize($_POST['di_phone']);
        $bar_number = sanitize($_POST['di_bar-number']);
        $location = sanitize($_POST['di_location']);
        $practice_area = sanitize($_POST['di_parea']);

        // Upload profile photo
        $targetDir = "/var/www/html/project/uploads";
        $profilePhoto = $targetDir . basename($_FILES["di_profile_photo"]["name"]);
        move_uploaded_file($_FILES["di_profile_photo"]["tmp_name"], $profilePhoto);

        // Check if email or bar number already exists
        $checkQuery = "SELECT * FROM lawyer WHERE email = '$email' OR bar_number = '$bar_number'";
        $checkResult = pg_query($conn, $checkQuery);
        if (pg_num_rows($checkResult) > 0) {
            echo "<script>alert('Email or bar number already exists!');</script>";
            exit; // Stop script execution
        }

        // Proceed with registration
        $sql = "INSERT INTO lawyer (name, email, password, phone, bar_number, location, practice_area, profile_photo) VALUES ('$name', '$email', '$password', '$phone', '$bar_number', '$location', '$practice_area', '$profilePhoto')";
        $result = pg_query($conn, $sql);
        if ($result) {
            echo "Lawyer registered successfully!";
            // Redirect to login page
            header("Location: login.html");
            exit; // Ensure that script execution stops after redirection
        } else {
            echo "Error: " . pg_last_error($conn);
        }
    } elseif (isset($_POST['dj_submit'])) { // Customer Registration Form
        // Sanitize input data
        $name = sanitize($_POST['dj_name']);
        $email = sanitize($_POST['dj_email']);
        $password = password_hash($_POST['dj_password'], PASSWORD_DEFAULT);
        $mobile_number = sanitize($_POST['dj_mobile-number']);
        $address = sanitize($_POST['dj_address']);

        // Upload profile photo
        $targetDir = "/var/www/html/project/uploads/";
        $profilePhoto = $targetDir . basename($_FILES["dj_profile_photo"]["name"]);
        move_uploaded_file($_FILES["dj_profile_photo"]["tmp_name"], $profilePhoto);

        // Check if email or mobile number already exists
        $checkQuery = "SELECT * FROM customer WHERE email = '$email' OR mobile_number = '$mobile_number'";
        $checkResult = pg_query($conn, $checkQuery);
        if (pg_num_rows($checkResult) > 0) {
            echo "<script>alert('Email or mobile number already exists!');</script>";
            exit; // Stop script execution
        }

        // Proceed with registration
        $sql = "INSERT INTO customer (name, email, password, mobile_number, address, profile_photo) VALUES ('$name', '$email', '$password', '$mobile_number', '$address', '$profilePhoto')";
        $result = pg_query($conn, $sql);
        if ($result) {
            echo "Customer registered successfully!";
            // Redirect to login page
            header("Location: login.html");
            exit; // Ensure that script execution stops after redirection
        } else {
            echo "Error: " . pg_last_error($conn);
        }
    } else {
        echo "Invalid form submission!";
    }
}

// Close database connection
pg_close($conn);
?>

