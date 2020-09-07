<?php
include 'config.php';
require '../logreg/session.php';

$modositas=false;
    $f_f_id="";
    $f_nev="";
    $f_email="";
    $f_telefonszam="";
    $f_kep="";
    $f_jogosultsag="";

//hozzáadás gomb lenyomása a felhasználó kezelésben action vizsgálattal(drótozás)
if (isset($_POST["hozzaadas"])) {
  
    $f_nev=$_POST["f_nev"];
    $f_email=$_POST["f_email"];
    $f_telefonszam=$_POST["f_telefonszam"];
    
    $f_kep=$_FILES['f_kep']['name'];
    $upload="feltoltesek/".$f_kep; 
    $f_jogosultsag=$_POST["f_jogosultsag"];
    
    $query="INSERT INTO felhasznalok (f_nev, f_email, f_telefonszam, f_kep,f_jogosultsag) VALUES (?,?,?,?,?)";
    $stmt=$conn->prepare($query);
    $stmt->bind_param("sssss",$f_nev,$f_email,$f_telefonszam,$upload,$f_jogosultsag);
    $stmt->execute();
    
    move_uploaded_file($_FILES['f_kep']['tmp_name'],$upload);
    
    header('location:felhasznaloKezeles.php');
    $_SESSION['reakcio']="Sikeresen hozzáadva az adatbázisba!";
    $_SESSION['reakcio_tipus']="success";
}
//törlés gomb lenyomása a felhasználó kezelésben action vizsgálattal(drótozás)
if (isset($_GET['torles'])) {
    $f_id=$_GET['torles'];
    
    $sql="SELECT f_kep FROM felhasznalok WHERE f_id=?";
    $stmt2=$conn->prepare($sql);
    $stmt2->bind_param("i",$f_id);
    $stmt2->execute();
    $result2=$stmt2->get_result();
    $row=$result2->fetch_assoc();
    
    $kepUtvonal=$row['f_kep'];
    unlink($kepUtvonal);
    
    $query="DELETE FROM felhasznalok WHERE f_id=?";
    $stmt=$conn->prepare($query);
    $stmt->bind_param("i",$f_id);
    $stmt->execute();
    
    header('location:felhasznaloKezeles.php');
    $_SESSION['reakcio']="Sikeresen Törölve!";
    $_SESSION['reakcio_tipus']="danger";
}
//szerkesztés gomb lenyomása a felhasználó kezelésben action vizsgálattal(drótozás)
if (isset($_GET['szerkesztes'])) {
    $f_id=$_GET['szerkesztes'];
    
    $query="SELECT * FROM felhasznalok WHERE f_id=?";
    $stmt=$conn->prepare($query);
    $stmt->bind_param("i",$f_id);
    $stmt->execute();
    $result=$stmt->get_result();
    $row=$result->fetch_assoc();
    
    $f_id=$row['f_id'];
    $f_nev=$row['f_nev'];
    $f_email=$row['f_email'];
    $f_telefonszam=$row['f_telefonszam'];
    $f_kep=$row['f_kep'];
    $f_jogosultsag=$row['f_jogosultsag'];
    $modositas=true;
}
//modositás gomb lenyomása a felhasználó kezelésben action vizsgálattal(drótozás)
if (isset($_POST['modositas'])) {
    
    $f_id=$_POST['f_id'];
    $f_nev=$_POST['f_nev'];
    $f_email=$_POST['f_email'];
    $f_telefonszam=$_POST['f_telefonszam'];
    $f_regikep=$_POST['f_regikep'];
    $f_jogosultsag=$_POST['f_jogosultsag'];
    
    if (isset($_FILES['f_kep']['name']) && $_FILES['f_kep']['name'] !="" ) {
        
        $f_ujkep="feltoltesek/".$_FILES['f_kep']['name'];
        unlink($f_regikep);
        move_uploaded_file($_FILES['f_kep']['tmp_name'], $f_ujkep);
    }
    else{
        $f_ujkep=$f_regikep;
    }
    $query="UPDATE felhasznalok SET f_nev=?,f_email=?,f_telefonszam=?,f_kep=?,f_jogosultsag=? WHERE f_id=?";
    $stmt=$conn->prepare($query);
    $stmt->bind_param("sssssi",$f_nev,$f_email,$f_telefonszam,$f_ujkep,$f_jogosultsag,$f_id);
    $stmt->execute();
    
    $_SESSION['reakcio']="Sikeres módosítás!";
    $_SESSION['reakcio_tipus']="primary";
    header('location:felhasznaloKezeles.php');
}
//részletek gomb lenyomása a felhasználó kezelésben action vizsgálattal(drótozás)
if (isset($_GET['reszletek'])) {
    $f_id=$_GET['reszletek'];
    
    $query="SELECT * FROM felhasznalok WHERE f_id=?";
    $stmt=$conn->prepare($query);
    $stmt->bind_param("i",$f_id);
    $stmt->execute();
    $result=$stmt->get_result();
    $row=$result->fetch_assoc();
    
    $vf_id=$row['f_id'];
    $vf_nev=$row['f_nev'];
    $vf_email=$row['f_email'];
    $vf_telefonszam=$row['f_telefonszam'];
    $vf_kep=$row['f_kep'];
    $vf_jogosultsag=$row['f_jogosultsag'];
    
}
?>
