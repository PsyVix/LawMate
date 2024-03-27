    <?php
session_start();

 if (!isset($_SESSION['username'])) {
     header("Location: login.html");
     exit;
}

include 'db_connection.php';

// Fetch customer's current profile information
$email = $_SESSION['username'];
$sql = "SELECT * FROM customer WHERE email = '$email'";
$result = pg_query($conn, $sql);
if (!$result || pg_num_rows($result) == 0) {
    echo "<script>alert('Error: Customer profile not found.'); window.location.href = 'custedit.php';</script>";
    exit;
}
$row = pg_fetch_assoc($result);

// Check if the form is submitted to update profile
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_changes'])) {
    $name = pg_escape_string($conn, $_POST['name']);
    $new_email = pg_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // Plain text password for verification
    $mobile_number = pg_escape_string($conn, $_POST['mobile_number']);
    $address = pg_escape_string($conn, $_POST['address']);

    // Check if any field is empty
    if (empty($name) || empty($new_email) || empty($mobile_number) || empty($address) || empty($password)) {
        echo "<script>alert('Please fill in all fields.'); window.location.href = 'custedit.php'</script>";
    } else {
        // Check if the entered password is correct
        $hashed_password = $row['password'];
        if (password_verify($password, $hashed_password)) {
            // Update customer's profile information
            $update_sql = "UPDATE customer SET name = '$name', email = '$new_email', mobile_number = '$mobile_number', address = '$address' WHERE email = '$email'";
            $update_result = pg_query($conn, $update_sql);
            if ($update_result) {
                echo "<script>alert('Profile updated successfully.'); window.location.href = 'custedit.php';</script>";
                // Update session with new email if it's changed
                $_SESSION['username'] = $new_email;
            } else {
                echo "<script>alert('Error updating profile: " . pg_last_error($conn) . "'); window.location.href = 'custedit.php';</script>";
            }
        } else {
            echo "<script>alert('Incorrect password. Profile not updated.'); window.location.href = 'custedit.php';</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="icon" href="L4.png" type="image/x-icon">
     <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" type="text/css" href="Basic.css">
    <title>Welcome to LawMate – Your Trusted Legal Connection</title>
    <style>
     
        h1
        {
           max-width:99.7%;
           padding:20px;
           color:navy;
           background-color:#ddddff;
           text-align:center;
       }
       
       .cont
       {
          margin:20px;
          padding:20px;
          line-height:35px;
          border:4px solid navy;
          border-radius:10px;
          border-right:2px solid navy;
          border-top:2px solid navy;
          background-color:white;
          max-width:45%;
          margin-left:550px;
         }
         .cont label
         {
           font-size:19px;
           color:navy;
           font-style:italic;
          }
          
          .cont input,textarea
          {
             width:97%;
             height:49px;
             outline:0px;
             border:1px solid grey;
             padding:10px;
             font-size:20px;
             color:#555;
          }
          .cont button
          {
            width:100%;
            height:50px;
            font-size:20px;
            color:navy;
            border:3px solid navy;
            border-left:1px solid navy;
            border-bottom:1px solid navy;
            background-color:transparent;
          }
          .cont button:hover
          {
            border:3px solid navy;
             border-right:1px solid navy;
            border-top:1px solid navy;
          }
    </style>
</head>
<body>
    <!-- Start of Header and Navigation -->
    <center>
        <header>
            <a href="Abtus.html">
                <img src="L4.png" alt="LawMate Logo" style="margin-left:530px;height:139px;width:159px;margin-right:499px;">
            </a>
        </header>
        <nav>
            <a href="home.html">Home</a> 
            <a href="Abtus.html">About Us</a>
            <a href="News.html">News</a>
            <a href="faq.html">FAQ</a>
        </nav>
    </center>
    <h1>Edit Profile</h1>
        <div class="cont">
    <form method="post">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>"><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>"><br><br>

        <label for="mobile_number">Mobile Number:</label><br>
        <input type="tel" id="mobile_number" name="mobile_number" value="<?php echo $row['mobile_number']; ?>"><br><br>

        <label for="address">Address:</label><br>
        <textarea id="address" name="address"><?php echo $row['address']; ?></textarea><br><br>

        <label for="password">Enter Password to Save Changes:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button name="save_changes" >Save Changes</button>
    </form>
</div>
    <?php
// Close database connection
pg_close($conn);
?>
    <!-- End of Main Body -->
    
    <!-- Start of Footer and Bottom Navigation -->
    <nav id="bottom" style="margin-top:30px;">
<div class="bottom"><div>
    <img src="L4.png" style="margin-right:689px;height:125px;width:155px;">
    </div>
    <div class="bot">
        <p><a href="home.html">Home</a></p>
        <p><a href="Abtus.html">About Us</a></p>
         <p><a href="RWU.html">Register with us</a></p>
    </div>
     <div class="bot">
        <p><a href="News.html">News</a></p>
        <p><a href="Disc.html">Disclaimer</a></p>
                <p><a href="Cont.html">Contact Us</a></p>
    </div>
    </div>
</nav>
<footer>
    &copy; 2024 Law Business. All rights reserved.
</footer>
</body>
</html>



