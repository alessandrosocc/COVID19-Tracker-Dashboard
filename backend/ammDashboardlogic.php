<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
$connessione=@mysqli_connect("localhost","root","","covid19");
if (mysqli_connect_errno()){
    echo "Errore nella Connessione al Database.".die (mysqli_connect_error());
}

$querydeny="delete from istituzioni WHERE token=\"".$_POST['token']."\"";
$querydeny2="delete from account where token=\"".$_POST['token']."\"";
if ($_POST['deny']){
    $exec=mysqli_query($connessione,$querydeny);
    $exec=mysqli_query($connessione,$querydeny2);
}
else{
    mysqli_query($connessione,"update account set attivo=\"1\" where token=\"".$_POST['token']."\"");
}
header("location: ../ammDashboard.php");

//aggiungi utente
$pswd=$_POST['password'];
$ruolo=$_POST['ruolo'];
$nome=$_POST['nome'];
$citta=$_POST['ciita'];
$regione=$_POST['regione'];
if ($_POST['add']&&$pswd!=""){

    $registrazione="insert into account(token,password,attivo,ruolo) values(\"".$_POST['add']."\",\"".hash("sha512",$pswd)."\",true,\"".$ruolo."\")";
    $registrazione1="insert into istituzioni(token,nome,citta,regione,struttura) values(\"".$_POST['add']."\",\"".$nome."\",\"".$citta."\",\"".$regione."\",\"".$struttura."\")";
    $resultreg=@mysqli_query($connessione,$registrazione);
    $resultreg=@mysqli_query($connessione,$registrazione1);
    /*
    $sql="insert into account(token,password,ruolo,attivo)value(\"".$_POST['add']."\",\"".hash("sha512",$pswd)."\",\"admin\",true)";
    mysqli_query($connessione,$sql);
    */
}
if ($_POST['del']){
 $sql1="delete from accessi where token=\"".$_POST['del']."\"";
 $sql2="delete from account where token=\"".$_POST['del']."\"";
 $sql3="delete from istituzioni where token=\"".$_POST['del']."\"";
mysqli_query($connessione,$sql1);
 mysqli_query($connessione,$sql2);
 mysqli_query($connessione,$sql3);
}