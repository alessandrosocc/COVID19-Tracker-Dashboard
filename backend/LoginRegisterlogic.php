<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
$connessione=@mysqli_connect("localhost","root","","covid19");
if (mysqli_connect_errno()){
    echo "Errore nella Connessione al Database.".die (mysqli_connect_error());
}
//Aggiornamento Accessi
$ip=file_get_contents("https://ipecho.net/plain");
$u2="delete from accessi where token=\"".$_SESSION['utente']."\"";
$u="insert into accessi(token,data,ora,ip)values(\"".$_SESSION['utente']."\",\"".date("Y-m-d")."\",\"".date("H:i")."\",\"".$ip."\")";
$result=mysqli_query($connessione,$u2);
$result=mysqli_query($connessione,$u);

    $_SESSION['utente']=$_POST['inputtoken'];
    $_SESSION['passwd']=$_POST['inputpassword'];
    $checklogin="select account.token,istituzioni.nome, account.ruolo,account.password,account.attivo,istituzioni.citta, istituzioni.struttura from account,istituzioni where account.token=istituzioni.token and account.token=\"".$_SESSION['utente']."\"";
    $result=@mysqli_query($connessione,$checklogin);
    $fetch=@mysqli_fetch_array($result);
    if ($fetch['token']==$_SESSION['utente']&&$fetch['password']==hash("sha512",$_SESSION['passwd'])){
        if ($fetch['ruolo']=="admin"){
            header("location: ../ammDashboard.php");
            

        }
        else if ($fetch['ruolo']=="user" && $fetch['attivo']==true){
            header("location: ../Dashboard.php");
            
        }
        else{
            header("location: ../LoginRegister.php");
            
        }
        
    }
    else{
        header("location: ../LoginRegister.php"); 
        
    }

//Registrazione

    $_SESSION['token']=$_POST['token'];
    $_SESSION['nome']=$_POST['inputistituzione'];
    $_SESSION['citta']=$_POST['inputcitta'];
    $_SESSION['regione']=$_POST['inputregione'];
    $_SESSION['struttura']=$_POST['inputstruttura'];
    $_SESSION['password']=$_POST['inputpasswordreg'];
    $_SESSION['confpassword']=$_POST['inputconfpasswordreg'];
    if (hash("sha512",$_SESSION['password'])!=hash("sha512",$_SESSION['confpassword']))
    {
        header("location: ../LoginRegister.php");
    }
    else
    {
    $registrazione="insert into account(token,password,attivo,ruolo) values(\"".$_SESSION['token']."\",\"".hash("sha512",$_SESSION['password'])."\",0,\"user\")";
    $registrazione1="insert into istituzioni(token,nome,citta,regione,struttura) values(\"".$_SESSION['token']."\",\"".$_SESSION['nome']."\",\"".$_SESSION['citta']."\",\"".$_SESSION['regione']."\",\"".$_SESSION['struttura']."\")";
    $resultreg=@mysqli_query($connessione,$registrazione);
    $resultreg=@mysqli_query($connessione,$registrazione1);
    }   

