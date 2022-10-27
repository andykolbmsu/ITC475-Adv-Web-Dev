<?php

//  Andy Kolb
//  Mega Travel
//  admin.php
//  10/24/2022

checkAdmin();

$conn = dbConnect();

$query = "SELECT * FROM client";
$result = mysqli_query($conn, $query);

// Return database connection
function dbConnect() {
    $conn = new mysqli("localhost", "root", "", "megatravel");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }
    return $conn;
}

// Return formated date
function formatDate($date='') {
    if($date) {
        return date_format(date_create($date),"F j, Y");
    }
    return '';
}

// Return full destination name
function getDestination($destination='') {
    switch($destination) {
        case 'maldives':
            return 'Maldives, South Asia'; break;
        case 'newzealand':
            return 'New Zealand'; break;
        case 'venice':
            return 'Venice, Italy'; break;
        case 'cancun':
            return 'Cancun, Mexico'; break;
        default:
            return '';
    }
}

// Check if Admin cookie is set
function checkAdmin() {
    if(!isset($_COOKIE['admin']) && $_COOKIE['admin']!=1) {
        header('Location:./login.php');
        die;
    }
    return false;
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin | Mega Travel</title>
        <link rel="stylesheet" href="css/style.css">
        <script src="https://kit.fontawesome.com/488bdcee47.js" crossorigin="anonymous" defer></script>
    </head>
    <body>

        <header>
            <img src="images/mega-travel-logo.png" alt="Mega Travel" class="mega-logo">
        </header>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="contact.html">Contact Agent</a></li>
            </ul>
        </nav>

        <main>

            <div class="container">

                <h1>Administration</h1>

                <h2>Client contacts</h2>

<?php foreach($result as $row) { ?>

<div class="clientDetails clientItem">
                    
    <div class="span2">
        <strong>Client name:</strong> <?php echo $row['name']; ?>
    </div>
    <div>
        <strong>Client phone number:</strong> <?php echo $row['phone']; ?>
    </div>
    <div>
        <strong>Client email:</strong> <?php echo $row['email']; ?>
    </div>
    <div>
        <strong>Number of adults:</strong> <?php echo $row['adults']; ?>
    </div>
    <div>
        <strong>Number of children:</strong> <?php echo $row['children']; ?>
    </div>
    <div class="span2">
        <strong>Destination:</strong> <?php echo getDestination($row['destination']); ?>
    </div>
    <div class="span2">
        <strong>Travel dates:</strong> <?php echo formatDate($row['startdate']) . '&mdash;' . formatDate($row['enddate']); ?>
    </div>
    <div class="span2">
        <strong>Interested activities:</strong> <?php echo $row['activities']; ?>
    </div>

</div>

<?php } ?>

            </div>

        </main>

        <footer>
            <div class="container">
                <div style="margin-bottom: 20px;">Copyright Protected. All rights reserved.</div>
                <div>
                    MEGA TRAVELS<br>
                    mega@travels.com
                </div>
            </div>
        </footer>


    </body>
</html>