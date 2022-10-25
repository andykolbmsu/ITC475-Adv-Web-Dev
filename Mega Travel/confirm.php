<?php

//  Andy Kolb
//  Mega Travel
//  confirm.php
//  10/24/2022

$client = getClient();
$conn = dbConnect();
dbInsert($conn, $client);

// Return client array
function getClient() {
    $client = array(
        'name' => getFullName(),
        'phone' => (isset($_POST['phone'])) ? $_POST['phone'] : '',
        'email' => (isset($_POST['email'])) ? $_POST['email'] : '',
        'adults' => (isset($_POST['travelerAdults'])) ? $_POST['travelerAdults'] : '',
        'children' => (isset($_POST['travelerChildren'])) ? $_POST['travelerChildren'] : '',
        'destination' => (isset($_POST['destinations'])) ? $_POST['destinations'] : '',
        'startdate' => (isset($_POST['startDate'])) ? $_POST['startDate'] : '',
        'enddate' => (isset($_POST['endDate'])) ? $_POST['endDate'] : '',
        'activities' => getActivities()
    );
    return $client;
}

// Return full name
function getFullName() {
    if (isset($_POST['firstname']) && isset($_POST['lastname'])) {
        return $_POST['firstname'] . ' ' . $_POST['lastname'];
    }
    return '';
}

// Return full destination name
function getDestination() {
    switch($_POST['destinations']) {
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

// Return formated date
function formatDate($date='') {
    if($date) {
        return date_format(date_create($date),"F j, Y");
    }
    return '';
}

// Return comma-separated activity list
function getActivities() {
    $activities = '';
    for($i=1;$i<=5;$i++) {
        if(isset($_POST['activity' . $i]) && $_POST['activity' . $i]) {
            $activities .= $_POST['activity' . $i] . ', ';
        }
    }
    if($activities) {
        return rtrim($activities, ', ');
    }
    return '';
}

// Return database connection
function dbConnect() {
    $conn = new mysqli("localhost", "root", "", "megatravel");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }
    return $conn;
}

// Insert into database
function dbInsert($conn='',$client=array()) {
    if($conn && count($client)) {
        $insert = sprintf(
            'INSERT INTO client (%s) VALUES ("%s")',
            implode(',', array_keys($client)),
            implode('","', array_values($client))
        );
        mysqli_query($conn, $insert);
    }
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Mega Travel</title>
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

                <h1>Thank you!</h1>
            
                <p>Thank you for submitting your travel agent contact request! Here is the information you submitted:</p>

                <div class="clientDetails">
                    <p><strong>Client name:</strong> <?php echo $client['name']; ?></p>
                    <p><strong>Client phone number:</strong> <?php echo $client['phone']; ?></p>
                    <p><strong>Client email:</strong> <?php echo $client['email']; ?></p>
                    <p><strong>Number of adults:</strong> <?php echo $client['adults']; ?></p>
                    <p><strong>Number of children:</strong> <?php echo $client['children']; ?></p>
                    <p><strong>Destination:</strong> <?php echo getDestination($client['destination']); ?></p>
                    <p><strong>Travel dates:</strong> <?php echo formatDate($client['startdate']) . ' to ' . formatDate($client['enddate']); ?></p>
                    <p><strong>Interested activities:</strong> <?php echo $client['activities']; ?></p>
                </div>

                <p>An agent will be in touch with you soon!</p>

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