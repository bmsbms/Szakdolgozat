<?php 
error_reporting(0);
require '../logreg/session.php';
    $csatlakozas = mysqli_connect("localhost", "root", "", "eventtrackdb");
    if(!$csatlakozas){
        die("Hiba történt az adatbázis csatlakozásakor.");
    }

    function db_modositasTema($ujTema,$felhasznaloId){
        global $csatlakozas;
        $query = "UPDATE tema SET aktualis_tema = '$ujTema' WHERE tema_f_id = '$felhasznaloId'";
        $result = mysqli_query($csatlakozas, $query);
        if(!$result){
            die("(14)Valami hiba történt! Kérem probálja újra késöbb: 14  " . mysqli_error($csatlakozas));
        }
    }
    
    function db_beszurasJegyzet($uid, $szin, $szoveg,$felhasznaloId){
        global $csatlakozas;
        $szoveg = mysqli_real_escape_string($csatlakozas, $szoveg);
        $query = "INSERT INTO jegyzetek(jegyzet_id, jegyzet_szin, jegyzet_szoveg,jegyzetek_f_id) VALUES('$uid', '$szin', '$szoveg','$felhasznaloId')";
        $result = mysqli_query($csatlakozas, $query);
        if(!$result){
            die("(24) Valami hiba történt! Kérem probálja újra késöbb.");
        }
    }
    
    function db_modositasJegyzet($uid, $szoveg){
        global $csatlakozas;
        $szoveg = mysqli_real_escape_string($csatlakozas, $szoveg);
        $query = "UPDATE jegyzetek SET jegyzet_szoveg = '$szoveg' WHERE jegyzet_id = '$uid' LIMIT 1";
        $result = mysqli_query($csatlakozas, $query);
        if(!$result){
            die("(34)Valami hiba történt! Kérem probálja újra késöbb.");
        }
    }
    
    function db_torlesJegyzet($uid){
        global $csatlakozas;
        $query = "DELETE FROM jegyzetek WHERE jegyzet_id = '$uid'";
        $result = mysqli_query($csatlakozas, $query);
        if(!$result){
            die("(43)Valami hiba történt! Kérem probálja újra késöbb.");
        }
    }
    
    function beallitasTema($bejelentkezettUserId){
        global $csatlakozas;
        $query = "SELECT * FROM tema WHERE tema_f_id='$bejelentkezettUserId' ";
        $result = mysqli_query($csatlakozas, $query);
        if(!$result){
            die("(52)Valami hiba történt! Kérem probálja újra késöbb.");
        }
        
        while($row = mysqli_fetch_assoc($result)){
            return $row['aktualis_tema'];
        }
    }

    function getJegyzetAdatok($bejelentkezettUserId){
        global $csatlakozas;
        $query = "SELECT * FROM jegyzetek WHERE jegyzetek_f_id='$bejelentkezettUserId'";
        $result = mysqli_query($csatlakozas, $query);
        if(!$result){
            die("(65)Valami hiba történt");
        }
        
        $id = 0;
        $szin = 1;
        $szoveg = "";
        
        while($row = mysqli_fetch_assoc($result)){
            $id = $row['jegyzet_id'];
            $szin = $row['jegyzet_szin'];
            $szoveg = $row['jegyzet_szoveg'];
            
            ?>
                <script type="text/javascript">
                    
                    poszt = {
                        id: <?php echo json_encode($id); ?>,
                        jegyzet_szama: <?php echo json_encode($szin); ?>,
                        jegyzet: <?php echo json_encode($szoveg); ?>
                    }
                    
                    posztok_tomb.push(poszt);
                    
                </script>
            
            <?php
        }
    }



    if(isset($_POST['szin'])){
        db_modositasTema($_POST['szin'],$jegyzetek_f_id);
    }

    if(isset($_POST['uj_jegyzet_uid'])){
        db_beszurasJegyzet($_POST['uj_jegyzet_uid'], $_POST['uj_jegyzet_szine'], $_POST['uj_jegyzet_szovege'],$jegyzetek_f_id);
    }
    
    if(isset($_POST['modositas_jegyzet_uid'])){
        db_modositasJegyzet($_POST['modositas_jegyzet_uid'], $_POST['modositas_jegyzet_szovege']);
    }
    
    if(isset($_POST['torles_jegyzet_uid'])){
        db_torlesJegyzet($_POST['torles_jegyzet_uid']);
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <title>Naptár</title>
    <link rel="icon" type="image/png" href="images/icon2.png" sizes="72x72">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/aktualis_nap.css">
    <link rel="stylesheet" href="css/naptar.css">
    <link rel="stylesheet" href="css/naptar_borders.css">
    <link rel="stylesheet" href="css/modal.css">
    <link rel="stylesheet" href="css/portrait.css">
</head>
<body>
    <h3 class="background-text off-color">2020</h3>
    <h4 class="background-text off-color">Naptár</h4>
     
     <!-- START AKTUÁLIS NAPI INFORMÁCIÓ -->
    <div id="current-day-info" class="color">
        
        <h1 id="app-name-landscape" class="center off-color default-cursor">Naptáram</h1>
        <div>
            <h2 class="center current-day-heading default-cursor" id="cur-year">2020</h2>    
        </div>
        <div>
            <h1 class="center current-day-heading default-cursor" id="cur-day">Hétfő</h1>
            <h1 class="center current-day-heading default-cursor" id="cur-month">Március</h1>
            <h1 class="center current-day-heading default-cursor" id="cur-date">7</h1>
        </div>
    
        <button id="theme-landscape" class="font button" onclick="megnyitasModal(1)">Téma megváltoztatása</button>
        <br>
        <button id="theme-landscape" class="font button" src="../index.php" onclick="foOldal()">Vissza a főoldalra</button>
        <br>
    </div>
    <!-- END AKTUÁLIS NAPI INFORMÁCIÓ -->
    <!-- START NAPTÁR -->
    <div id="calendar">
      
      <h1 id="app-name-portrait" class="center off-color">Naptáram</h1>
      
      <table class="default-cursor">
          <thead class="color">
              <tr >
                  <th colspan="7" class="border-color">
                      <h4 id="cal-year">2020</h4>
                      <div>
                          <i onclick="elozoHonap();" class="icon fas fa-caret-left"></i>
                          <h3 id="cal-month">Március</h3>
                          <i onclick="kovetkezoHonap();" class="icon fas fa-caret-right"></i>
                      </div>
                  </th>
              </tr>
              <tr>
                  <th class="weekday border-color">Vas</th>
                  <th class="weekday border-color">Hét</th>
                  <th class="weekday border-color">Kedd</th>
                  <th class="weekday border-color">Szer</th>
                  <th class="weekday border-color">Csü</th>
                  <th class="weekday border-color">Pán</th>
                  <th class="weekday border-color">Szo</th>
              </tr>
          </thead>

          <tbody id="table-body" class="border-color">
              <tr>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
              </tr>
              <tr>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
              </tr>
              <tr>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
              </tr>
              <tr>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
              </tr>
              <tr>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
              </tr>
              <tr>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
                  <td onclick="napraKattintas(this);">1</td>
              </tr>
          </tbody>
          
      </table>
      <button id="theme-portrait" class="font button color" onclick="megnyitasModal(1)">Change Theme</button>
    </div>
    <!-- END NAPTÁR -->
    <!-- START KEDVENC SZIN MODAL -->
    <dialog id="modal" closed>
            <div id="fav-color" hidden>
                <div class="popup">
                    <h4 class="center">Mi a kedvenc szined?</h4>
                    
                    <div id="color-options">
                        <div class="color-option">
                            <div class="color-preview" id="kek" style="background-color: #1B19CD;" onclick="modositasSzinAdatok('kek')"></div>
                            <h5>Kék</h5>
                        </div>
                        
                        <div class="color-option">
                            <div class="color-preview" id="piros" style="background-color: #D01212;" onclick="modositasSzinAdatok('piros')"></div>
                            <h5>Piros</h5>
                        </div>
                        
                        <div class="color-option">
                            <div class="color-preview" id="lila" style="background-color: #721D89;" onclick="modositasSzinAdatok('lila')"></div>
                            <h5>Lila</h5>
                        </div>
                        
                        <div class="color-option">
                            <div class="color-preview" id="zold" style="background-color: #158348;" onclick="modositasSzinAdatok('zold')"></div>
                            <h5>Zöld</h5>
                        </div>
                        
                        <div class="color-option">
                            <div class="color-preview" id="narancs" style="background-color: #EE742D;" onclick="modositasSzinAdatok('narancs')"></div>
                            <h5>Narancs</h5>
                        </div>
                        
                        <div class="color-option">
                            <div class="color-preview" id="sotetebb-narancs" style="background-color: #F13C26;" onclick="modositasSzinAdatok('sotetebb-narancs')"></div>
                            <h5>Sötétebb Narancs</h5>
                        </div>
                        
                        <div class="color-option">
                            <div class="color-preview" id="baba-kek" style="background-color: #31B2FC;" onclick="modositasSzinAdatok('baba-kek')"></div>
                            <h5>Baba Kék</h5>
                        </div>
                        
                        <div class="color-option">
                            <div class="color-preview" id="cseresznye" style="background-color: #EA3D69;" onclick="modositasSzinAdatok('cseresznye')"></div>
                            <h5>Cseresznye</h5>
                        </div>
                        
                        <div class="color-option">
                            <div class="color-preview" id="lime" style="background-color: #36C945;" onclick="modositasSzinAdatok('lime')"></div>
                            <h5>Lime</h5>
                        </div>
                        
                        <div class="color-option">
                            <div class="color-preview" id="zoldeskek" style="background-color: #2FCCB9;" onclick="modositasSzinAdatok('zoldeskek')"></div>
                            <h5>ZöldesKék</h5>
                        </div>
                        
                        <div class="color-option">
                            <div class="color-preview" id="rozsaszin" style="background-color: #F50D7A;" onclick="modositasSzinAdatok('rozsaszin')"></div>
                            <h5>Rózsaszin</h5>
                        </div>
                        
                        <div class="color-option">
                            <div class="color-preview" id="fekete" style="background-color: #212524;" onclick="modositasSzinAdatok('fekete')"></div>
                            <h5>Fekete</h5>
                        </div>
                    </div>
                    
                    <button id="update-theme-button" class="button font" onclick="modositasSzinreKattintas()">Módosítás</button>
                </div>
            </div>        
     <!-- END KEDVENC SZIN MODAL -->
     <!-- START JEGYZET HOZZÁADÁSA MODAL -->
            <div id="make-note" hidden>
                <div class="popup">
                    <h4>Jegyzet hozzáadása a naptárhoz</h4>
                    <textarea id="edit-post-it" class="font" name="post-it" autofocus></textarea>
                    <div>
                        <button class="button font post-it-button" id="add-post-it" onclick="bekuldesPoszt();">Poszt</button>
                        <button class="button font post-it-button" id="delete-button" onclick="torlesJegyzet();">Töröld ki</button>
                    </div>
                </div>
            </div>
    <!-- START JEGYZET HOZZÁADÁSA MODAL -->
    </dialog>
    
    
    <script type="text/javascript" src="js/main.js"></script>
    <script type="text/javascript" src="js/ajax.js"></script>
    <script type="text/javascript" src="js/adatok.js"></script>
    <script type="text/javascript" src="js/datum.js"></script>
    <script type="text/javascript" src="js/modal.js"></script>
    <script type="text/javascript" src="js/modositas_szin.js"></script>
    <script type="text/javascript" src="js/elkeszites_jegyzetek.js"></script>
    <script type="text/javascript" src="js/felepites_naptar.js"></script>
    <script type="text/javascript">
    
        modositasSzinAdatok( <?php echo(json_encode(beallitasTema($jegyzetek_f_id))); ?> );
        valtoztatasSzin();
        document.body.style.display = "flex";
        function foOldal(){
            window.location = '../index.php';
            }
        
    </script>
    <?php getJegyzetAdatok($jegyzetek_f_id); ?>
    <script type="text/javascript" src="js/start.js"></script>
</body>
</html>