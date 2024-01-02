<?php
    session_start();
    $connessione=@mysqli_connect("localhost","root","","covid19");
    if (mysqli_connect_errno()){
        echo "Errore nella Connessione al Database.".die (mysqli_connect_error());
    }
    $_SESSION['data']=$_POST['data'];
    $_SESSION['positivi']=$_POST['positivi'];
    $_SESSION['dimessi']=$_POST['dimessi'];
    $_SESSION['decessi']=$_POST['decessi'];
    $_SESSION['tamponi']=$_POST['tamponi'];
    $query="insert into registri(token,data,positivi,dimessi,decessi,tamponi)values(\"".$_SESSION['utente']."\",\"".$_SESSION['data']."\",\"".$_SESSION['positivi']."\",\"".$_SESSION['dimessi']."\",\"".$_SESSION['decessi']."\",\"".$_SESSION['tamponi']."\")";
    $result=mysqli_query($connessione,$query);
    header("location: ../Dashboard.php");
?>