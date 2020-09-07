<?php
error_reporting(0);
require 'logreg/session.php';
?>
<!DOCTYPE html>
<html lang="hu">
    <head>
        <title>EvenTTrack</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"> -->
        <link href="bootstrap/css/bootstrap.min.css" media="all" rel="stylesheet">
        <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
        <script src="bootstrap/js/bootstrap.js" media="all" rel="stylesheet"></script>
       <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
        <script src="ajax/jquery.min.js"></script>




        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>




        <style>
            body {
                background: url('hatterkep/hatter.jpg') ;
                background-size: 100%;
            }
            button {
              /*  opacity: 0.8; */
                width: 20vw;
                height: 20vh;
            }
            .kezdobuttonok{
              width: 20vw;
              height: 20vh;
            }
            div{
              opacity: 0.95;
              /*p-3: 2vh;*/
              
            }

        </style>

    </head>
    <body>
       
      <!-- NAVBAR START -->
         <div class="jumbotron text-center">
                      <h1>Fő oldal</h1>
                      <p>Üdvözöllek az EvenTTrack oldalon!</p> 
                      <nav class="navbar navbar-expand-lg navbar-light bg-light">
                          <a class="navbar-brand" href="index.php">EvenTTrack</a>
                          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                              <span class="navbar-toggler-icon"></span>
                          </button>

                          <div class="collapse navbar-collapse" id="navbarSupportedContent">
                              <ul class="navbar-nav mr-auto">
                                  <li class="nav-item active">
                                      <a class="nav-link" href="index.php">Főoldal<span class="sr-only"></span></a>
                                  </li>
                                  <?php if ($f_jogosultsag == "admin") { ?>      
                                  <a class="nav-link text-danger" href="userkezeles/felhasznaloKezeles.php">Felhasználók kezelése<span class="sr-only"></span></a>
                                <?php  }?>
                                  <a class="nav-link" href="naptar/naptar.php">Naptár<span class="sr-only"></span></a>
                              </ul>
                              <a class="nav navbar-nav navbar-right navbar-brand" href="logreg/profile.php">  <?php echo "<b>Felhasználónév: </b>", $f_felhasznalonev; ?> </a>
                              <ul class="nav navbar-nav navbar-right">
                                <?php if ($bejelentkezve == false) { ?>
                                  <li><h6><a href="logreg/logreg.php"> <span class="badge badge-secondary">Bejelentkezés</span></a></h6></li>
                                  <?php  }?>
                                  <?php if ($bejelentkezve == true) { ?>
                                  <li><h6><a href="logreg/kijelentkezes.php"> <span class="badge badge-secondary">Kijelentkezés</span></a></h6></li>
                                  <?php  }?>
                              </ul>
                          </div>
                      </nav>

        </div>
        
      <!-- NAVBAR END -->

       <!-- GOMBOK START -->
        <div class="pagination-container text-center p-3">
            <div class="row p-3" >
                <div class="col-sm-4 p-3">
                    <a href="logreg/logreg.php">
                    <span class="border border-danger rounded btn btn-dark btn-lg text-light text-center kezdobuttonok">
                        <h3>Regisztráció</h3>
                        <p>Ha még nincs fiókja regisztráljon</p>
                    </span>
                    </a>
                </div>
        <?php if ($bejelentkezve == false) { ?>
                <div class="col-sm-4 p-3">
                  <a href="logreg/logreg.php">
                    <span class="border border-danger rounded btn btn-dark btn-lg text-light text-center kezdobuttonok">
                        <h3>Bejelentkezés</h3>
                        <p>Ha korábban már létrehozott egy fiókot akkor jelentkezzen be.</p>
                    </span>
                  </a>
                </div>
        <?php  }?>
        <?php if ($bejelentkezve == true) { ?>
                <div class="col-sm-4 p-3">
                    <a href="logreg/kijelentkezes.php">
                    <span class="border border-danger rounded btn btn-dark btn-lg text-light text-center kezdobuttonok">
                        <h3>Kijelentkezés</h3>        
                    </span>
                  </a>
                </div>
        <?php  }?>
               <div class="col-sm-4 p-3 ">
                  <a href="logreg/profile.php">
                    <span class="border border-danger rounded btn btn-dark btn-lg text-light badge-dark p-2  text-center kezdobuttonok">
                        <h3>Profilkártya</h3>
                        <p>A saját profilkártya megjelenítése.</p>
                    </span>
                  </a>
                </div>


                <div class="col-sm-4 p-3 ">
                  <a href="naptar/naptar.php">
                    <span class="border border-danger rounded btn btn-dark btn-lg text-light badge-dark p-2  text-center kezdobuttonok">
                        <h3>Naptár</h3>
                        <p>A naptárral kapcsolatos tevékenységek. Itt tud felvenni feladatot a naptárába.</p>
                    </span>
                  </a>
                </div>
        <?php if ($f_jogosultsag == "admin") { ?>  
                <div class="col-sm-4 p-3">
                  <a href="userkezeles/felhasznaloKezeles.php">
                    <span class="border border-danger rounded btn btn-dark btn-lg text-light text-center kezdobuttonok">
                        <h3>Felhasználók kezelése</h3>
                        <p>Egy admin felület</p>
                    </span>
                </div>
            </div>
            <?php  }?>
        </div>
        <!-- Gombok END -->

    </body>
</html>
