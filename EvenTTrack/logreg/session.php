<?php

session_start();
require 'config.php';
$felhasznalo = $_SESSION['f_felhasznalonev']; //a felhasználó nevet leszedtem a sessionből.

$stmt = $conn->prepare("SELECT * FROM felhasznalok WHERE f_felhasznalonev=?");
$stmt->bind_param("s", $felhasznalo);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_array(MYSQLI_ASSOC);

$f_felhasznalonev = $row['f_felhasznalonev'];
$f_nev = $row['f_nev'];
$f_email = $row['f_email'];
$f_regdatum = $row['f_regdatum'];
$f_jogosultsag = $row['f_jogosultsag'];
$f_kep = $row['f_kep'];
$f_telefonszam=$row['f_telefonszam'];
$jegyzetek_f_id=$row['f_id'];
$bejelentkezve=true;

//$_SESSION['jogosultag'] =$row['f_jogosultsag'];

if (!isset($felhasznalo)) {
    //header("location:logreg.php");
    //$felhasznalo="Nincs senki bejelentkezve";
    $nincskep=true;
    $bejelentkezve=false;
    $f_felhasznalonev="Nincs senki bejelentkezve";
}
?>

