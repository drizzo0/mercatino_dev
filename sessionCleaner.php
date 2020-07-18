<?php
    include 'dbconfig.php';
    $time = time();
    $sessions = $sql->query("SELECT * FROM sessioni");
    while ($session = $sessions->fetch_assoc()){
        $sessionID = $session['idSessione'];
        $sessionExpire = $session['expire'];
        if($time >= $sessionExpire){
            $sql->query("DELETE FROM sessioni WHERE idSessione = '$sessionID'");
        }
    }