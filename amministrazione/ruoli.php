<?php
    include 'header.php';
    $data = '';
    if($_SERVER['REQUEST_METHOD']=='POST'){

        if(isset($_POST['crea'])){
            $nomeRuolo = $_POST['nomeRuolo'];
            if($_POST['accessoSito']=='on'){ $accesso = 1; }else{ $accesso = 0; }
            if($_POST['operatore']=='on'){ $pannelloOperatori = 1; }else{ $pannelloOperatori = 0; }
            if($_POST['amministratore']=='on'){ $amministratore = 1; } else{ $amministratore = 0; }

            $sql->query("INSERT INTO ruoli (puoAccedere, modificaImpostazioniSito, modificaUtenti, accessoPannelloOperatore, nomeRuolo) VALUES ('$accesso', '$amministratore', '0', '$pannelloOperatori', '$nomeRuolo')");
            $errore = $sql->error;
            if ($errore){
                die($errore);
            }else{
                echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'amministrazione/ruoli.php">';
            }

        }elseif (isset($_POST['modifica'])){
            $idRuolo = $_POST['idRuolo'];
            if($_POST['accessoSito']=='on'){ $accesso = 1; }else{ $accesso = 0; }
            if($_POST['operatore']=='on'){ $pannelloOperatori = 1; }else{ $pannelloOperatori = 0; }
            if($_POST['amministratore']=='on'){ $amministratore = 1; } else{ $amministratore = 0; }

            $sql->query("UPDATE ruoli SET puoAccedere = '$accesso' WHERE idRuolo = '$idRuolo'");
            $err1 = $sql->error;
            $sql->query("UPDATE ruoli SET modificaImpostazioniSito = '$amministratore' WHERE idRuolo = '$idRuolo'");
            $err2 = $sql->error;
            $sql->query("UPDATE ruoli SET accessoPannelloOperatore = '$pannelloOperatori' WHERE idRuolo = '$idRuolo'");
            $err3 = $sql->error;
            echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'amministrazione/ruoli.php">';

        }

    }else{

        if(isset($_GET['idRuolo'])){
            $idRuolo = $_GET['idRuolo'];
            $ruolo = $sql->query("SELECT * FROM ruoli WHERE idRuolo = '$idRuolo'")->fetch_array();
            $nomeRuolo = $ruolo['nomeRuolo'];
            $accesso = $ruolo['puoAccedere'];
            $amministratore = $ruolo['modificaImpostazioniSito'];
            $pannelloOperatori = $ruolo['accessoPannelloOperatore'];
            ?>
            <form method="post">
                <label for="nomeRuolo">Nome Ruolo:</label>
                <input type="text" id="nomeRuolo" name="nomeRuolo" readonly value="<?php echo $nomeRuolo; ?>">
                <label for="accessoSito">Accesso:</label>
                <input type="checkbox" id="accessoSito" name="accessoSito" <?php if($accesso==1){echo "checked"; } ?>>
                <label for="operatore">Operatore:</label>
                <input type="checkbox" id="operatore" name="operatore" <?php if($pannelloOperatori==1){echo "checked"; } ?>>
                <label for="amministratore">Amministratore:</label>
                <input type="checkbox" id="amministratore" name="amministratore" <?php if($amministratore==1){echo "checked"; } ?>>
                <input type="hidden" name="idRuolo" value="<?php echo $idRuolo; ?>">
                <input type="submit" name="modifica" value="Modifica Ruolo">
            </form>
            <?php
        }else{
            if ($_SESSION['impostazioni']['creaRuoliAbilitato'] == 1) {

                ?>
                <form method="post">
                    <label for="nomeRuolo">Nome Ruolo:</label>
                    <input type="text" id="nomeRuolo" name="nomeRuolo" required>
                    <label for="accessoSito">Accesso:</label>
                    <input type="checkbox" id="accessoSito" name="accessoSito">
                    <label for="operatore">Operatore:</label>
                    <input type="checkbox" id="operatore" name="operatore">
                    <label for="amministratore">Amministratore:</label>
                    <input type="checkbox" id="amministratore" name="amministratore">
                    <?php if ($_SESSION['impostazioni']['creaRuoliAbilitato'] == 1) { ?>
                        <input type="submit" name="crea" value="Crea Ruolo">
                    <?php } elseif ($_SESSION['impostazioni']['creaRuoliAbilitato'] == 0) { ?>
                        <input type="submit" name="DISABILITATO" value="Crea Ruolo" disabled>
                    <?php } ?>
                </form>
                <?php

            }

            $ruoli = $sql->query("SELECT * FROM ruoli");
            if ($ruoli->num_rows==0){
                echo "Non hai ruoli";
            }else{
                while ($ruolo = $ruoli->fetch_assoc()){
                    $idRuolo = $ruolo['idRuolo'];
                    $nomeRuolo = $ruolo['nomeRuolo'];
                    $accesso = $ruolo['puoAccedere'];
                    if($accesso==1){$accesso='Si';}else{$accesso='No';}
                    $modificaImpostazioni = $ruolo['modificaImpostazioniSito'];
                    if($modificaImpostazioni==1){$modificaImpostazioni='Si';}else{$modificaImpostazioni='No';}
                    $pannelloOperatori = $ruolo['accessoPannelloOperatore'];
                    if($pannelloOperatori==1){$pannelloOperatori='Si';}else{$pannelloOperatori='No';}

                    if($_SESSION['impostazioni']['modificaRuoliAbilitato']==1){
                        $tdModifica = "<td><a href='".$siteURL."amministrazione/ruoli.php?idRuolo=".$idRuolo."'>Modifica</a></td>";
                    }else{
                        $tdModifica = "";
                    }
                    $data .= "
                        <tr>
                            <td>".$idRuolo."</td>
                            <td>".$nomeRuolo."</td>
                            <td>".$accesso."</td>
                            <td>".$pannelloOperatori."</td>
                            <td>".$modificaImpostazioni."</td>
                            ".$tdModifica."
                        </tr>
                    ";
                }
                ?>
                <table class="table table-bordered">
                    <tr>
                        <td>ID Ruolo</td>
                        <td>Nome Ruolo</td>
                        <td>Può accedere</td>
                        <td>Operatore</td>
                        <td>Amministratore</td>
                        <?php if ($_SESSION['impostazioni']['modificaRuoliAbilitato']==1){ ?> <td>Modifica</td> <?php } ?>
                    </tr>
                    <?php echo $data; ?>
                </table>
                <?php
            }
        }

    }
include "../footer.php";