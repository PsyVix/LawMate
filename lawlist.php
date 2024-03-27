<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit;
}

// Include database connection
include 'db_connection.php';

// Fetching lawyers data from the database
$sql = "SELECT name, email, phone, bar_number, location, practice_area, profile_photo FROM lawyer";
$result = pg_query($conn, $sql);

// Start output buffering to prevent any output before headers are sent
ob_start();
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
        .contb
             {
               margin:20px;
               width:1800px;
               padding:5px;
               color:navy;
               font-size:20px;
               background-color:#dfdfdf;
          border:5px solid navy;
                          border-top:2px solid navy;
                          border-radius:15px;
                          display:inline-flex;
              }
        .cont
             {
               margin:20px;
               padding:15px;
               color:navy;
               font-size:20px;
               background-color:#fff;
          border:5px solid navy;
                          border-top:2px solid navy;
                          width:50%;
              }
        .cont input
        {
          width:auto;
          height:29px;
          margin:5px;
          padding:10px;
          outline:0px;
          border:1px solid navy;
          border-inline:3px solid navy;
          background-color:#eef;
         }
         input:focus
         {
           border-bottom:3px solid navy;
          }
          textarea::placeholder
          {
              padding:50px 20px 20px 20px;
              color:#333;
              text-align:center;
          }
          textarea
          {
             height:129px;
             max-width:40%;
           }
           
           button
           {
              height:49px;
              width:190px;
              color:darkgreen;
              padding:9px;
              margin:5px;
              background-color:transparent;
              border:2px solid darkgreen;
           }
           
           button:hover
           {
              background-color:darkgreen;
              color:white;
             }
           .comt
           {
                max-height: 500px;
               overflow:scroll;
               margin:20px;
               padding:15px;
               color:navy;
               font-size:20px;
               background-color:#fff;
          border:5px solid navy;
                          border-top:2px solid navy;
                          width:50%;
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
    
    <?php
    if (pg_num_rows($result) > 0) {
        while ($row = pg_fetch_assoc($result)) {
            echo "<div class='contb'><div class='cont'>";
            
            echo "<p><strong>Name:</strong> {$row['name']}</p>";
            echo "<p><strong>Email:</strong> {$row['email']}</p>";
            echo "<p><strong>Phone:</strong> {$row['phone']}</p>";
            echo "<p><strong>Bar Number:</strong> {$row['bar_number']}</p>";
            echo "<p><strong>Location:</strong> {$row['location']}</p>";
            echo "<p><strong>Practice Area:</strong> {$row['practice_area']}</p>";

            // Add comment form for customers
            if ($_SESSION['user_type'] === 'customer') {
                // Add comment form
                echo "<form action='' method='post'>";
                echo "<input type='hidden' name='lawyer_email' value='{$row['email']}'>";
                echo "<textarea name='comment' placeholder='Add Your Comment' required style='width: 100%;'></textarea>";
                echo "<br>";
                echo "<button type='submit'>Add Comment</button>";
                echo "</form></div>";
                
                // Display existing comments for customers
                $lawyer_email = $row['email'];
                $comments_sql = "SELECT * FROM comment WHERE lawyer_email = '$lawyer_email'";
                $comments_result = pg_query($conn, $comments_sql);

                if (pg_num_rows($comments_result) > 0) {
                    echo "<div class='comt'> <h3>Comments:</h3> <ul>";
                    while ($comment_row = pg_fetch_assoc($comments_result)) {
                        echo "<li>{$comment_row['comment_text']} - {$comment_row['customer_email']}</li>";
                    }
                    echo "</ul></div>";
                } else {
                    echo "<p>No comments yet.</p>";
                }
            }

            echo "</div></div>"; // Close cont div
        }
    } else {
        echo "No lawyers found.";
    }

    // Check if the form is submitted to add a comment
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
        $lawyer_email = $_POST['lawyer_email'];
        $customer_email = $_SESSION['username'];
        $comment = $_POST['comment'];

        // Sanitize input data
        $lawyer_email = pg_escape_string($conn, $lawyer_email);
        $customer_email = pg_escape_string($conn, $customer_email);
        $comment = pg_escape_string($conn, $comment);

        // Insert comment into the database
        $sql = "INSERT INTO comment (lawyer_email, customer_email, comment_text) VALUES ('$lawyer_email', '$customer_email', '$comment')";
        $result = pg_query($conn, $sql);
        if ($result) {
            echo "<script>alert('Comment added successfully.'); window.location.href = 'lawlist.php';</script>";
        } else {
            echo "<script>alert('Error adding comment: " . pg_last_error($conn) . "'); window.location.href = 'lawlist.php';</script>";
        }
    }
    // Close database connection
    pg_close($conn);
    ?>
    
    <!-- End of Main Body -->
    
<nav id="bottom" style="margin-top:190px;">
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


