<?php

$name = $_POST['firstname'] . ' ' . $_POST['lastname'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$adults = $_POST['travelerAdults'];
$children = $_POST['travelerChildren'];
$destination = getDestination();
$startdate = formatDate($_POST['startDate']);
$enddate = formatDate($_POST['endDate']);
$activities = getActivities();

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
}

// Return comma-separated activity list
function getActivities() {
    $activities = '';
    for($i=1;$i<=5;$i++) {
        if(isset($_POST['activity' . $i]) && $_POST['activity' . $i]) {
            $activities .= $_POST['activity' . $i] . ', ';
        }
    }
    return rtrim($activities, ', ');
}

?>
<!DOCTYPE html>
<html lang="en">
    <!--    Andy Kolb         -->
    <!--    Mega Travel       -->
    <!--    confirm.php       -->
    <!--    10/18/2022        -->
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

                <div id="clientDetails">
                    <p><strong>Client name:</strong> <?php echo $name; ?></p>
                    <p><strong>Client phone number:</strong> <?php echo $phone; ?></p>
                    <p><strong>Client email:</strong> <?php echo $email; ?></p>
                    <p><strong>Number of adults:</strong> <?php echo $adults; ?></p>
                    <p><strong>Number of children:</strong> <?php echo $children; ?></p>
                    <p><strong>Destination:</strong> <?php echo $destination; ?></p>
                    <p><strong>Travel dates:</strong> <?php echo $startdate . ' to ' . $enddate; ?></p>
                    <p><strong>Interested activities:</strong> <?php echo $activities; ?></p>
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
