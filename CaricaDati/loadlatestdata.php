<?php
$connessione=@mysqli_connect("localhost","root","","covid19");
if (mysqli_connect_errno()){
    echo "Errore nella Connessione al Database.".die (mysqli_connect_error());
}
$totale=file_get_contents("https://raw.githubusercontent.com/pcm-dpc/COVID-19/master/dati-json/dpc-covid19-ita-regioni.json");
$decode=json_decode($totale,true);
$counter= count($decode);

for ($i=0;$i<$counter;$i++){
$data=substr($decode[$i]['data'],0,10);     
$j=$i;
$sql="select token from istituzioni where regione=\"".$decode[$i]['denominazione_regione']."\"";
$final=mysqli_query($connessione,$sql);
$token=mysqli_fetch_array($final);
echo $data." ".$token[0]." ".$decode[$i]['nuovi_positivi']." ".$decode[$i]['dimessi_guariti']." ".$decode[$i]['deceduti']." ".$decode[$i]['casi_testati'];
$query="insert into registri(token, data, positivi, dimessi, decessi, tamponi)values(\"".$token[0]."\",\"".$data."\",".$decode[$i]['nuovi_positivi'].",".$decode[$i]['dimessi_guariti'].",".$decode[$i]['deceduti'].",".$decode[$i]['tamponi'].")";
mysqli_query($connessione,$query);
}