<?php
 error_reporting(E_ERROR | E_WARNING | E_PARSE);
session_start();
if (!$_SESSION['utente']){
    header("location: LoginRegister.php");
}
                            $connessione=@mysqli_connect("localhost","root","","covid19");
                            if (mysqli_connect_errno()){
                                echo "Errore nella Connessione al Database.".die (mysqli_connect_error());
                            }


                            //Ultimo accesso registrato {data ip ora}
                            $lasthourdateip="select ora, data, ip from accessi where token=\"".$_SESSION['utente']."\"";
                            $lasth=mysqli_query($connessione,$lasthourdateip);
                            $fetchlast=mysqli_fetch_array($lasth);
                            //Per aggiungere utenti
                            function calctoken() { 
                                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                                $randomstring="";   
                                for ($i = 0; $i < 20; $i++) { 
                                    $index = rand(0, strlen($characters) - 1); 
                                    $randomString .= $characters[$index]; 
                                } 
                                return $randomString; 
                            } 
                            

?>
<html>

<head>
    <?php include "include/header.php";?>
</head>

<body>
    <div class="container-fluid">
        <nav class="navbar navbar-light bg-light justify-content-center border rounded-lg">
            <a class="navbar-brand align-left" href="Homepage.php">Home</a>
            <a class="navbar-brand">Benvenuto => <?php echo $_SESSION['utente'];?> <= Amministratore</a> </nav> </div>
                    <div class="container-fluid">
                    <div class="alert alert-danger text-center" role="alert">
                        Ultimo accesso Il <?php echo $fetchlast[1];?> Ore <?php echo $fetchlast[0];?> IP:
                        <?php echo $fetchlast[2]; ?>
                    </div>
    </div>
    <!--Navbar fatta di container con "Accettazione" e "Log" solo scritte-->
    <div class="container-fluid">
        <div class="container-fluid col-4 float-right border rounded-lg">
            <h1 style="font-family: 'Open Sans', sans-serif;" class="text-center py-2">Log</h1>
        </div>
        <div class="container-fluid col-8 float-left border rounded-lg">
            <h1 style="font-family: 'Open Sans', sans-serif;" class="text-center py-2">Accettazione</h1>
        </div>
    </div>
    <!--Dati e tabella Accettazione-->
    <div class="container-fluid">
        <div class="col-8 float-left border rounded-lg" style="overflow-y:scroll; height:50%;">
            <table class="table table-striped table-hover ">
                <thead>
                    <tr>
                        <th scope="col">Token</th>
                        <th scope="col">Regione</th>
                        <th scope="col">Struttura</th>
                        <th scope="col">Citta</th>
                        <th scope="col">Nome</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        
                         $connessione=@mysqli_connect("localhost","root","","covid19");
                         if (mysqli_connect_errno()){
                             echo "Errore nella Connessione al Database.".die (mysqli_connect_error());
                         }
                          $query="select account.token, regione,struttura,citta,nome from istituzioni,account where istituzioni.token=account.token and account.attivo=0";
                         $result=mysqli_query($connessione,$query);                      
                        while ($res=mysqli_fetch_array($result)){
                            $token=$res[0];
                            $regione=$res[1];
                            $struttura=$res[2];
                            $citta=$res[3];
                            $nome=$res[4];
                            echo 
                            "
                            <tr>
                                <th>".$token."</th>
                                <td>".$regione."</td>
                                <td>".$struttura."</td>
                                <td>".$citta."</td>
                                <td>".$nome."</td>
                                <td>
                                <form action=\"backend/ammDashboardlogic.php\" method=\"POST\">
                                <input type=\"hidden\" name=\"accept\">
                                <input type=\"submit\" class=\"btn btn-outline-success\" value=\"Accetta\" name=\"accetta\"><input type=\"hidden\" name=\"token\" value=\"".$token."\">
                                </form>
                                <form action=\"backend/ammDashboardlogic.php\" method=\"POST\"><input type=\"submit\" class=\"btn btn-outline-danger\" value=\"Rifiuta\" name=\"rifiuta\">
                                <input type=\"hidden\" name=\"deny\">
                                <input type=\"hidden\" name=\"token\" value=\"".$token."\">
                                </form>
                                </td>
                            </tr> 
                            ";
                        }  
                    ?>
                </tbody>
            </table>
        </div>

    </div>
    <!--Log-->

    <div class="container-fluid">
        <div class="col-4 float-right border rounded-lg" style="overflow-y:scroll; height:50%;">
            <!--Inserisci Log-->
            <?php
                    $var=file("C:\\xampp\\apache\\logs\\access.log");
                    $rev=array_reverse($var);
                    for ($i=0;$i<1000;$i++){
                        echo $rev[$i]."<br><br>";
                    }
                ?>
        </div>
        <div class="container-fluid">
            <div class="col-4 float-right border rounded-lg" style="overflow-y:scroll; height:50%;">
                <div class="container-fluid col-4">
                    <h1 style="font-family: 'Open Sans', sans-serif;" class="text-center py-2">Accessi</h1>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Identificativo</th>
                            <th scope="col">Data</th>
                            <th scope="col">Ora</th>
                            <th scope="col">Ip</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $connessione=@mysqli_connect("localhost","root","","covid19");
                            if (mysqli_connect_errno()){
                                echo "Errore nella Connessione al Database.".die (mysqli_connect_error());
                            }
                            $query="select token,data,ora,ip from accessi";
                            $result=mysqli_query($connessione,$query);
                            $resAccessi=mysqli_fetch_array($result);
                            while ($resAccessi=mysqli_fetch_array($result)){
                                $token=$resAccessi[0];
                                $data=$resAccessi[1];
                                $ora=$resAccessi[2];
                                $ip=$resAccessi[3];
                                echo 
                                "
                                <tr>
                                    <th scope=\"row\">".$token."</th>
                                    <td>".$data."</td>
                                    <td>".$ora."</td>
                                    <td>".$ip."</td>
                                </tr> 
                                ";
                            }  
                                        
                                        
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
        <div class="container-fluid justify-content-center">
            <div class="row"></div>
            <div class="col-8 border float-left rounded-lg">

                <div class="col-4 float-left">
                    <div class="container-fluid">
                        <h1 style="font-family: 'Open Sans', sans-serif;" class="text-center py-2">Aggiungi Utenti</h1>
                    </div>
                    <form action="backend/ammDashboardlogic.php" method="POST">
                        <div class="form-group row px-3">
                            <label for="prepend">Token</label>
                            <div class="col">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                        id="prepend"><?php $add=strtolower(calctoken()); echo $add;?></span>
                                </div>
                            </div>
                            <input type="hidden" class="form-control" value=<?php echo "\"".$add."\"";?> name="add">
                        </div>
                        <div class="form-group row px-3">
                            <label for="nome">Nome</label>
                            <div class="col">
                                <input type="text" class="form-control" id="nome" placeholder="Inserisci il Nome"
                                    name="nome">
                            </div>
                        </div>
                        <div class="form-group row px-3">
                            <label for="regione">Regione</label>
                            <div class="col">
                                <input type="text" class="form-control" id="regione" placeholder="Inserisci Regione"
                                    name="regione">
                            </div>
                        </div>
                        <div class="form-group row px-3">
                            <label for="citta">Citta</label>
                            <div class="col">
                                <input type="text" class="form-control" id="citta" placeholder="Inserisci Citta"
                                    name="citta">
                            </div>
                        </div>
                        <div class="form-group row px-3">
                            <label for="struttura">Struttura</label>
                            <div class="col">
                            <select class="form-control"
                                name="struttura" id="struttura">
                                <option value="ospedale">Ospedale</option>
                                <option value="comune">Comune</option>
                                <option value="protezionecivile">Protezione Civile</option>
                                <option value="entegenerico">Ente Generico</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group row px-3">
                            <label for="ruolo">Ruolo</label>
                            <div class="col">
                            <select class="form-control"
                                name="ruolo" id="ruolo">
                                <option value="admin">Amministratore</option>
                                <option value="user">Utente</option>
                            </select>
                            </div>
                        </div>
                        <div class="form-group row px-3">
                            <label for="pswd">Password</label>
                            <div class="col">
                                <input type="password" class="form-control" id="pswd" placeholder="Inserisci Password"
                                    name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-outline-success btn-block" value="Crea" name="crea">
                        </div>
                    </form>
                </div>
                <div class="col-4 float-right">
                    <div class="container-fluid">
                        <h1 style="font-family: 'Open Sans', sans-serif;" class="text-center py-2">Elimina Utenti</h1>
                    </div>
                    <form action="backend/ammDashboardlogic.php" method="POST">
                        <div class="form-group row px-3">
                            <label for="tokendel">Token</label>
                            <div class="col">
                                <input type="text" class="form-control" id="tokendel" name="del"
                                    placeholder="Token Account">
                            </div>
                        </div>
                        <input type="submit" class="btn btn-outline-danger btn-block" value="Elimina">
                    </form>
                </div>
            </div>
        </div>
    </div>




    <?php include "include/footer.php";?>
</body>

</html>