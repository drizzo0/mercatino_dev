<?php
include '../header.php';
//controllo se utente può accedere e caricare barra con sezioni

$userID = $_SESSION['utente']['idUtente'];
$roleID = $sql->query("SELECT * FROM ruoliUtente WHERE idUtente = '$userID'")->fetch_array()['idRuolo'];
$role = $sql->query("SELECT * FROM ruoli WHERE idRuolo = '$roleID'")->fetch_array()['modificaImpostazioniSito'];
if ($role==0){
    echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'index.php">';
    header("location: ".$siteURL."index.php");
}

?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarAmministrazione" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarAmministrazione">
        <ul class="navbar-nav md-auto">
            <li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>amministrazione/utenti.php">Lista Utenti</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>amministrazione/ruoli.php">Ruoli</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>amministrazione/impostazioni.php">Impostazioni</a></li>
            <li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>amministrazione/pagine.php">Modifica Pagine</a></li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <?php
                $uri = $_SERVER['REQUEST_URI'];
                if (strpos($uri, '/amministrazione/impostazioni.php') !== false) { ?>
                    <li class="nav-item"><button class="nav-link" onclick="toggleGeneral()">Generali</button></li>
                    <li class="nav-item"><button class="nav-link" onclick="toggleAdvanced()">Avanzate</button></li>
                <?php }
            ?>
            <?php
            $uri = $_SERVER['REQUEST_URI'];
            if (strpos($uri, '/amministrazione/pagine.php') !== false) { ?>
                <li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>amministrazione/pagine.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>amministrazione/pagine.php?pagina=Orari">Orari</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>amministrazione/pagine.php?pagina=DoveSiamo">Dove Siamo</a></li>
            <?php }
            ?>

        </ul>
    </div>
</nav>
