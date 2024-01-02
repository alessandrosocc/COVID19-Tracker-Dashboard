<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
    session_start();
    $connessione=@mysqli_connect("localhost","root","","covid19");
    if (mysqli_connect_errno()){
        echo "Errore nella Connessione al Database.".die (mysqli_connect_error());
    }
    //Calcolo totale dei valori nei registri per homepage.totale
    $querytotal="select sum(positivi),sum(decessi),sum(dimessi),sum(tamponi) from registri";
    $querytotal_a=mysqli_query($connessione,$querytotal);
    $querytotal_b=mysqli_fetch_array($querytotal_a);
    //echo date("Y-m-d",strtotime( '-1 days' ));
    $row="select distinct data from registri order by data DESC";
    $row_a=mysqli_query($connessione,$row);
    //prende dai registri i dati in base all'ultima data e a scendere, li somma e li butta dentro totale
    
    while($row_b=mysqli_fetch_array($row_a)){
        $max="select sum(positivi),sum(decessi),sum(dimessi),sum(tamponi) from registri where data=\"".$row_b[0]."\""; // somma in base ultima data
        $_2=mysqli_query($connessione,$max);
        $_2a=mysqli_fetch_array($_2);
        $sum="insert into totale(contagiati,deceduti,dimessi,tamponi,data) values (".$_2a[0].",".$_2a[1].",".$_2a[2].",".$_2a[3].",\"".$row_b[0]."\");"; //inserisci record con somma dell'ultima data
        $_3=mysqli_query($connessione,$sum);
    }
    //Calcolo totale dei valori nei registri per homepage.totale
    $querytotal="select sum(registri.positivi),totale.dimessi,totale.deceduti,totale.tamponi from totale,registri where totale.data=(select max(data) from totale)";
    $querytotal_a=mysqli_query($connessione,$querytotal);
    $querytotal_b=mysqli_fetch_array($querytotal_a);
    //dati totali in base alla data per registro con regioni ecc
    $total="select contagiati, deceduti, dimessi, tamponi, data from totale order by data DESC";
    $total_a=mysqli_query($connessione,$total); 
?>

<html>

<head>
    <?php include "./include/header.php"; ?>
</head>

<body>

    <div class="container-fluid">
        <nav class="navbar navbar-light bg-light justify-content-center rounded-lg border">
            <a class="navbar-brand" href="LoginRegister.php">
                <img src="https://image.flaticon.com/icons/svg/2919/2919573.svg" width="30" height="30" loading="lazy">
            </a>
        </nav>
    </div>
    <div class="container-fluid">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong> <a href="gdpr.php" class="alert-link ">Regolamento per il trattamento dei dati UE
                    2016/679</a></strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    <!--Totale Casi, Dimessi, Contagiati-->
    <div class="container-fluid">
        <div class="jumbotron jumbotron rounded-lg border">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <h1 style="font-family: 'Open Sans', sans-serif;">Contagiati<div
                                class="alert alert-warning mt-3" role="alert">
                                <?php echo $querytotal_b[0];?>
                            </div>
                        </h1>
                    </div>
                    <div class="col">
                        <h1 style="font-family: 'Open Sans', sans-serif;">Dimessi<div class="alert alert-success mt-3"
                                role="alert">
                                <?php echo $querytotal_b[1];?>
                            </div>
                        </h1>
                    </div>
                    <div class="col">
                        <h1 style="font-family: 'Open Sans', sans-serif;">Deceduti<div class="alert alert-danger mt-3"
                                role="alert">
                                <?php echo $querytotal_b[2];?>
                        </h1>
                    </div>
                    <div class="col-4">
                        <h1 style="font-family: 'Open Sans', sans-serif;">Tamponi Eseguiti<div
                                class="alert alert-primary mt-3" role="alert">
                                <?php echo $querytotal_b[3];?>
                            </div>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Filtra totale risultati-->
    <div class="container-fluid col-4 justify-content-center border rounded-lg py-3 ">
        <form action="homepage.php" method="POST">
            <label for="filter">
                <h5 style="font-family: 'Open Sans', sans-serif;">Visualizza</h5>
            </label>
            <select class="custom-select mr-sm-2" name="filtra" id="filter">
                <option selected>Tutti</option>
                <option value="ultimo">Ultimo</option>
                <option value="week">Settimana</option>
                <option value="month">Mese</option>
            </select>
            <input type="submit" class="btn btn-outline-success btn-block" value="Filtra">
        </form>
    </div>
    <!--Dati totali al giorno -->
    <?php
    function regioni($data,$queryreg1,$connessione){        
        
        while($fetchqueryreg=mysqli_fetch_array($queryreg1))
        {
            echo "
            <tr>
                <th>".$fetchqueryreg[1]."</th>
                <td>".$fetchqueryreg[3]."</td>
                <td>".$fetchqueryreg[2]."</td>
                <td>".$fetchqueryreg[4]."</td>
                <td>".$fetchqueryreg[5]."</td>
            </tr>
            ";
        }
    }

    //dati totali in base alla data per registro con regioni ecc
    $total="select contagiati, deceduti, dimessi, tamponi, data from totale order by data DESC";
    $total_a=mysqli_query($connessione,$total);
    //Filtra per Ultimo, Settimana o mese
    $filtra=$_POST['filtra'];
     if ($filtra=="ultimo"){
         $counter=1;
     }
     else if ($filtra=="week"){
        $counter=7;
    }
    else if ($filtra=="month"){
        $counter=30;
    }
        $k=0;
        while($total_b=mysqli_fetch_array($total_a))
        {
            $k++;
            $content="contenutonav".$k;
            $contagiati=$total_b[0];
            $deceduti=$total_b[1];
            $dimessi=$total_b[2];
            $tamponi=$total_b[3];
            $data=$total_b[4];  
        echo 
        "
            <div class=\"container-fluid mt-3\">
                <nav class=\"navbar navbar-light bg-light rounded-lg border\">
                    <h2 style=\"font-family: 'Open Sans', sans-serif;\">Positivi</h2>
                        <h5 class=\"text-warning\">".$contagiati."</h5>

                    <h2 style=\"font-family: 'Open Sans', sans-serif;\">Dimessi</h2>
                        <h5 class=\"text-success\">".$dimessi."</h5>
                    <h2 style=\"font-family: 'Open Sans', sans-serif;\">Deceduti</h2>
                        <h5 class=\"text-danger\">".$deceduti."</h5>
                    
                    <h2 style=\"font-family: 'Open Sans', sans-serif;\">Tamponi Eseguiti</h2>
                        <h5 class=\"text-primary\">".$tamponi."</h5>
                    <h2 style=\"font-family: 'Open Sans', sans-serif;\">Data</h2>
                        <h5 class=\"text-secondary\">".$data."</h5>
                    <button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#".$content."\"
                        aria-controls=\"contenutonav\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
                        <img src=\"https://image.flaticon.com/icons/svg/318/318426.svg\" width=\"30\" height=\"30\">
                    </button>
                </nav>
            </div>
    <div class=\"container-fluid\">
        <div class=\"collapse\" id=\"".$content."\">
        <div class=\"bg-light border-bottom border-right border-left rounded-bottom\">
            <table class=\"table table-bordered-lg text-center\">
                <thead>
                    <tr>
                        <th scope=\"col\">Regione</th>
                        <th scope=\"col\">Positivi</th>
                        <th scope=\"col\">Dimessi</th>
                        <th scope=\"col\">Deceduti</th>
                        <th scope=\"col\">Tamponi Eseguiti</th>
                    </tr>
                </thead>
                <tbody>
                ";
        $queryreg="select registri.data,istituzioni.regione, sum(positivi),sum(decessi),sum(dimessi),sum(tamponi) from registri,istituzioni where istituzioni.token=registri.token and registri.data=\"".$data."\" group by istituzioni.regione order by registri.data DESC"; 
        $queryreg1=mysqli_query($connessione,$queryreg);
        while($fetchqueryreg=mysqli_fetch_array($queryreg1))
        {
            echo "
            <tr>
                <th><span class=\"badge badge-secondary\">".$fetchqueryreg[1]."</span></th>
                <td><span class=\"badge badge-warning\">".$fetchqueryreg[3]."</span></td>
                <td><span class=\"badge badge-success\">".$fetchqueryreg[2]."</span></td>
                <td><span class=\"badge badge-danger\">".$fetchqueryreg[4]."</span></td>
                <td><span class=\"badge badge-primary\">".$fetchqueryreg[5]."</span></td>
            </tr>
            ";
        }
        regioni($data,$queryreg1,$connessione);
               echo "
                </tbody>
            </table>
        </div>
    </div>
</div>
    ";
    if ($k==$counter){ //in base alla scelta del filtro esce dal ciclo.
    break; //exit(-1);
    }
            }

?>
    <?php include "include/footer.php";?>
    <script>
    if (screen.width <= 900) {
     document.location = "mobile.php";
}
</script>
</body>

</html>