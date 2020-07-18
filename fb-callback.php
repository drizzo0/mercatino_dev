<?php
    include "header.php";

    try {
        $accessToken = $FacebookHelper->getAccessToken();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    if (! isset($accessToken)) {
        if ($FacebookHelper->getError()) {
            header('HTTP/1.0 401 Unauthorized');
            echo "Error: " . $FacebookHelper->getError() . "\n";
            echo "Error Code: " . $FacebookHelper->getErrorCode() . "\n";
            echo "Error Reason: " . $FacebookHelper->getErrorReason() . "\n";
            echo "Error Description: " . $FacebookHelper->getErrorDescription() . "\n";
        } else {
            header('HTTP/1.0 400 Bad Request');
            echo 'Bad request';
        }
        exit;
    }

    $oAuth2Client = $Facebook->getOAuth2Client();
    $tokenMetadata = $oAuth2Client->debugToken($accessToken);
    $tokenMetadata->validateAppId($_SESSION['impostazioni']['facebookSSOAppID']); // Replace {app-id} with your app id
    $tokenMetadata->validateExpiration();
    if (! $accessToken->isLongLived()) {
        try {
            $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
            exit;
        }
    }
    $_SESSION['fb_access_token'] = (string) $accessToken;


    try {
        // Returns a `Facebook\FacebookResponse` object
        $user = json_decode($Facebook->get('/me?fields=id,name,email', $accessToken)->getGraphUser(), true);
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }

    $FullName = explode(' ',$user['name']);
    if(count($FullName)==2){
        $name = $FullName[0];
        $surname = $FullName[1];
    }elseif (count($FullName) >= 3){
        $counterA = 0;
        while ($counterA > count($FullName)){
            $name .= $FullName[$counterA];
            $counterA++;
        }
        $surname = $FullName[count($FullName)-1];
    }else {
        $name = $surname = $FullName[0];
    }
    $username = $email = $user['email'];
    $user = $sql->query("SELECT * FROM utenti WHERE email='$email'");
    if($user->num_rows == 0){
        $passwordLength = 1;
        $dataRegistrazione = date('Y-m-d H:i:s');
        $dataUltimoAccesso = $dataRegistrazione;
        $ipRegistrazione = $Core->getUserIpAddr();
        $ipUltimoAccesso = $ipRegistrazione;

        $abilitato = 1;
        $password = $Core->getSSOPassword();

        $sql->query("INSERT INTO utenti (username, password, lunghezzaPassword, email, nome, cognome, dataRegistrazione, dataUltimoAccess, ipRegistrazione, ipUltimoAccesso, abilitato) VALUES ('$username', '$password', '$passwordLength', '$email', '$name', '$surname', '$dataRegistrazione', '$dataUltimoAccesso', '$ipRegistrazione', '$ipUltimoAccesso', '$abilitato')");
        $errore = $sql->error;
        if ($errore) {
            die($errore);
        } else {
            $idRuoloUtente = $_SESSION['impostazioni']['ruoloUtente'];
            $user = $sql->query("SELECT * FROM utenti WHERE username = '$username'")->fetch_array();
            $utente = $user;
            $user = $user['idUtente'];
            $sql->query("INSERT INTO ruoliUtente (idUtente, idRuolo) VALUES ('$user', '$idRuoloUtente')");

            $Mail->addAddress($email, $name.' '.$surname);
            $Mail->Subject = $_SESSION['impostazioni']['mailOggettoBenvenuto'];
            $Mail->Body    = '<center>Benvenuto!<br>Accedi cliccando <a href="'.$siteURL.'accedi.php">qui</a>. </center>';
            $Mail->send();
            $Core->userLogs($utente,'Registrazione','Ok');

        }

        $utente = $sql->query("SELECT * FROM utenti WHERE email = '$email'")->fetch_array();
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

        $utente = $sql->query("SELECT * FROM utenti WHERE email = '$email'")->fetch_array();
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
