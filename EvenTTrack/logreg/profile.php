<?php
error_reporting(0);
require 'session.php';
if (!$felhasznalo == "") {
   $nincskep =false;
}

if ($f_felhasznalonev=="") {
        session_destroy();
         header('Refresh: 1;');              
    }





?>

<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <title>Profil</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <script src="../ajax/jquery.min.js"></script>
        <!--<script src="../bootstrap/js/bootstrap.min.js"></script>-->
        <script src="http://code.jquery.com/jquery-3.4.1.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    </head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            max-width: 300px;
            margin: auto;
            text-align: center;
            font-family: arial;
        }

        .title {
            color: grey;
            font-size: 18px;
        }

        button {
            border: none;
            outline: 0;
            display: inline-block;
            padding: 8px;
            color: white;
            background-color: #000;
            text-align: center;
            cursor: pointer;
            width: 100%;
            font-size: 18px;
        }
        span{
          border-radius: 500px;
    outline: none;
    margin: 0 auto 0;
    background-color: Transparent;
        }


        /*a{
          text-decoration: none;
          font-size: 2vh;
          color: black;
        }*/
        body {
                background: url('../hatterkep/hatter.jpg') no-repeat;
                background-size: 100%;
                background-repeat: repeat;
            }
            div{
              opacity: 0.95;
            }

        button:hover, a:hover {
            opacity: 0.7;
        }
     
           #modositas-box,#figyelmeztetes,#loader{
               display: none;
            }
            

    </style>
    <body>
      <!-- START NAVBAR -->
                  <div class="jumbotron text-center">
                      <h1>Profil</h1>
                      <nav class="navbar navbar-expand-lg navbar-light bg-light">
                          <a class="navbar-brand" href="../index.php">EvenTTrack</a>
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
                                <?php if ($bejelentkezve == false) { ?>
                                  <li><h6><a href="logreg.php"> <span class="badge badge-secondary">Bejelentkezés</span></a></h6></li>
                                  <?php  }?>
                                  <?php if ($bejelentkezve == true) { ?>
                                  <li><h6><a href="kijelentkezes.php"> <span class="badge badge-secondary">Kijelentkezés</span></a></h6></li>
                                  <?php  }?>
                              </ul>
                          </div>
                      </nav>
                  </div>
      <!-- END NAVBAR -->
      <!-- üzenet -->
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
      <!-- üzenet -->
      <!-- START PFORILKÁRTYA-->
      

              
                    <div class="row">
                            <div class="card  bg-secondary form-group" id="profilkartya-box">
                                 <form id="profilkartya-form">
                                <h2 style="text-align:center">Felhasználó profilkártyája</h2>
                                <?php if ($nincskep == true) { ?>
                                <h1><img src="../tesztkepek/EvenTTrack_alapkep.jpg " width="100%"></h1>
                              <?php } else{?>
                                <h1><img src="../userkezeles/<?= $row['f_kep']; ?>" width="100%"></h1>
                              <?php  }?>
                                <div class="form-group">
                                <h1><?= $f_nev; ?></h1>
                                <p>Jogosultságod: <a class="text-danger"><?= $f_jogosultsag; ?></a></p>
                                <p>Regisztráció napja: <a class="text-primary"><?= $f_regdatum; ?></a></p>
                                <p>Regisztráció napja: <a class="text-primary"><?= $f_telefonszam; ?></a></p>
                              <!--  <div style="margin: 24px 0;"> -->
                                </div>
                                <div class="form-group">
                                    <a href="#"><i class="fa fa-dribbble"></i></a> 
                                    <a href="#"><i class="fa fa-twitter"></i></a>  
                                    <a href="#"><i class="fa fa-linkedin"></i></a>  
                                    <a href="#"><i class="fa fa-facebook"></i></a> 
                                </div> 
                                <div class="form-group">
                                <a class="" href="#" name="adataimSzerkesztese-button" id="adataimSzerkesztese-button"> <span class="badge-warning p-2">Adataim szerkesztése</span></a>
                                </div>
                                </form>
                            </div>                  
                    </div>
                  
                  <!-- END PFORILKÁRTYA-->
                  <div class="row">
                    <div class="card  bg-secondary form-group" id="modositas-box">
                                 <form id="adataimModositasa-form">
                                <h2 style="text-align:center">Adataim módosítása</h2>
                                
                                <h1><img src="../userkezeles/<?= $row['f_kep']; ?>" width="100%"></h1>
                                <div class="form-group">
                                    <input type="text" name="f_adatmodositasNev" value="<?= $f_nev ?>" class="form-control" placeholder="Teljes név" required minLength="3">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="f_adatmodositasFelhasznalonev" value="<?= $f_felhasznalonev?>" class="form-control" placeholder="Felhasználó név" required minLength="4">
                                </div>
                                <div class="form-group">
                                    <input type="email" name="f_adatmodositasEmail" value="<?= $f_email?>" class="form-control" placeholder="E-Mail" required>
                                </div>
                                <div class="form-group">
                                    <input type="tel" name="f_adatmodositasTelefonszam" value="<?= $f_telefonszam?>" class="form-control" placeholder="Telefonszám" required>
                                </div>
                              <div class="form-group">
                              <!--<a href="#" name="adataimModositasa-button" id="adataimModositasa-button"><span class="badge-warning p-2">Adataim módosítása</span></a> -->
                              <input type="submit" name="adataimModositasa-button" id="adataimModositasa-button" value="Adataim módosítása" class="btn btn-warning btn-block">
                              </div>
                              <div class="form-group">
                              <a href="#" name="visszaAProfilkartyara-button" id="visszaAProfilkartyara-button"><span class="badge-dark p-2">Vissza a Profilkártyára</span></a> </div>
                                </form>
                            </div>
                  </div>
               

<script type="text/javascript">


            $(document).ready(function () {
                $("#adataimSzerkesztese-button").click(function () {
                    $("#profilkartya-box").hide();
                    $("#modositas-box").show();
                });
                $("#visszaAProfilkartyara-button").click(function () {
                    $("#modositas-box").hide();
                    $("#profilkartya-box").show();
                }); 
                     

                $("#adataimModositasa-form").validate(

                  );
              
                $("#adataimModositasa-button").click(function (e) { //itt vizsgáljuk hogy rákattintottunk a regisztráció gombra
                    if (document.getElementById('adataimModositasa-form').checkValidity()) {
                        e.preventDefault(); //tehát hogyha a regisztráció gombra kattintunk akkor az adatokat beküldi az adatbázisba, és nem frissíti az egész oldalt.
                        $("#loader").show();
                        $.ajax({
                            url: 'action.php', //ahova küldjük a form adatokat
                            method: 'post',
                            data: $("#adataimModositasa-form").serialize() + '&action=adataimModositasa', //ez a funcion az összes input adatot elküldi az action.phpba, és egy kérést is, ami hozzá konkatenálunk
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
        </script>
    </body>
</html>

