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
        #im
        {
           height:200px;
           width:200px;
           padding:20px;
         }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 80vh;
        }
        .di {
            color: #333; /* Text color */
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.4), 0px 7px 13px -3px rgba(0, 0, 0, 0.3), inset 0px -3px 0px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            width: 20%; /* Adjust as needed */
            margin: 20px;
            padding: 50px;
            text-align: center;
            height:400px;
            line-height:45px;
            background-color:#eef;
        }
        .di {
            text-decoration: none;
            color: inherit;
            font-size:25px;
        }
        .di:hover
        {
             border:1px solid darkblue;
        background-color:#fff;
         transform: scale(1.1);
    transition: transform 0.3s ease-in-out
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
    
    <!-- Start of Main Body -->
    <div class="container">
        <a href="lawyer_comment.php" class="di">
                <img src="comment.png" id="im">
                <br>
            View Comments
        </a>
        <a href="lawedit.php" class="di">
        <img src="eprofile.png" id="im">
           <br> Edit Your Profile
        </a>
        <a href="Cont.html" class="di">
                <img src="contactus.png" id="im">
            <br>Contact Us
        </a>
    </div>

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

