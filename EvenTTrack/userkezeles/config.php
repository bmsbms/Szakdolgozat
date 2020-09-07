<?php
$conn = new mysqli("localhost:3306","root","","eventtrackdb");

if ($conn->connect_error) {
    die("Sikertelen csatlakozás!".$conn->connect_error);
}
//echo "sikeres csatlakozás <br>";
?>