<?php
$connessione=@mysqli_connect("localhost","root","","covid19");
if (mysqli_connect_errno()){
    echo "Errore nella Connessione al Database.".die (mysqli_connect_error());
}
//Inserimento Account e Istituzioni di tutte le regioni con comuni ad ogni aggiornamento dei dati giornalieri
$data=file_get_contents("https://raw.githubusercontent.com/pcm-dpc/COVID-19/master/dati-json/dpc-covid19-ita-province-latest.json");
$decode=json_decode($data,true);
echo count($decode)."<br>";
echo $decode[99]['denominazione_regione'];

function calctoken() { 
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
    $randomString = ''; 
  
    for ($i = 0; $i < 20; $i++) { 
        $index = rand(0, strlen($characters) - 1); 
        $randomString .= $characters[$index]; 
    } 
  
    return $randomString; 
} 
$password="test";
$attivo="true";
$struttura="ospedale";
$ruolo="user";
for ($i=0;$i<count($decode);$i++){
    $token=strtolower(calctoken());
    $account="insert into account(token,password,attivo,ruolo)values(\"".$token."\",\"".hash("sha512",$password)."\",".$attivo.",\"".$ruolo."\")";
    $istituzioni="insert into istituzioni(regione,nome,struttura,citta,token)values(\"".$decode[$i]['denominazione_regione']."\",\"NOME".$i."\",\"".$struttura."\",\"".$decode[$i]['denominazione_provincia']."\",\"".$token."\")";
    if ($decode[$i]['denominazione_regione'] && $decode[$i]['denominazione_provincia']=="In fase di definizione/aggiornamento"){
        
    }
    else{
        mysqli_query($connessione,$account);
        mysqli_query($connessione,$istituzioni);
    }
}
//Fine

?>