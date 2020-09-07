<?php
require 'config.php';
$msg = ""; // error vagy success, message miatt van.
if (isset($_GET['f_email']) && isset($_GET['f_token'])) { //emailt és a tokent hozom el a linkel
    $f_email = $_GET['f_email'];
    $f_token = $_GET['f_token'];

    $stmt = $conn->prepare("SELECT f_id FROM felhasznalok WHERE f_email=? AND f_token=? AND f_token<>'' AND f_tokenlejarat>NOW()");
    $stmt->bind_param("ss", $f_email, $f_token);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        if (isset($_POST['submit'])) {
            $uj_jelszo = sha1($_POST['uj_jelszo']);
            $uj_jelszoMegerosites = sha1($_POST['uj_jelszoMegerosites']);

            if ($uj_jelszo == $uj_jelszoMegerosites) {
                $stmt_u = $conn->prepare("UPDATE felhasznalok SET f_token='', f_jelszo=? WHERE f_email=? ");
                $stmt_u->bind_param("ss", $uj_jelszo, $f_email);
                $stmt_u->execute();

                $msg = "A jelszó sikeresen megváltozott!<br><a href='logreg.php'>Jelentkezzen be itt</a>";
            } else {
                $msg = "A két jelszó nem egyezett meg!";
            }
        }
    } else {
        header("location:logreg.php");
        exit();
    }
} else {
    header("location:logreg.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Jelszó visszaállítás</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    </head>
    <style>
        body {
                background: url('../hatterkep/hatter.jpg') no-repeat;
                background-size: 100%;
                background-repeat: repeat;
            }
    </style>
    <body>
        <!-- JELSZÓ VISSZAÁLLíTÁS FORM-->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 mt-5">
                    <h3 class="text-center bg-dark text-light p-2 rounded">Állítsa vissza a jelszavát itt!</h3>
                    <h4 class="text-success text-center"><?= $msg; ?></h4> <!-- sikeres felvételt jelzi-->
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="password">írja be az új jelszót!</label>
                            <input type="password" name="uj_jelszo" class="form-control" placeholder="Új Jelszó" required="">
                        </div>
                        <div class="form-group">
                            <label for="password">Új jelszó megerősítése</label>
                            <input type="password" name="uj_jelszoMegerosites" class="form-control" placeholder="Jelszó Megerősítése" required="">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-success btn-block" value="Jelszo Megerősítése">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- JELSZÓ VISSZAÁLLíTÁS FORM VÉGE-->
    </body>   
</html>

