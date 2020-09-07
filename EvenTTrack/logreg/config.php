<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "eventtrackdb";

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($conn->connect_error) {
    die("Sikertelen csatlakozas az adatbazishoz!" . $conn->connect_error);
}
//echo 'Success';
?>

