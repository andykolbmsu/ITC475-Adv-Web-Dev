<?php

//  Andy Kolb
//  The Greatest Race
//  submit.php
//  11/28/2022

if(isset($_POST['player1']) && isset($_POST['player2']) && isset($_POST['winner'])) {

    $conn = dbConnect();
    
    $arr = array(
        'player1' => $_POST['player1'],
        'player2' => $_POST['player2'],
        'winner' => $_POST['winner'],
    );

    dbInsert($conn, $arr);

}

// Return database connection
function dbConnect() {
    $conn = new mysqli("localhost", "root", "", "thegreatestrace");
    if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }
    return $conn;
}

// Insert into database
function dbInsert($conn='',$arr=array()) {
    if($conn && count($arr)) {
        $insert = sprintf(
            'INSERT INTO results (%s) VALUES ("%s")',
            implode(',', array_keys($arr)),
            implode('","', array_values($arr))
        );
        mysqli_query($conn, $insert);
    }
}

?>