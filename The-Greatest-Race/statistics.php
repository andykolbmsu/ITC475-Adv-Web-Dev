<?php

//  Andy Kolb
//  The Greatest Race
//  statistics.php
//  11/28/2022

$conn = dbConnect();
$lastFive = dbGetLastFive($conn);

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Statistics | The Greatest Race : X-Men Edition</title>
        <link rel="stylesheet" href="css/style.css">
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <script src="js/race.js" defer></script>

        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">

    </head>
    <body>

        <div id="statistics">

            <div id="homeHeadRed" style="">
                <div id="homeHeadRedText" style="">Statistics</div>
            </div>

            <div class="content">

                <div id="backLink"><a class="link" href="index.html">< Back to Race</a></div>

                <h2>Last five races</h2>

                <table id="statsLastFive" class="statsTable">
                    <thead>
                        <tr>
                            <th>Players</th>
                            <th>Winner</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if($lastFive) {
                            while($row = $lastFive->fetch_row()) {
                                echo '<tr>';
                                echo '<td>' . $row[0] . '_versus_' . $row[1] . '</td>';
                                echo '<td>' . $row[2] . '</td>';
                                echo '</tr>';
                            }
                        }    
                    ?>
                    </tbody>
                </table>

                <h2>Search races</h2>

                <div id="searchBoxContainer">
                    <div>
                        <select id="searchPlayer1" placeholder="atest">
                            <option value="">Choose player</option>
                            <option value="captain-britain">Captain Britain</option>
                            <option value="cyclops">Cyclops</option>
                            <option value="magneto">Magneto</option>
                            <option value="mystique">Mystique</option>
                            <option value="polaris">Polaris</option>
                        </select>
                    </div>
                    <div>
                        <select id="searchPlayer2">
                            <option value="">Choose player</option>
                            <option value="captain-britain">Captain Britain</option>
                            <option value="cyclops">Cyclops</option>
                            <option value="magneto">Magneto</option>
                            <option value="mystique">Mystique</option>
                            <option value="polaris">Polaris</option>
                        </select>
                    </div>
                </div>
                <div id="searchErrorMsg"></div>
                <table id="statsSearchPlayers" class="statsTable">
                    <thead>
                        <tr>
                            <th>Competitors</th>
                            <th>Winner</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>

        </div>

    </body>

</html>

<?php

// Return database connection
function dbConnect() {
    $conn = new mysqli("localhost", "root", "", "thegreatestrace");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }
    return $conn;
}

// Return last five race results
function dbGetLastFive($conn='') {
    if($conn) {
        $select = "SELECT player1, player2, winner FROM results ORDER BY datetime DESC LIMIT 5";
        $result = mysqli_query($conn, $select);
        return $result;
    }
    return false;
}

?>