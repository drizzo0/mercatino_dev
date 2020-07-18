<?php
    include 'header.php';

    if(isset($_SESSION['utente'])&&isset($_SESSION['loggedIn'])&&$_SESSION['loggedIn']==true){
        echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'index.php">';
    }else {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['verifica'])) {
                $codiceConferma = $_POST['codiceConferma'];
                $userID = $sql->query("SELECT idUtente FROM utenti_temp WHERE codiceConferma = '$codiceConferma'");
                if ($userID->num_rows == 0) {
                    $_SESSION['giaRegErroreTemp'] = 'Codice di conferma non valido!';
                    echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'abilita.php">';
                } else {
                    $userID = $userID->fetch_array();
                    $userID = $userID['idUtente'];
                    $sql->query("UPDATE utenti SET abilitato=1 WHERE idUtente = '$userID'");
                    if ($sql->error) {
                        die($sql->error);
                    }
                    $sql->query("DELETE FROM utenti_temp WHERE idUtente = '$userID' AND codiceConferma = '$codiceConferma'");
                    if ($sql->error) {
                        die($sql->error);
                    }

                    $username = $sql->query("SELECT username FROM utenti WHERE idUtente = '$userID'");
                    $username = $username->fetch_array();
                    $_SESSION['tmpUsr'] = $username['username'];
                    $_SESSION['giaRegErroreTemp'] = 'Account abilitato!';
                }
                echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'accedi.php">';
            }elseif($_POST['richiedi']){
                $email = $_POST['email'];
                $idUtente = $sql->query("SELECT idUtente, abilitato, username, nome, cognome FROM utenti WHERE email = '$email'");
                if ($idUtente->num_rows==0){
                    $_SESSION['mailNonValidaTemp'] = 'Indirizzo email non valido!';
                    echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'abilita.php?richiediCodice">';
                }else{
                    $idUtente = $idUtente->fetch_array();
                    $nome = $idUtente['nome'];
                    $cognome = $idUtente['cognome'];
                    if($idUtente['abilitato']==1){
                        $_SESSION['tmpUsr'] = $idUtente['username'];
                        $_SESSION['giaRegErroreTemp'] = 'Account già abilitato!';
                        echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'accedi.php">';
                    } else {
                        $idUtente = $idUtente['idUtente'];
                        $codiceConferma = $sql->query("SELECT codiceConferma FROM utenti_temp WHERE idUtente = '$idUtente'");
                        $codiceConferma = $codiceConferma->fetch_array();
                        $codiceConferma = $codiceConferma['codiceConferma'];

                        $Mail->addAddress($email, $nome.' '.$cognome);
                        $Mail->isHTML(true);                                  // Set email format to HTML
                        $Mail->Subject = 'Ecco il tuo codice di verifica!';
                        $Mail->Body    = '<center>Devi ancora verificare il tuo account, per verificarlo clicca <a href="'.$siteURL.'abilita.php?codice='.$codiceConferma.'">qui</a>.<br>Se il link non dovesse funzionare visita: '.$siteURL.'abilita.php e inserisci '.$codiceConferma.' come codice di conferma.';
                        $Mail->send();
                        $_SESSION['giaRegErroreTemp'] = 'Codice richiesto!';
                        echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'abilita.php">';
                    }
                }

            }

        } else {
            if (isset($_GET['codice'])) {
                $codiceConferma = $_GET['codice'];
                $userID = $sql->query("SELECT idUtente FROM utenti_temp WHERE codiceConferma = '$codiceConferma'");
                if($userID->num_rows==0){
                    $_SESSION['giaRegErroreTemp'] = 'Codice di conferma non valido!';
                    echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'abilita.php">';
                }else{
                    $userID = $userID->fetch_array();
                    $userID = $userID['idUtente'];
                    $sql->query("UPDATE utenti SET abilitato=1 WHERE idUtente = '$userID'");
                    if($sql->error){
                        die($sql->error);
                    }
                    $sql->query("DELETE FROM utenti_temp WHERE idUtente = '$userID' AND codiceConferma = '$codiceConferma'");
                    if($sql->error){
                        die($sql->error);
                    }

                    $username = $sql->query("SELECT username FROM utenti WHERE idUtente = '$userID'");
                    $username = $username->fetch_array();
                    $_SESSION['tmpUsr'] = $username['username'];
                    $_SESSION['giaRegErroreTemp'] = 'Account abilitato!';
                }
                echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'accedi.php">';
            }elseif (isset($_GET['richiediCodice'])) {
                if ($_GET['richiediCodice']=='Invia codice di verifica!'){
                    echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'abilita.php?richiediCodice">';
                } ?>

                <div class="container rounded align-content-center">
                    <div class="card rounded py-2 col-md-6">
                        <div class="card-header">
                            <b>Richiedi codice</b><br>
                            <?php if (isset($_SESSION['mailNonValidaTemp'])) {
                                print $_SESSION['mailNonValidaTemp'];
                                $_SESSION['mailNonValidaTemp'] = '';
                            } ?>
                        </div>
                        <div class="card-body">
                            <form method="post" action="abilita.php">
                                <label for="email">Email:</label>
                                <input type="text" class="form-control" name="email" id="email">
                                <input type="submit" name="richiedi" value="Richiedi codice!">
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }else {
                ?>
                <div class="container rounded align-content-center">
                    <div class="card rounded py-2 col-md-6">
                        <div class="card-header">
                            <b>Verifica il tuo account</b><br>
                            <?php if (isset($_SESSION['giaRegErroreTemp'])) {
                                print $_SESSION['giaRegErroreTemp'];
                                $_SESSION['giaRegErroreTemp'] = '';
                            } ?>
                        </div>
                        <div class="card-body">
                            <form method="post" action="abilita.php">
                                <label for="codiceConferma">Codice di conferma:</label>
                                <input type="text" class="form-control" name="codiceConferma" id="codiceConferma">
                                <input type="submit" name="verifica" value="Conferma il tuo account!">
                            </form>
                        </div>
                        <div class="card-footer">
                            <form method="get" action="abilita.php?richiediCodice">
                                <input type="submit" name="richiediCodice" value="Invia codice di verifica!">
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    }
    include 'footer.php';