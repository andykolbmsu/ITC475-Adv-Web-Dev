<?php

//  Andy Kolb
//  Mega Travel
//  login.php
//  10/26/2022

checkAdmin();

$msg = '';
if(isset($_POST['username']) && isset($_POST['password'])) {
    if(checkAuth()) {
        login();
    } else {
        $msg = 'Username and password are incorrect.';
    }
}


// Check for username and pass
function checkAuth() {
    $conn = dbConnect();
    $username = $_POST['username'];
    $password = $_POST['password'];
    // $username = 'siteadmin';
    // $password = 'itc475';
    $query = "SELECT * FROM account WHERE username ='$username' && password = '$password'";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result)) { return true; }
    return false;
}

// Return database connection
function dbConnect() {
    $conn = new mysqli("localhost", "root", "", "megatravel");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }
    return $conn;
}

// Sets admin cookie
function login() {
    setcookie('admin', 1, time() + 86400, '/');
    header('Location:./admin.php');
    die;
}

// Check if Admin cookie is set
function checkAdmin() {
    if(isset($_COOKIE['admin']) && $_COOKIE['admin']==1) {
        header('Location:./admin.php');
        die;
    }
    return false;
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Log in | Mega Travel</title>
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

                <div id="loginContainer">
                    
                    <h1>Log in</h1>

                    <form action="login.php" method="POST">

                    <?php
                        if($msg) {
                            echo '<div class="errorMsg">' . $msg . '</div>';
                        }
                    ?>

                    <div>
                        <label for="username">Username</label>
                        <input name="username" type="text" maxlength="20">
                    </div>

                    <div>
                        <label for="password">Password</label>
                        <input name="password" type="password" maxlength="20">
                    </div>

                    <input id="submitBtn" type="submit">

                    </form>

                </div>

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