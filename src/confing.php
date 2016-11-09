<?php
function getDbConnetion() {
    $servername = "localhost";
    $username = "root";
    $password = "coderslab";
    $baseName = "twitter";

    $conn = new mysqli($servername, $username, $password, $baseName);
    if ($conn->connect_error) {
        die('Connection ERROR ' . $conn->connect_error);
    }
    $setEncodingSql = "SET CHARSET utf8";
    $conn->query($setEncodingSql);
    return $conn;
}


?>