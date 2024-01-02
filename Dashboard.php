<?php 
session_start();
$connessione=@mysqli_connect("localhost","root","","covid19");
if (mysqli_connect_errno()){
    echo "Errore nella Connessione al Database.".die (mysqli_connect_error());
}
//Ultimo accesso registrato {data ip ora}
                            $lasthourdateip="select ora, data, ip from accessi where token=\"".$_SESSION['utente']."\"";
                            $lasth=mysqli_query($connessione,$lasthourdateip);
                            $fetchlast=mysqli_fetch_array($lasth);

if (empty($_SESSION['utente']) && empty($_SESSION['passwd'])){
  header("location: LoginRegister.php");
}
?>

<head>
  <?php include "include/header.php"?>
</head>

<body>
  <div class="container-fluid">
    <nav class="navbar navbar-light bg-light justify-content-center border rounded-lg">
    <a class="navbar-brand" href="Homepage.php">Home</a>
      <a class="navbar-brand">Benvenuto <?php echo $_SESSION['utente'];?></a>
    </nav>
  </div>
  <div class="container-fluid">
    <div class="alert alert-danger text-center" role="alert">
            Ultimo accesso Il <?php echo $fetchlast[1];?>  Ore <?php echo $fetchlast[0];?> IP: <?php echo $fetchlast[2]; ?>
    </div>
  </div>
  <div class="container-fluid col-sm-4">
    <h1 style="font-family: 'Open Sans', sans-serif;" class="text">Aggiornamento Dati</h1>
    <form method="POST" action="backend/Dashboardlogic.php">
      <div class="form-group">
        <label for="data">Data</label>
        <input class="form-control form-control-lg" type="date" id="data" name="data" placeholder="Data">
      </div>
      <div class="form-group">
        <label for="positivi">Positivi</label>
        <input class="form-control form-control-lg" type="text" id="positivi" name="positivi" placeholder="Inserisci il numero di Positivi">
      </div>
      <div class="form-group">
        <label for="dimessi">Dimessi</label>
        <input class="form-control form-control-lg" type="text" id="dimessi" name="dimessi" placeholder="Inserisci il numero di Dimessi">
      </div>
      <div class="form-group">
        <label for="decessi">Decessi</label>
        <input class="form-control form-control-lg" type="text" id="decessi" name="decessi" placeholder="Inserisci il numero di Decessi">
      </div>
      <div class="form-group">
        <label for="tamponi">Tamponi</label>
        <input class="form-control form-control-lg" type="text" id="tamponi" name="tamponi" placeholder="Inserisci il numero di Tamponi">
      </div>
      <input type="submit" class="btn btn-outline-success btn-lg btn-block" value="Inserisci">
    </form>
  </div>




  <?php include "include/footer.php";
  ?>
</body>

</html>