<?php
session_start();

// Check if the user is logged in and is a lawyer
if (!isset($_SESSION['username']) || $_SESSION['user_type'] !== 'lawyer') {
    header("Location: login.html");
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
     <link rel="icon" href="L4.png" type="image/x-icon">
     <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" type="text/css" href="Basic.css">
    <title>Welcome to LawMate – Your Trusted Legal Connection</title>
    <style>
        h1
        {
          width:auto;
           background-color:#ddf;
           padding:20px;
           color:navy;
           text-align:center;
               margin-bottom:50px;
        }
.cont {
    background-color: #eee; /* White background */
    padding: 20px; /* Padding around the content */
    display:inline-block;
}

.card {
    background-color: #fff;
    border: 2px solid navy;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    max-width:300px;
}

.card .from {
    font-size: 18px;
    color: navy;
    margin-bottom: 5px;
}

.card .comm {
    font-size: 16px;
    color: #333;
    margin-top: 5px;
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
    
    
               <h1> Comments For  You</h1>
<?php
    // Fetch and display comments
    if ($result && pg_num_rows($result) > 0) {
        while ($row = pg_fetch_assoc($result)) {
?>

           <div class="cont">
            <div class="card">
                <div class="from"><strong>From:</strong> <?php echo $row['customer_email']; ?><hr></div>
                <div class="comm"><?php echo $row['comment_text']; ?></div>
            </div>
            </div>
<?php
        }
    } else {
        echo "<div class='no-comments'>Sorry! No comments were found</div>";
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

