<?php
    include '../header.php';
    //controllo se utente può accedere e caricare barra con sezioni

    /*$impostazioni = $sql->query("SELECT * FROM impostazioni");
    while ($impostazione = $impostazioni -> fetch_assoc()){
        $_SESSION['impostazioni'][$impostazione['nomeImpostazione']] = $impostazione['valoreImpostazione'];
    }*/

    $userID = $_SESSION['utente']['idUtente'];
    $roleID = $sql->query("SELECT * FROM ruoliUtente WHERE idUtente = '$userID'");
    $roleID = $roleID->fetch_array();
    $roleID = $roleID['idRuolo'];
    $role = $sql->query("SELECT * FROM ruoli WHERE idRuolo = '$roleID'");
    $role = $role->fetch_array();
    if ($role['accessoPannelloOperatore']==0){
        echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'index.php">';
        header("location: ".$siteURL."index.php");
    }

?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarGestione" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarGestione">
            <ul class="navbar-nav md-auto">
                <li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>gestione/cataloga_libro.php">Cataloga Libro</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>gestione/lista_libri.php">Lista Libri</a></li>
                <li class="nav-item"><a class="nav-link  <?php if($_SESSION['impostazioni']['prenotazioniAbilitate']==0){ echo "disabled"; } ?>" href="<?php echo $siteURL; ?>gestione/lista_prenotazioni.php">Lista Prenotazioni</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>gestione/persone_che_hanno_portato_libri.php">Clienti</a></li>
                <div class="dropdown dropright nav-item ml-auto">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">Parametri catalogo</button>
                    <div class="dropdown-menu">
                        <li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>gestione/stati_libri.php">Stati Libri</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>gestione/tipi_libri.php">Volumi Libri</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>gestione/tipi_scuola.php">Tipi Scuole</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>gestione/materie.php">Materie</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>gestione/case_editrici.php">Case Editrici</a></li>
                    </div>
                </div>

            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>gestione/carrello.php">Carrello</a></li>
            </ul>
        </div>
    </nav>