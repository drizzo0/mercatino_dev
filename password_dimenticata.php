<?php
    include 'header.php';
    ?> <title>Password dimenticata</title> <?php
    if($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST['recupera'])){
            $codiceRecupero = $_POST['codiceRecupero'];
            echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'password_dimenticata.php?codice='.$codiceRecupero.'">';
        }elseif(isset($_POST['richiedi'])){
            $email = $_POST['email'];
            $utente = $sql->query("SELECT idUtente, nome, cognome FROM utenti WHERE email = '$email'");
            if($utente->num_rows==0){
                $_SESSION['tmpPWlostErr'] = "L'indirizzo email inserito non esiste.";
                echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'password_dimenticata.php">';
            }else{
                $utente = $utente->fetch_array();
                $idUtente = $utente['idUtente'];
                $nome = $utente['nome'];
                $cognome = $utente['cognome'];
                $codiceRecupero = $Core->requestRandomCode();
                $sql->query("INSERT INTO recupero_password_temp (idUtente, codiceRecupero) VALUES ('$idUtente', '$codiceRecupero')");
                if($sql->error){
                    die($sql->error);
                }
                $Mail->addAddress($email, $nome.' '.$cognome);
                $Mail->Subject = 'Recupera la tua password!';
                $Mail->Body = '<center>Ciao '.$nome.' '.$cognome.',<br>per recuperare la password clicca <a href="'.$siteURL.'password_dimenticata.php?codice='.$codiceRecupero.'">qui</a>.<br><br>Se il link non dovesse funzionare visita '.$siteURL.'password_dimenticata.php?codice e inserisci: '.$codiceRecupero.' come codice di recupero.</center>';
                $Mail->send();
                $_SESSION['tmpPWlostErr'] = "Codice di recupero inviato con successo.";
                echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'password_dimenticata.php?codice">';
            }
        }elseif (isset($_POST['modifica'])){
            $idUtente = $_SESSION['tmpUserIDCambioPW'];
            $codiceRecupero = $_SESSION['tmpCodiceCambioPW'];
            $nuovaPassword = $_POST['nuovaPW'];
            $confermaPassword = $_POST['confermaPW'];

            $verificaCodice = $sql->query("SELECT * FROM recupero_password_temp WHERE idUtente='$idUtente' AND codiceRecupero='$codiceRecupero'");
            if ($verificaCodice->num_rows==0){
                $_SESSION['tmpPWlostErr'] = "Codice di recupero non valido!";
                echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'password_dimenticata.php?codice">';
            }else{
                if($nuovaPassword!==$confermaPassword){
                    $codiceRecupero = $_POST['codiceRecupero'];
                    $_SESSION['tmpPWlostErr'] = "Le password non coincidono!";
                    echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'password_dimenticata.php?codice='.$codiceRecupero.'">';
                }else{
                    $nuovaPassword = $Core->encryptPassword($nuovaPassword);
                    $sql->query("UPDATE utenti SET password='$nuovaPassword' WHERE idUtente='$idUtente'");
                    if($sql->error){
                        die($sql->error);
                    }
                    $sql->query("DELETE FROM recupero_password_temp WHERE codiceRecupero = '$codiceRecupero'");
                    if($sql->error){
                        die($sql->error);
                    }
                    $_SESSION['giaRegErroreTemp'] = 'Password modificata!<br>Adesso puoi accedere.';
                    echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'accedi.php">';
                    header("location: accedi.php");
                }
            }

        }
    }else{
        if(isset($_GET['codice'])){
            if(trim($_GET['codice'])==''){
                ?>
                <body class="align-content-center">
                    <div class="container rounded">
                        <div class="card rounded py-2 col-md-6">
                            <div class="card-header">
                                Recupera la tua password!<br>
                                <?php if(isset($_SESSION['tmpPWlostErr'])){ echo $_SESSION['tmpPWlostErr']; $_SESSION['tmpPWlostErr']=''; } ?>
                            </div>
                            <div class="card-body">
                                <form method="post" action="password_dimenticata.php">
                                    <label for="codiceRecupero">Codice:</label>
                                    <input class="form-control" type="text" name="codiceRecupero" id="codiceRecupero">
                                    <input class="form-control" type="submit" name="recupera" value="Recupera password!">
                                </form>
                            </div>
                        </div>
                    </div>
                </body>
                <?php
            }else{
                $codiceRecupero = $_GET['codice'];
                $idUtente = $sql->query("SELECT idUtente FROM recupero_password_temp WHERE codiceRecupero='$codiceRecupero'");
                if($idUtente->num_rows==0){
                    $_SESSION['tmpPWlostErr'] = "Codice di recupero non valido!";
                    echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'password_dimenticata.php?codice">';
                }else{
                    $idUtente = $idUtente->fetch_array();
                    $_SESSION['tmpUserIDCambioPW'] = $idUtente['idUtente'];
                    $_SESSION['tmpCodiceCambioPW'] = $codiceRecupero;
                    ?>
                    <body class="align-content-center">
                        <div class="container rounded">
                            <div class="card rounded py-2 col-md-6">
                                <div class="card-header">
                                    Recupera la tua password!<br>
                                    <?php if(isset($_SESSION['tmpPWlostErr'])){ echo $_SESSION['tmpPWlostErr']; $_SESSION['tmpPWlostErr']=''; } ?>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="password_dimenticata.php">
                                        <label for="nuovaPW">Nuova Password:</label>
                                        <input class="form-control" type="password" name="nuovaPW" id="nuovaPW">
                                        <label for="confermaPW">Conferma Password:</label>
                                        <input class="form-control" type="password" name="confermaPW" id="confermaPW">
                                        <input class="form-control" type="submit" name="modifica" value="Modifica password!">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </body>

                    <?php
                }

            }

        }else{
            ?>
            <body class="align-content-center">
                <div class="container rounded">
                    <div class="card rounded py-2 col-md-6">
                        <div class="card-header">
                            Recupera la tua password!<br>
                            <?php if(isset($_SESSION['tmpPWlostErr'])){ echo $_SESSION['tmpPWlostErr']; $_SESSION['tmpPWlostErr']=''; } ?>
                        </div>
                        <div class="card-body">
                            <form method="post" action="password_dimenticata.php">
                                <label for="email">Email:</label>
                                <input class="form-control" type="email" name="email" id="email">
                                <input class="form-control" type="submit" name="richiedi" value="Richiedi codice!">
                            </form>
                        </div>
                    </div>
                </div>
            </body>
            <?php
        }
    }

    include 'footer.php';