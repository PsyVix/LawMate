<?php
session_start();

// Check if the user is logged in and is a lawyer
f (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'lawyer') {
  header("Location: login.php");
  exit;
}

$host = 'localhost';
$dbname = 'lawmate';
$user = 'postgres';
$password = 'postgres';

// Establishing database connection
$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");
if (!$conn) {
    die("Database connection failed: " . pg_last_error());
}

// Fetch comments for the logged-in lawyer
$lawyer_email = $_SESSION['username'];
$sql = "SELECT * FROM comment WHERE lawyer_email = '$lawyer_email'";
$result = pg_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to LawMate – Your Trusted Legal Connection</title>
        <link rel="icon" href="L4.png" type="image/x-icon">
     <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" type="text/css" href="Basic.css">
    <style>
    .cont
    { 
       max-width:90%;
       background-color:white;
       color:navy;
       border:3px solid navy;
       border-inline:1px solid navy;
       border-radius:10px;
       margin:10px;
       padding:15px;
    }
    .from
    {
       text-decoration:underline;
       font-style:italic;
       color:#555;
       font-size:15px;
    }
    .comt
    {
        line-height:35px;
        font-size:18px;
        color:navy;
    }
       
    </style>
</head>
<body>
    <!-- Start of Header and Navigation -->
    <center>                                                      
        <header>
            <a href="Abtus.html"><img src="L4.png" alt="LawMate Logo"  style="margin-left:530px;height:139px;width:159px;margin-right:499px;"></a>
        </header>
        <nav>
            <a href="home.html">Home</a> 
            <a href="Abtus.html">About Us</a>
            <a href="News.html">News</a>
            <a href="faq.html">FAQ</a>
        </nav>
    </center>   
    

    <h1>Comments for Lawyer</h1>

    <?php
    if ($result && pg_num_rows($result) > 0) {
        while ($row = pg_fetch_assoc($result)) {
            echo "<div class='cont'>";
            echo "<p class='comt'><strong>Comment:</strong> {$row['comment_text']}</p>";
            echo "<p class='from'><strong>From:</strong> {$row['customer_email']}</p>";
            echo "</div>";
        }
    } else {
        echo "No comments found.";
    }
    ?>

     
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


<?php
// Close database connection
pg_close($conn);
?>

