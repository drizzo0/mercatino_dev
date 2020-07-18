<?php
    include 'header.php';
    if(isset($_SESSION['utente'])&&isset($_SESSION['loggedIn'])&&$_SESSION['loggedIn']==true){
        header('location: index.php');
    }else{

        if ($_SERVER['REQUEST_METHOD'] == 'POST'){

            $username = $_POST['username'];
            $password = $_POST['password'];

            $password = $Core->encryptPassword($password);

            $query = "SELECT * FROM utenti WHERE username='$username'";
            $risultatoQuery = $sql->query($query);
            if($risultatoQuery->num_rows>0){
                $utente = $risultatoQuery->fetch_array();
                if ($password == $utente['password']){
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['utente']['idUtente'] = $utente['idUtente'];
                    $_SESSION['utente']['username'] = $utente['username'];
                    $_SESSION['utente']['email'] = $utente['email'];
                    $_SESSION['utente']['nome'] = $utente['nome'];
                    $_SESSION['utente']['cognome'] = $utente['cognome'];
                    $userID = $_SESSION['utente']['idUtente'];
                    $roleID = $sql->query("SELECT * FROM ruoliUtente WHERE idUtente = '$userID'")->fetch_array();
                    $_SESSION['utente']['idRuolo'] = $roleID['idRuolo'];
                    $data = date('Y-m-d H:i:s');
                    $ip = $Core->getUserIpAddr();

                    $sql->query("update utenti set ipUltimoAccesso='$ip' where idUtente='$userID'");
                    $sql->query("update utenti set dataUltimoAccess='$data' where idUtente='$userID'");

                    $sessionToken = $Core->requestRandomCode();
                    $cookieExpire = time()+14440;
                    setcookie("sessionToken",$sessionToken,$cookieExpire);
                    $sql->query("INSERT INTO sessioni (tokenSessione,idUtente,expire) VALUES ('$sessionToken','$userID','$cookieExpire')");

                    $Core->userLogs($utente,'Login','Ok');

                    echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'index.php">';

                }else{
                    $_SESSION['giaRegErroreTemp'] = 'Password errata.';
                    $Core->userLogs($utente,'Login','Password errata.');
                    $_SESSION['tmpUsr'] = $username;
                    echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'accedi.php">';
                }
            }else{
                $_SESSION['giaRegErroreTemp'] = 'Nome utente non registrato.';
                echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'accedi.php">';
            }
        }else{
            if(isset($_GET['code'])){
                $token = $Google_Client->fetchAccessTokenWithAuthCode($_GET['code']);
                $Google_Client->setAccessToken($token['access_token']);

                // get profile info
                $google_oauth = new Google_Service_Oauth2($Google_Client);
                $google_account_info = $google_oauth->userinfo->get();

                $cognome = $google_account_info->familyName;
                $nome = $google_account_info->givenName;
                $email = $google_account_info->email;

                $user = $sql->query("SELECT * FROM utenti WHERE email='$email'");
                if($user->num_rows == 0){
                    $username = $email;
                    $passwordLength = 1;
                    $dataRegistrazione = date('Y-m-d H:i:s');
                    $dataUltimoAccesso = $dataRegistrazione;
                    $ipRegistrazione = $Core->getUserIpAddr();
                    $ipUltimoAccesso = $ipRegistrazione;

                    $abilitato = 1;

                    $password = $Core->getSSOPassword();

                    $sql->query("INSERT INTO utenti (username, password, lunghezzaPassword, email, nome, cognome, dataRegistrazione, dataUltimoAccess, ipRegistrazione, ipUltimoAccesso, abilitato) VALUES ('$username', '$password', '$passwordLength', '$email', '$nome', '$cognome', '$dataRegistrazione', '$dataUltimoAccesso', '$ipRegistrazione', '$ipUltimoAccesso', '$abilitato')");
                    $errore = $sql->error;
                    if ($errore) {
                        die($errore);
                    } else {
                        $idRuoloUtente = $_SESSION['impostazioni']['ruoloUtente'];
                        $user = $sql->query("SELECT * FROM utenti WHERE username = '$username'")->fetch_array();
                        $utente = $user;
                        $user = $user['idUtente'];
                        $sql->query("INSERT INTO ruoliUtente (idUtente, idRuolo) VALUES ('$user', '$idRuoloUtente')");

                        $Mail->addAddress($email, $nome.' '.$cognome);
                        $Mail->Subject = $_SESSION['impostazioni']['mailOggettoBenvenuto'];
                        $Mail->Body    = '<center>Benvenuto!<br>Accedi cliccando <a href="'.$siteURL.'accedi.php">qui</a>. </center>';
                        $Mail->send();
                        $Core->userLogs($utente,'Registrazione','Ok');

                    }

                    $utente = $sql->query("SELECT * FROM utenti WHERE email = '$google_account_info->email'")->fetch_array();
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['utente']['idUtente'] = $utente['idUtente'];
                    $_SESSION['utente']['username'] = $utente['username'];
                    $_SESSION['utente']['email'] = $utente['email'];
                    $_SESSION['utente']['nome'] = $utente['nome'];
                    $_SESSION['utente']['cognome'] = $utente['cognome'];
                    $userID = $_SESSION['utente']['idUtente'];
                    $roleID = $sql->query("SELECT * FROM ruoliUtente WHERE idUtente = '$userID'")->fetch_array();
                    $_SESSION['utente']['idRuolo'] = $roleID['idRuolo'];

                    $sessionToken = $Core->requestRandomCode();
                    $cookieExpire = time()+14440;
                    setcookie("sessionToken",$sessionToken,$cookieExpire);
                    $sql->query("INSERT INTO sessioni (tokenSessione,idUtente,expire) VALUES ('$sessionToken','$userID','$cookieExpire')");

                    $Core->userLogs($utente,'Login','Ok');

                    echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'index.php">';

                }else{

                    $utente = $sql->query("SELECT * FROM utenti WHERE email = '$google_account_info->email'")->fetch_array();
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['utente']['idUtente'] = $utente['idUtente'];
                    $_SESSION['utente']['username'] = $utente['username'];
                    $_SESSION['utente']['email'] = $utente['email'];
                    $_SESSION['utente']['nome'] = $utente['nome'];
                    $_SESSION['utente']['cognome'] = $utente['cognome'];
                    $userID = $_SESSION['utente']['idUtente'];
                    $roleID = $sql->query("SELECT * FROM ruoliUtente WHERE idUtente = '$userID'")->fetch_array();
                    $_SESSION['utente']['idRuolo'] = $roleID['idRuolo'];

                    $sessionToken = $Core->requestRandomCode();
                    $cookieExpire = time()+14440;
                    setcookie("sessionToken",$sessionToken,$cookieExpire);
                    $sql->query("INSERT INTO sessioni (tokenSessione,idUtente,expire) VALUES ('$sessionToken','$userID','$cookieExpire')");

                    $Core->userLogs($utente,'Login','Ok');

                    echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'index.php">';



                }

            }else{


            ?>
            <title><?php echo $_SESSION['impostazioni']['titoloPaginaAccedi']; ?></title>
            <body>
                <div class="container col-md-auto py-2 text-center align-content-center">
                    <div class="card rounded">
                        <div class="card-header">
                            <h1><?php echo $_SESSION['impostazioni']['titoloPaginaAccedi']; ?></h1>
                            <?php if(isset($_SESSION['giaRegErroreTemp'])){ echo $_SESSION['giaRegErroreTemp']; $_SESSION['giaRegErroreTemp'] = ''; } ?>
                        </div>
                        <div class="card-body">
                            <form class="form-group" method="post" action="accedi.php">
                                <label for="username">Username:</label>
                                <input class="form-control" type="text" id="username" name="username" value="<?php if (isset($_SESSION['tmpUsr'])){ echo $_SESSION['tmpUsr']; $_SESSION['tmpUsr']=''; } ?>" required>
                                <label for="password">Password:</label>
                                <input class="form-control" type="password" id="password" name="password" required>
                                <input class="form-control" type="submit" name="accedi" value="Accedi!">
                                <input class="form-control" type="reset" name="reset" value="Reset">
                                <?php if($_SESSION['impostazioni']['googleSSOEnabled'] == 1) { echo '<a href="'. $Google_Client->createAuthUrl() .'">Accedi con Google</a><br>'; } ?>
                                <?php if($_SESSION['impostazioni']['facebookSSOEnabled'] == 1) { echo '<a href="' . htmlspecialchars($FacebookHelper->getLoginUrl($siteURL.'fb-callback.php',$FacebookPermissions)) . '">Log in with Facebook!</a>'; } ?>

                            </form>
                        </div>
                        <div class="card-footer align-content-center">
                            <a href="<?php echo $siteURL; ?>password_dimenticata.php">Password Dimenticata?</a>
                        </div>
                    </div>
                </div>
            </body>
        <?php }
        }
    }
    include 'footer.php';