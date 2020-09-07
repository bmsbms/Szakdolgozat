<?php
error_reporting(0);
require 'session.php';
if ($f_felhasznalonev=="") {
 // $f_felhasznalonev = "Nincs bejelentkezve";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bejelentkezés és regisztráció</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <script src="http://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>
  <!--<script src="../ajax/jquery.min.js"></script>-->

  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>


  <link rel="stylesheet" href="" >
        <style type="text/css">
            #figyelmeztetes,#regisztracio-box,#elfelejtett-jelszo-box,#loader{
                display: none;
            }
            body {
                background: url('../hatterkep/hatter.jpg') ;
                background-size: 100%;
            }
        </style>

</head>

<!-- NAVBAR START -->
       <body class="bg-dark">

  <div class="jumbotron text-center">
                      <h1>Bejelentkezés és Regisztráció</h1>

                      <nav class="navbar navbar-expand-lg navbar-light bg-light">
                          <a class="navbar-brand" href="index.php">EvenTTrack</a>
                          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                              <span class="navbar-toggler-icon"></span>
                          </button>

                          <div class="collapse navbar-collapse" id="navbarSupportedContent">
                              <ul class="navbar-nav mr-auto">
                                  <li class="nav-item active">
                                      <a class="nav-link" href="../index.php">Főoldal<span class="sr-only"></span></a>
                                  </li>      
                                  <?php if ($f_jogosultsag == "admin") { ?>      
                                  <a class="nav-link text-danger" href="../userkezeles/felhasznaloKezeles.php">Felhasználók kezelése<span class="sr-only"></span></a>
                                <?php  }?>
                                  <a class="nav-link" href="../naptar/naptar.php">Naptár<span class="sr-only"></span></a>
                              </ul>
                              <a class="nav navbar-nav navbar-right navbar-brand" href="profile.php">  <?php echo "<b>Felhasználónév: </b>", $f_felhasznalonev; ?> </a>
                              <ul class="nav navbar-nav navbar-right">
                              </ul>
                          </div>
                      </nav>
                  </div>
       
</div>
<!-- NAVBAR END -->

<?php
//session_start();
if (isset($_SESSION['f_felhasznalonev'])) {
    header("location:profile.php");
}
?>

        <!-- FELHASZNÁLÓI ÜZENETVISSZAJELZÉS START -->
        <div class="container mt-4">
            <div class="row">
                <div class="col-lg-4 offset-lg-4" id="figyelmeztetes">
                    <div class="alert alert-success">
                        <strong id="eredmeny"></strong>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <img src="preloader.gif" width="150px" height="100xp" class="m-2" id="loader">
            </div>
            <!-- FELHASZNÁLÓI ÜZENETVISSZAJELZÉS END -->

            <!--START BEJELENTKEZES FORM-->
            <div class="row">
                <div class="col-lg-4 offset-lg-4 bg-light rounded" id="bejelentkezes-box">
                    <h2 class="text-center mt-2">Bejelentkezés</h2>
                    <form action="" method="post" role="form" class="p-2" id="bejelentkezes-form">
                        <div class="form-group">
                            <input type="text" name="f_felhasznalonev" class="form-control" placeholder="Felhasználónév" required minLength="2" value="<?php
                            if (isset($_COOKIE['f_felhasznalonev'])) {
                                echo $_COOKIE['f_felhasznalonev'];
                            }
                            ?>">
                        </div>
                        <div class="form-group">
                            <input type="password" name="f_jelszo" class="form-control" placeholder="jelszó" required minLength="6" value="<?php
                            if (isset($_COOKIE['f_jelszo'])) {
                                echo $_COOKIE['f_jelszo'];
                            }
                            ?>">
                            <a href="index.php"></a>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="jelszo_emlekezteto" class="custom-control-input" id="customCheck" <?php if (isset($_COOKIE['f_felhasznalonev'])) { ?> checked <?php } ?>> <!-- jelszo emlekezteto-->
                                <label for="customCheck" class="custom-control-label">Emlékezz rám</label>
                                <a href="#" id="elfelejtett-jelszo-gomb" class="float-right">Elfelejtette jelszavát?</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="bejelentkezes" id="bejelentkezes" value="Bejelentkezes" class="btn btn-primary btn-block">
                        </div>
                        <div class="form-group">
                            <p class="text-center">Új felhasználó? <a href="#" id="regisztracio-gomb">Regisztráljon itt</a></p>
                        </div>
                    </form>               
                </div>
            </div>
            <!-- END BEJELENTKEZES FORM-->

            <!--START REGISZTRACIO FORM-->
            <div class="row">
                <div class="col-lg-4 offset-lg-4 bg-light rounded" id="regisztracio-box">
                    <h2 class="text-center mt-2">Regisztráció</h2>
                    <form action="" method="post" role="form" class="p-2" id="regisztracio-form">
                        <div class="form-group">
                            <input type="text" name="f_nev" class="form-control" placeholder="Teljes név" required minLength="3">
                        </div>
                        <div class="form-group">
                            <input type="text" name="f_felhasznalonev" class="form-control" placeholder="Felhasználó név" required minLength="4">
                        </div>
                        <div class="form-group">
                            <input type="email" name="f_email" class="form-control" placeholder="E-Mail" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="f_jelszo" id="f_jelszo" class="form-control" placeholder="Jelszó" required required minLength="6">
                        </div>
                        <div class="form-group">
                            <input type="password" name="f_jelszoMegerosites" id="f_jelszoMegerosites" class="form-control" placeholder="Jelszó megerősítése" required required minLength="6">
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="jelszo_emlekezteto" class="custom-control-input" id="customCheck2"> <!-- rem = remember me-->
                                <label for="customCheck2" class="custom-control-label">Elfogadom a <a href="#">felhasználási feltételeket.</a></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="regisztracio" id="regisztracio" value="Regisztracio" class="btn btn-primary btn-block">
                        </div>
                        <div class="form-group">
                            <p class="text-center">Már regisztrált? <a href="#" id="bejelentkezes-gomb">Jelentkezzen be itt.</a></p>
                        </div>
                    </form>
                </div>
            </div>
            <!--END REGISZTRACIO FORM-->

            <!--START ELFELEJTETT JELSZO FORM-->
            <div class="row">
                <div class="col-lg-4 offset-lg-4 bg-light rounded" id="elfelejtett-jelszo-box">
                    <h2 class="text-center mt-2">Jelszó visszaállítása</h2>
                    <form action="" method="post" role="form" class="p-2" id="elfelejtett-jelszo-form">
                        <div class="form-group">
                            <small class="text-muted">
                                Hogy visszaállítsa jelszavát, írja be az e-mail címét és küldünk önnek egy levelet, amelyben küljük a további utasitásokat.
                            </small>
                        </div>
                        <div class="form-group">
                            <input type="email" name="elfelejtett_email" class="form-control" placeholder="E-Mail" required>
                        </div>                   
                        <input type="submit" name="elfelejtett_jelszo" id="elfelejtett_jelszo" value="Visszaállítás" class="btn btn-primary btn-block">
                        <div class="form-group text-center">
                            <a href="#" id="vissza-gomb">Vissza</a>
                        </div>
                    </form>
                </div>
            </div>
            <!--END ELFELEJTETT JELSZO FORM-->
        </div>


        
        <script type="text/javascript">

            $(document).ready(function () {
                $("#regisztracio-gomb").click(function () {
                    $("#regisztracio-box").show();
                    $("#bejelentkezes-box").hide();
                });
                $("#bejelentkezes-gomb").click(function () {
                    $("#regisztracio-box").hide();
                    $("#bejelentkezes-box").show();
                });
                $("#elfelejtett-jelszo-gomb").click(function () {
                    $("#bejelentkezes-box").hide();
                    $("#elfelejtett-jelszo-box").show();
                });

                $("#vissza-gomb").click(function () {
                    $("#elfelejtett-jelszo-box").hide();
                    $("#bejelentkezes-box").show();
                });

            //    $("#bejelentkezes-form").validate(); //a form tag ig-ja
                $("#regisztracio-form").validate({
                    lang: 'hu',
                    rules: {//szabályok
                        f_jelszoMegerosites: {
                            equalTo: "#f_jelszo" // ugye ha a jelszoUjra megegyezik a sima jelszoval
                        }
                    } 
                });
                $("#elfelejtett-jelszo-form").validate();

                //form megjeleítése az oldal frissítése nélkül
                $("#regisztracio").click(function (e) { //itt vizsgáljuk hogy rákattintottunk a regisztráció gombra
                    if (document.getElementById('regisztracio-form').checkValidity()) {
                        e.preventDefault(); //tehát hogyha a regisztráció gombra kattintunk akkor az adatokat beküldi az adatbázisba, és nem frissíti az egész oldalt.
                        $("#loader").show();
                        $.ajax({
                            url: 'action.php', //ahova küldjük a form adatokat
                            method: 'post',
                            data: $("#regisztracio-form").serialize() + '&action=regisztracio', //ez a funcion az összes input adatot elküldi az action.phpba, és egy kérést is, ami hozzá konkatenálunk
                            success: function (response) { //amikor adatot küldünk az action php be, a választ a szervertől ez a function szerzi meg,
                                $("#figyelmeztetes").show();
                                $("#eredmeny").html(response);
                                $("#loader").hide();
                            }
                        });
                    }
                    return true;
                });

                $("#bejelentkezes").click(function (e) { //itt vizsgáljuk hogy rákattintottunk a bejelentkezes gombra
                    if (document.getElementById('bejelentkezes-form').checkValidity()) {
                        e.preventDefault(); //tehát hogyha a bejelentkezes gombra kattintunk akkor az adatokat beküldi az adatbázisba, és nem frissíti az egész oldalt.
                        $("#loader").show();
                        $.ajax({
                            url: 'action.php', //ahova küldjük a form adatokat
                            method: 'post',
                            data: $("#bejelentkezes-form").serialize() + '&action=bejelentkezes', //ez a funcion az összes input adatot elküldi az action.phpba, és egy kérést is, ami hozzá konkatenálunk
                            success: function (response) { //amikor adatot küldünk az action php be, a választ a szervertől ez a function szerzi meg,
                                if (response = "ok") {
                                    window.location = 'logreg.php';
                                }
                                else {
                                    $("#figyelmeztetes").show();
                                    $("#eredmeny").html(response);
                                    $("#loader").hide();
                                }

                            }
                        });
                    }
                    return true;
                });

                $("#elfelejtett_jelszo").click(function (e) { //itt vizsgáljuk hogy rákattintottunk a register gombra
                    if (document.getElementById('elfelejtett-jelszo-form').checkValidity()) {
                        e.preventDefault(); //tehát hogyha a regisztráció gombra kattintunk akkor az adatokat beküldi az adatbázisba, és nem frissíti az egész oldalt.
                        $("#loader").show();
                        $.ajax({
                            url: 'action.php', //ahova küldjük a form adatokat
                            method: 'post',
                            data: $("#elfelejtett-jelszo-form").serialize() + '&action=elfelejtett_jelszo', //ez a funcion az összes input adatot elküldi az action.phpba, és egy kérést is, ami hozzá konkatenálunk
                            success: function (response) { //amikor adatot küldünk az action php be, a választ a szervertől ez a function szerzi meg,

                                $("#figyelmeztetes").show();
                                $("#eredmeny").html(response);
                                $("#loader").hide();
                            }
                        });
                    }
                    return true;
                });
            });
        </script>>
    </body>
</html>