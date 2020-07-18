<?php

    include "header.php";

    if($_SESSION['impostazioni']['richiediConfermaRegistrazione']==0){
        $abilitato = 1;
    }else{
        $abilitato = 0;
    }

    if($_SERVER['REQUEST_METHOD']=='POST'){
        //match post with local variables
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confermaPassword = $_POST['conferma_password'];
        $email = $_POST['email'];
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];

        $dataRegistrazione = date('Y-m-d H:i:s');
        $dataUltimoAccesso = '1970-01-01 00:00:01';
        $ipRegistrazione = $Core->getUserIpAddr();
        $ipUltimoAccesso = '0.0.0.0';

        //pw check
        if($password!==$confermaPassword){
            $_SESSION['regPswDiverse'] = "Le password sono diverse.";
            $_SESSION['tmpUsr'] = $_POST['username'];
            $_SESSION['tmpMail'] = $_POST['email'];
            $_SESSION['tmpNome'] = $_POST['nome'];
            $_SESSION['tmpCognome'] = $_POST['cognome'];
            echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'registrati.php">';
        }else {
            //controlla se utente è già registrato
            $query = "SELECT * FROM utenti WHERE username='$username' OR email='$email'";
            $risultatoUtente = $sql->query($query);
            if ($risultatoUtente->num_rows > 0) {
                $utente = $risultatoUtente->fetch_array();
                if ($utente['abilitato'] == 1) {
                    $_SESSION['giaRegErroreTemp'] = "Nome utente o email già registrati, accedi.";
                    $_SESSION['tmpUsr'] = $_POST['username'];
                    echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'accedi.php">';
                } else {
                    $_SESSION['giaRegErroreTemp'] = "Nome utente o email già registrati, verifica il tuo account.";
                    echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'abilita.php">';
                }
            } else {
                $Core->encryptPassword($password);
                $query = "INSERT INTO utenti (username, password, lunghezzaPassword, email, nome, cognome, dataRegistrazione, dataUltimoAccess, ipRegistrazione, ipUltimoAccesso, abilitato) VALUES ('$username', '$password', '$passwordLength', '$email', '$nome', '$cognome', '$dataRegistrazione', '$dataUltimoAccesso', '$ipRegistrazione', '$ipUltimoAccesso', '$abilitato')";
                $sql->query($query);
                $errore = $sql->error;
                if ($errore) {
                    die($errore);
                } else {
                    $idRuoloUtente = $_SESSION['impostazioni']['ruoloUtente'];
                    $user = $sql->query("SELECT * FROM utenti WHERE username = '$username'")->fetch_array();
                    $utente = $user;
                    $user = $user['idUtente'];
                    $sql->query("INSERT INTO ruoliUtente (idUtente, idRuolo) VALUES ('$user', '$idRuoloUtente')");

                    if($abilitato==0){

                        $codiceConferma = $Core->requestRandomCode();
                        $sql->query("INSERT INTO utenti_temp (idUtente, codiceConferma) VALUES ('$user', '$codiceConferma')");
                        if($sql->error){
                            die($sql->error);
                        }

                        $Mail->addAddress($email, $nome.' '.$cognome);
                        $Mail->isHTML(true);                                  // Set email format to HTML
                        $Mail->Subject = $_SESSION['impostazioni']['mailOggettoVerifica'];
                        $Mail->Body    = '<center>Benvenuto, verifica il tuo account, per verificarlo clicca <a href="'.$siteURL.'abilita.php?codice='.$codiceConferma.'">qui</a>.<br>Se il link non dovesse funzionare visita: '.$siteURL.'abilita.php e inserisci '.$codiceConferma.' come codice di conferma.';
                        $Mail->send();
                        $Core->userLogs($utente,'Registrazione','Ok');
                        echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'abilita.php">';
                    }else{
                        $Mail->addAddress($email, $nome.' '.$cognome);
                        $Mail->Subject = $_SESSION['impostazioni']['mailOggettoBenvenuto'];
                        $Mail->Body    = '<center>Benvenuto!<br>Accedi cliccando <a href="'.$siteURL.'accedi.php">qui</a>. </center>';
                        $Mail->send();
                        $Core->userLogs($utente,'Registrazione','Ok');
                        echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'accedi.php">';
                    }
                }
            }
        }


    }else{ ?>

        <title><?php echo $_SESSION['impostazioni']['titoloPaginaRegistrazione']; ?></title>

        <body>
            <div class="container col-md-auto py-2 text-center align-content-center">
                <div class="card rounded">
                    <div class="card-header">
                        <h1><?php echo $_SESSION['impostazioni']['titoloPaginaRegistrazione']; ?></h1>
                        <?php if (isset($_SESSION['regPswDiverse'])){ echo $_SESSION['regPswDiverse']; $_SESSION['regPswDiverse']=''; } ?>
                    </div>
                    <div class="card-body">
                        <form method="post" action="registrati.php">
                            <label for="username">Nome utente:</label>
                            <input class="form-control" type="text" id="username" name="username" value="<?php if (isset($_SESSION['tmpUsr'])){ echo $_SESSION['tmpUsr']; $_SESSION['tmpUsr']=''; } ?>" required>
                            <label for="password">Password:</label>
                            <input class="form-control" type="password" id="password" name="password" required>
                            <label for="conferma_password">Conferma Password:</label>
                            <input class="form-control" type="password" id="conferma_password" name="conferma_password" required>
                            <label for="email">Email:</label>
                            <input class="form-control" type="email" id="email" name="email" value="<?php if (isset($_SESSION['tmpMail'])){ echo $_SESSION['tmpMail']; $_SESSION['tmpMail']=''; } ?>" required>
                            <label for="nome">Nome:</label>
                            <input class="form-control" type="text" id="nome" name="nome" value="<?php if (isset($_SESSION['tmpNome'])){ echo $_SESSION['tmpNome']; $_SESSION['tmpNome']=''; } ?>" required>
                            <label for="cognome">Cognome</label>
                            <input class="form-control" type="text" id="cognome" name="cognome" value="<?php if (isset($_SESSION['tmpCognome'])){ echo $_SESSION['tmpCognome']; $_SESSION['tmpCognome']=''; } ?>" required>
                            <input class="form-control" type="submit" name="registrati" value="Registrati!">
                            <input class="form-control" type="reset" name="reset" value="Reset">
                        </form>
                    </div>
                </div>
            </div>
        </body>

    <?php }
    include 'footer.php';