<?php
    include "header.php";
    session_destroy();
    
    $token = $_COOKIE['sessionToken'];
    setcookie("sessionToken","",time()-14440);
    $sql->query("DELETE FROM sessioni WHERE tokenSessione='$token'");

    echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'index.php">';