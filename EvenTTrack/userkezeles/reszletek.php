<?php
    include 'action.php';
 ?>
<!DOCTYPE html>
<hmtl lang="en">
<head>
	<title>Részletek</title>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="../ajax/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="../bootstrap/js/bootstrap.min.js"></script>

<style>
    body {
                background: url('../hatterkep/hatter.jpg') no-repeat;
                background-size: 100%;
            }
            div{
              opacity: 0.95;
            }
</style>
</head>

<body>

<!-- START FELHAZSNÁLÓ ADATAI FORM (ADMIN) -->   
<div class="container">
    <div class="row justify-content-center">
        <div class="cold-md-6 mt-3 bg-info p-4 rounded">
            <h2 class="bg-light p-2 rounded text-center text-dark">ID : <?= $vf_id; ?></h2>
            <div class="text-center">
                <img src="<?= $vf_kep; ?>" width="300" class="img-thumbnail">
            </div>
            <h4 class="text-light">Név : <?= $vf_nev ?> </h4>
            <h4 class="text-light">Email : <?= $vf_email ?> </h4>
            <h4 class="text-light">Telefonszám : <?= $vf_telefonszam ?> </h4>
            <h4 class="text-light">Jogosultság : <?= $vf_jogosultsag ?> </h4>
            <div class="text-center">
                <a class="badge badge-dark p-3 " href="http://localhost/EvenTTrack/userkezeles/felhasznaloKezeles.php">Vissza a felhasználókezeléshez</a>
            </div>
        </div>
    </div>
</div>
    <!-- END FELHAZSNÁLÓ ADATAI FORM (ADMIN) -->   
</body>
</hmtl>
