<?php

    include 'header.php';
    if ($_SESSION['loggedIn']==false){
        echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'index.php">';
    }

    if($_SERVER['REQUEST_METHOD']=='POST'){
        $vecchiaPassword = $_POST['vecchiaPassword'];
        $nuovaPassword = $_POST['nuovaPassword'];
        $confermaPassword = $_POST['confermaPassword'];
        $vecchiaPassword = $Core->encryptPassword($vecchiaPassword);
        if($nuovaPassword!==$confermaPassword){
            die("Le due password sono diverse.");
        }else{
            $nuovaPassword = $Core->encryptPassword($nuovaPassword);
            $idUtente = $_SESSION['utente']['idUtente'];
            $query = $sql->query("select password from utenti where idUtente = '$idUtente'")->fetch_array();
            if ($query['password']!==$vecchiaPassword){
                die("La vecchia password non è corretta.");
            }else{
                $sql->query("update utenti set password='$nuovaPassword' where idUtente='$idUtente'");
                if($sql->error){
                    die($sql->error);
                }else{
                    echo "Cambio effettuato";
                }
            }
        }
    }else{
        ?>
        <title>Modifica password</title>
        <form method="post" action="cambia_password.php">
            <label id="vecchiaPassword">Password Attuale:</label>
            <input type="password" id="vecchiaPassword" name="vecchiaPassword">
            <label id="nuovaPassword">Nuova Password:</label>
            <input type="password" id="nuovaPassword" name="nuovaPassword">
            <label id="confermaPassword">Conferma Password:</label>
            <input type="password" id="confermaPassword" name="confermaPassword">
            <input type="submit" name="modifica" value="Cambia Password">
        </form>

        <?php
    }
    include 'footer.php';