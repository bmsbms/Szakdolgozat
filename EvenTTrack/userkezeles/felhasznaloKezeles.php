<?php
error_reporting(0);
    include 'action.php';
 ?>

<!DOCTYPE html>
<hmtl lang="en">
<head>
	<title>Felhasználók kezelése</title>
	<!-- Latest compiled and minified CSS -->
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="../ajax/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
</head>
<style>
body {
  background-color: lightgrey;           
}
</style>
<body>
	<!-- START NAVBAR -->
<div class="jumbotron text-center">
  <h1>A Felhasználók kezelése</h1> 
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
            <a class="nav-link disabled text-danger">Felhasználók kezelése<span class="sr-only"></span></a>
            <a class="nav-link" href="../naptar/naptar.php">Naptár<span class="sr-only"></span></a>
        </ul>
        <a class="nav navbar-nav navbar-right navbar-brand" href="../logreg/profile.php"> <?php echo "<b>Felhasználónév: </b>", $f_felhasznalonev; ?></a>
        <ul class="nav navbar-nav navbar-right">
        	<?php if ($bejelentkezve == false) { ?>
            <li><h6><a href="../logreg/logreg.php"> <span class="badge badge-secondary">Bejelentkezés</span></a></h6></li>
        <?php } ?>
        <?php if ($bejelentkezve == true) { ?>
            <li><h6><a href="../logreg/kijelentkezes.php"> <span class="badge badge-secondary">Kijelentkezés</span></a></h6></li>
            <?php } ?>
        </ul>
    </div>
</nav>
</div>
<!-- END NAVBAR -->
<div class="container-fluid">
	<div class="row justify-content-center">
		<div class="col-md-10">
			<h3 class="text-center text-dark mt-2">
				Felhasználó kezelés
			</h3>
			<hr>			<!-- FELHASZNÁLÓI ÜZENETVISSZAJELZÉS -->
                        <?php if (isset($_SESSION['reakcio'])){ ?>
                        <div class="alert alert-<?= $_SESSION['reakcio_tipus']; ?> alert-dismissible text-center"> <!-- ha a session typis sucess zölden irja ki ka törlés piros, dinamikusan váltogatja a szineket a megfejelő actionhöz -->
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <b><?= $_SESSION['reakcio']; ?></b>
						</div>
                        <?php } unset($_SESSION['reakcio']);?>

                     <!-- START ADATOK MÓDOSITÁSA ÉS FELVÉTELE FORM -->   
		<div class="row">
			<div class="col-md-4">
				<?php if ($modositas==true){ ?>
				<h3 class="text-center text-info"> Adatok módosítása</h3>
				<?php } else{ ?>
					<h3 class="text-center text-info"> Adatok felvétele</h3>
					<?php }?>
				<form action="action.php" method="post" enctype="multipart/form-data"> 
                                    <input type="hidden" name="f_id" value="<?= $f_id; ?>">
				<div class="form-group">
					<input type="text" name="f_nev" value="<?= $f_nev ?>" class="form-control" placeholder="Ird be a nevet" required>
				</div>
				<div class="form-group">
					<input type="email" name="f_email" value="<?= $f_email ?>" class="form-control" placeholder="írd be az emailt" required>
				</div>
				<div class="form-group">
					<input type="tel" name="f_telefonszam" value="<?= $f_telefonszam ?>" class="form-control" placeholder="ird be a telefonszamot" required minLength="10">
				</div>
				<div class="form-group">
					<input type="text" name="f_jogosultsag" value="<?= $f_jogosultsag ?>" class="form-control" placeholder="ird be a jogosultságot">
				</div>
				<div class="form-group">
                                    <input type="hidden" name="f_regikep" value="<?= $f_kep; ?>">
					<input type="file" name="f_kep" class="custom-file">	
                                        <img src="<?= $f_kep ?>" width="120" class="img-thumbnail">
				</div>
				<div class="form-group">
                                    <?php if ($modositas==true){ ?>
                                    <input type="submit" name="modositas" class="btn btn-success btn-block" value="Adat módosítása">
                                    <?php } else{ ?>
					<input type="submit" name="hozzaadas" class="btn btn-primary btn-block" value="Adat hozzáadása">
                                    <?php }?>
                                </div>
				</form>
				
			</div>
			<!-- END ADATOK MÓDOSITÁSA ÉS FELVÉTELE FORM -->
			<!-- START TÁBLÁZAT -->   
			<div class="col-md-8">
                            <?php
                            $query="SELECT * FROM felhasznalok";
                            $stmt=$conn->prepare($query);
                            $stmt->execute();
                            $result=$stmt->get_result();
                            ?>
				<h3 class="text-center text-info">Adatbázisban lévő adatok</h3>

				<table class="table table-bordered table-hover">
					    <thead>
					      <tr>
					        <th>#</th>
					        <th>Kép</th>
					        <th>Név</th>
					        <th>Email</th>
					        <th>Telefonszám</th>
					        <th>Jogosultság</th>
					        <th>Művelet</th>
                                                
					      </tr>
					    </thead>
					    <tbody>
                                                <?php while($row=$result->fetch_assoc()) { ?>
					      <tr>
					        <td><?= $row['f_id']; ?></td>
					        <td><img src="<?= $row['f_kep']; ?>" width="25"></td>
					        <td><a href="reszletek.php?reszletek=<?= $row['f_id']; ?>"><?php echo $row['f_nev'];?></a></td>
					        <td><?= $row['f_email']; ?></td>
					        <td><?= $row['f_telefonszam']; ?></td>
					        <td><?= $row['f_jogosultsag']; ?></td>
					        <td>
					        	<a href="felhasznaloKezeles.php?hozzaadas=<?= $row['f_id']; ?>" class="badge badge-info p-2">Felvétel</a> |
					        	<a href="felhasznaloKezeles.php?szerkesztes=<?= $row['f_id']; ?>" class="badge badge-success p-2">Szerkesztés</a> |
					        	<a href="reszletek.php?reszletek=<?= $row['f_id']; ?>" class="badge badge-warning p-2">Részletek</a> |
                                <a href="action.php?torles=<?= $row['f_id']; ?>" class="badge badge-danger p-2" onclick="return confirm('Biztos törölni szeretnéd?')">Törlés</a>
					        </td>
					      </tr>
                                                <?php }?>
					    </tbody>
					  </table>				
			</div>
			<!-- END ADATOK MÓDOSITÁSA ÉS FELVÉTELE FORM -->   
		</div>
	</div>
</div>

</body>
</html>