<?php

//  Andy Kolb
//  The Greatest Race
//  search.php
//  11/30/2022

if(isset($_POST['player1']) && isset($_POST['player2'])) {

    $conn = dbConnect();

    $result = dbSearch($conn, $_POST['player1'],$_POST['player2']);

    if(!$result->num_rows) {
        echo 'No Results';
    } else {
        while($row = $result->fetch_row()) {
            echo '<tr>';
            echo '<td>' . $row[0] . '_versus_' . $row[1] . '</td>';
            echo '<td>' . $row[2] . '</td>';
            echo '</tr>';
        }    
    }

}

// Return database connection
function dbConnect() {
    $conn = new mysqli("localhost", "root", "", "thegreatestrace");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }
    return $conn;
}

// Return database search results
function dbSearch($conn, $player1='', $player2='') {
    if($conn && $player1 && $player2) {
        $query = "SELECT player1, player2, winner FROM results WHERE (player1 = '$player1' && player2 = '$player2') || (player1 = '$player2' && player2 = '$player1') ORDER BY datetime DESC LIMIT 10";
        return mysqli_query($conn, $query);
    }
}

?>