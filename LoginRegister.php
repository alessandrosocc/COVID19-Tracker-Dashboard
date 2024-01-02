<html>

<head>
    <?php include "include/header.php";?>
</head>

<body>
    <div class="container-fluid">
        <div class="container-fluid col-sm-4 border rounded-lg bg-light">
            <nav class="navbar navbar-light bg-light justify-content-center">
                <a class="navbar-brand" href="Homepage.php">
                    <img src="https://image.flaticon.com/icons/svg/2948/2948025.svg" width="30" height="30" alt="">
                </a>
            </nav>
        </div>
        <div class="container-fluid col-sm-4 py-4 border rounded-lg bg-light">
            <div class="alert alert-danger text-center" role="alert">
                Il tuo indirizzo IP <?php echo file_get_contents("https://ipecho.net/plain");?> verrà registrato
            </div>
            <div class="alert alert-danger text-center" role="alert">
                Area Riservata
            </div>

            <form method="POST" action="backend/LoginRegisterlogic.php" id="login">
                <input type="hidden" name="login">
                <div class="form-group">
                    <label for="inputemail">Token di Accesso</label>
                    <input type="text" class="form-control form-control-lg" id="inputtoken" name="inputtoken"
                        placeholder="Inserisci il token" style="border-radius:15px;" name="identificativo" required
                        autofocus>
                </div>
                <div class="form-group">
                    <label for="inputpassword">Password</label>
                    <input type="password" class="form-control form-control-lg" id="inputpassword" name="inputpassword"
                        placeholder="Password" style="border-radius:15px;" name="password" required>
                </div>
                <input type="submit" class="btn btn-primary btn-block btn-lg shadow-none mt-2"
                    style="border-radius:15px;" value="Accedi" onclick="token()">
                <div class="text-center my-2">
                    <button type="button" class="btn btn-outline-primary btn-sm mx-auto" id="reg">Registrati</button>
                </div>
            </form>

            <form method="POST" action="backend/LoginRegisterlogic.php" id="registrazione">
                <input type="hidden" name="token" value="<?php 
                error_reporting(E_ERROR | E_WARNING | E_PARSE);
                function calctoken() { 
                    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                    for ($i = 0; $i < 20; $i++) { 
                        $index = rand(0, strlen($characters) - 1); 
                        $randomString .= $characters[$index]; 
                    } 
                    return $randomString; 
                } 
                echo strtolower(calctoken());
            $token=strtolower(calctoken());
             
            ?>">
                <div class="form-group">
                    <label for="inputemail">Nome Istituzione</label>
                    <input type="nome" class="form-control form-control-lg" id="istituzione"
                        placeholder="Nome completo dell'istituzione" style="border-radius:15px;" name="inputistituzione"
                        required autofocus>
                </div>
                <div class="form-group">
                    <label for="inputcitta">Città</label>
                    <input type="text" class="form-control form-control-lg" id="inputcitta"
                        placeholder="Nome della Città" style="border-radius:15px;" name="inputcitta" required>
                </div>
                <div class="form-group">
                    <label for="inputregione">Regione</label>
                    <input type="text" class="form-control form-control-lg" id="inputregione"
                        placeholder="Nome della Regione" style="border-radius:15px;" name="inputregione" required>
                </div>
                <div class="form-group">
                    <label for="inputstruttura">Struttura</label>
                    <select class="form-control form-control-lg" style="border-radius:15px;" name="inputstruttura"
                        id="inputstruttura">
                        <option value="ospedale">Ospedale</option>
                        <option value="comune">Comune</option>
                        <option value="protezionecivile">Protezione Civile</option>
                        <option value="entegenerico">Ente Generico</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputpassword">Password</label>
                    <input type="password" class="form-control form-control-lg" id="inputpasswordreg"
                        placeholder="Password" style="border-radius:15px;" name="inputpasswordreg" required>
                </div>
                <div class="form-group">
                    <label for="inputpassword">Conferma Password</label>
                    <input type="password" class="form-control form-control-lg" id="inputconfpasswordreg"
                        placeholder="Conferma Password" style="border-radius:15px;" name="inputconfpasswordreg"
                        required>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox mr-sm-2">
                        <input type="checkbox" class="custom-control-input" id="acceptgdpr" required>
                        <label class="custom-control-label" for="acceptgdpr">Confermo la visione e ACCETTO il
                            trattamento dei dati secondo questo documento <a href="gdpr.php"
                                class="text-warning">GDPR</a></label>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary btn-block btn-lg shadow-none mt-2"
                    style="border-radius:15px;" value="Registrati" onclick="validate()" id="fortoken">
                <div class="text-center my-2">
                    <button type="button" class="btn btn-outline-primary btn-sm mx-auto" id="log">Accedi</button>
                </div>
            </form>

        </div>
    </div>
    <?php include "include/footer.php";?>
    <script>
    
        var login = document.getElementById(" login");
        var registrazione = document.getElementById("registrazione");
        registrazione.style.display = "none";
        $(document).ready(function () {
            $("#log").click(function () {
                $("#login").toggle();
                $("#registrazione").hide();
            });
            $("#reg").click(function () {
                $("#registrazione").toggle();
                $("#login").hide();
            });
        });
        
            
                

        function validate() {
            var gdpr=document.getElementById("acceptgdpr").checked;
            var citta = document.getElementById("inputcitta");
            var regione = document.getElementById("inputregione");
            var struttura = document.getElementById("inputstruttura");
            var istituzione = document.getElementById("inputistituzione");
            var password = document.getElementById("inputpasswordreg").value;
            var confirmPassword = document.getElementById("inputconfpasswordreg").value;
            if (password == "" && confirmpassword == "") {
                exit();
            } else if (password != confirmPassword) {
                alert("Le password non corrispondono!");
                location.reload();
            }
            else if(citta!="" && regione!=""&&struttura!=""&&istituzione!=""&&gdpr!=false){
                alert("Custodisci questo codice che dovrà essere inviato all'istituzione di competenza al momento dell'approvazione dell'account \n\n <?php echo $token;?>");
            }
                            
        }
    </script>
</body>

</html>