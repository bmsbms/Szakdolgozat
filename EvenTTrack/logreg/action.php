<?php
error_reporting(0);
require 'config.php';
require 'session.php';
//regisztrálás az alkalmazásba
if (isset($_POST['action']) && $_POST['action'] == 'regisztracio') {
    $f_nev = check_input($_POST['f_nev']);
    $f_felhasznalonev = check_input($_POST['f_felhasznalonev']);
    $f_email = check_input($_POST['f_email']);
    $f_jelszo = check_input($_POST['f_jelszo']);
    $f_jelszoMegerosites = check_input($_POST['f_jelszoMegerosites']);
    $f_jelszo = sha1($f_jelszo);
    $f_jelszoMegerosites = sha1($f_jelszoMegerosites);
    $f_regdatum = date('Y-m-d');
    $f_kep = "../tesztkepek/EvenTTrack_alapkep.jpg";
    $f_jogosultsag ="user";

    if ($f_jelszo != $f_jelszoMegerosites) {
        echo 'A két jelszó nem egyezett meg!';
        exit();
    } else {
        $sql = $conn->prepare("SELECT f_felhasznalonev,f_email FROM felhasznalok WHERE f_felhasznalonev=? OR f_email=?");
        $sql->bind_param("ss", $f_felhasznalonev, $f_email);
        $sql->execute();
        $result = $sql->get_result();
        $row = $result->fetch_array(MYSQLI_ASSOC); //azt fogja megnézni hogy van e már ott username vagy email
        if ($row['f_felhasznalonev'] == $f_felhasznalonev) { //ha a username ami jön az adatbázisból, és a username amit beirunk megegyezik
            echo 'A felhasználónév helytelen, vagy már van ilyen felhasználó!'; //akkor kiiratjuk hogy már van megyegyező
        } elseif ($row['f_email'] == $f_email) {
            echo 'Az e-mail cím már regisztrálva van, kérem próbáljon meg egy másikat!';
        } else {
            $stmt = $conn->prepare("INSERT INTO felhasznalok (f_nev,f_felhasznalonev,f_email,f_jelszo,f_regdatum,f_kep,f_jogosultsag) VALUES (?,?,?,?,?,?,?)");
            $stmt->bind_param("sssssss", $f_nev, $f_felhasznalonev, $f_email, $f_jelszo, $f_regdatum,$f_kep,$f_jogosultsag);
            if ($stmt->execute()) {
                echo 'Sikeresen regisztrált. Jelentkezzen be!';
            } else {
                echo 'Valami nem sikerült, kérem próbálja újra!';
            }
        }
    }
}

//bejelentkezés az alkalmazásba
if (isset($_POST['action']) && $_POST['action'] == 'bejelentkezes') {
    session_start();

    $f_felhasznalonev = $_POST['f_felhasznalonev'];
    $f_jelszo = sha1($_POST['f_jelszo']);

    $stmt_l = $conn->prepare("SELECT * FROM felhasznalok WHERE f_felhasznalonev=? AND f_jelszo=?");
    $stmt_l->bind_param("ss", $f_felhasznalonev, $f_jelszo);
    $stmt_l->execute();
    $user = $stmt_l->fetch();

    if ($user != null) {
        $_SESSION['f_felhasznalonev'] = $f_felhasznalonev;
        echo 'ok';
        //header("location:logreg.php");

        if (!empty($_POST['jelszo_emlekezteto'])) {
            setcookie("f_felhasznalonev", $_POST['f_felhasznalonev'], time() + (10 * 365 * 24 * 60 * 60));
            setcookie("f_jelszo", $_POST['f_jelszo'], time() + (10 * 365 * 24 * 60 * 60));
        } else {
            if (isset($_COOKIE['f_felhasznalonev'])) {
                setcookie("f_felhasznalonev", "");
            }
            if (isset($_COOKIE['f_jelszo'])) {
                setcookie("f_jelszo", "");
            }
        }
    } else {
        echo 'Bejelentkezés sikertelen, kérem ellenőrizze a felhasználó nevet vagy a jelszót.';
    }
    
}

//elfelejtett jelszó + mail küldés
if (isset($_POST['action']) && $_POST['action'] == 'elfelejtett_jelszo') {
    $elfelejtett_email = $_POST['elfelejtett_email'];

    $stmt_p = $conn->prepare("SELECT f_id FROM felhasznalok WHERE f_email=?");
    $stmt_p->bind_param("s", $elfelejtett_email);
    $stmt_p->execute();
    $res = $stmt_p->get_result();

    if ($res->num_rows > 0) {
        $f_token = "qwertzuiopasdfghjklzxcvbnm1234567890"; //10 karakteres random token
        $f_token = str_shuffle($f_token);
        $f_token = substr($f_token, 0, 10);

        $stmt_i = $conn->prepare("UPDATE felhasznalok SET f_token=?, f_tokenLejarat=DATE_ADD(NOW(),INTERVAL 5 MINUTE) WHERE f_email=?");
        $stmt_i->bind_param("ss", $f_token, $elfelejtett_email);
        $stmt_i->execute();

        require 'phpmailer/PHPMailerAutoload.php';
        $mail = new PHPMailer;
                $mail->CharSet = 'UTF-8';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';

        $mail->Username = 'bmsbms.szakdoga@gmail.com';
        $mail->Password = 'Szakdoga01';

        $mail->addAddress($elfelejtett_email); //ez lesz azért felelős hogy ha beirunk valamit az input mezőbe az elküldje.
        $mail->setFrom('bmsbms.szakdoga@gmail.com', 'EvenTTrack');
        $mail->Subject = 'Jelszó visszaállítás';
        $mail->isHTML(true);

        $mail->Body = "<h3>Kattintson a linkre hogy visszaállítsa a jelszavát.</h3><br><a href='http://localhost/EvenTTrack/logreg/jelszoVisszaallitas.php?f_email=$elfelejtett_email&f_token=$f_token'>http://localhost/EvenTTrack/logreg/jelszoVisszaallitas.php?f_email=$elfelejtett_email&f_token=$f_token</a><br><h3>Üdvözlettel<br>EvenTTrack</h3>";

        if ($mail->send()) {
            echo 'Elküldtük önnek a visszaállítási e-mailt, kérjük ellenőrizze.';
        } else {
            echo 'Valami hiba történt , kérem próbálja emg késöbb!';
        }
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'adataimModositasa') {
    
    

    $bejelentkezettUserID=$row['f_id'];

    $f_adatmodositasNev=$_POST['f_adatmodositasNev'];
    $f_adatmodositasFelhasznalonev=$_POST['f_adatmodositasFelhasznalonev'];
    $f_adatmodositasEmail=$_POST['f_adatmodositasEmail'];
    $f_adatmodositasTelefonszam=$_POST['f_adatmodositasTelefonszam'];
//    $f_regikep=$_POST['f_regikep'];

    
/*    if (isset($_FILES['f_kep']['name']) && $_FILES['f_kep']['name'] !="" ) {
        
        $f_ujkep="feltoltesek/".$_FILES['f_kep']['name'];
        unlink($f_regikep);
        move_uploaded_file($_FILES['f_kep']['tmp_name'], $f_ujkep);
    }
    else{
        $f_ujkep=$f_regikep;
    }
    */
    $stmt_adataimModositasa = $conn->prepare("UPDATE felhasznalok SET f_nev=?, f_felhasznalonev=?, f_email=?, f_telefonszam=? WHERE f_id=?");
    $stmt_adataimModositasa->bind_param("ssssi",$f_adatmodositasNev, $f_adatmodositasFelhasznalonev, $f_adatmodositasEmail, $f_adatmodositasTelefonszam, $bejelentkezettUserID);
    $stmt_adataimModositasa->execute();
    if ($stmt_adataimModositasa->execute()) {
                echo 'Sikeresenen megváltoztatta adatait, 
                <b class="text-danger">ha a felhasználónevét változtatta meg, kérem Jelentkezzen be újra!</b>';
            } else {
                echo 'Valami nem sikerült, kérem próbálja újra!';
            }
    
    }
// adatok ellenőrzése a beviteli mezők sprán
function check_input($data) {
    $data = trim($data); //minden spacet tabot stb, whitespacet removeolt
    $data = stripslashes($data); //minden slasht removeol
    $data = htmlspecialchars($data); // html speciális karaktereket előre meghatározott karakterek
    return $data; //ezek jók az sql injenction ellen.
}

?>
