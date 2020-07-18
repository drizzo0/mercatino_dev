<?php

/**
 * TIPI DI IMPOSTAZIONI PER SEZIONE
 * 1 = Generali sito ( titoli pagine, link sito)
 * 2 = Settaggi vari
 * 3 = pagine html modificabili da amministrazione/pagine.php
 */

    include 'header.php';
    $data = '';
    if($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST['crea'])){
            $nome = $_POST['nomeImpostazione'];
            $descrizione = $_POST['descrizione'];
            $valore = $_POST['valoreImpostazione'];
            if($_POST['tipo']=='on'){ $tipo = 2; }else{ $tipo = 1; }
            $query = "INSERT INTO impostazioni (nomeImpostazione, valoreImpostazione, tipo, descrizione) VALUES ('$nome', '$valore', '$tipo', '$descrizione')";
            $sql->query($query);
            $err = $sql->error;
            if($err){
                die($err);
            }
            echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'amministrazione/impostazioni.php">';

        }elseif (isset($_POST['modifica'])){
            $nuovoValore = $_POST['valoreImpostazione'];
            $idImpostazione = $_POST['idImpostazione'];
            $modificaAvanzate = $_SESSION['impostazioni']['modificaImpostazioniAvanzate'];

            $tipo = $sql->query("SELECT tipo FROM impostazioni WHERE idImpostazione = '$idImpostazione'")->fetch_array()['tipo'];
            if($tipo == 2 && $modificaAvanzate == 0){
                die("La modifica delle impostazioni avanzate è disabilitata, non fare il furbo");
            }else{
                $sql->query("UPDATE impostazioni SET valoreImpostazione = '$nuovoValore' WHERE idImpostazione = '$idImpostazione'");
                $err = $sql->error;
                if ($err){
                    die($err);
                }
                echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'amministrazione/impostazioni.php">';
            }
            echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'amministrazione/impostazioni.php">';
        }
    }else {

        if (isset($_GET['modifica'])) {
            $idImpostazione = $_GET['modifica'];
            $modificaAvanzate = $_SESSION['impostazioni']['modificaImpostazioniAvanzate'];
            $impostazione = $sql->query("SELECT * FROM impostazioni WHERE idImpostazione = '$idImpostazione'")->fetch_array();
            if ($modificaAvanzate == 0 && $impostazione['tipo'] == 2) {
                die("La modifica delle impostazioni avanzate è disabilitata");
            } else {
                ?>
                <form method="post">
                    <label for="nomeImpostazione">Nome Impostazione:</label>
                    <input type="text" id="nomeImpostazione" name="nomeImpostazione"
                           value="<?php echo $impostazione['nomeImpostazione']; ?>" readonly>
                    <label for="descrizione">Descrizione:</label>
                    <input type="text" id="descrizione" name="descrizione"
                           value="<?php echo $impostazione['descrizione']; ?>" readonly>
                    <label for="valoreImpostazione">Valore:</label>
                    <input type="text" id="valoreImpostazione" name="valoreImpostazione"
                           value="<?php echo $impostazione['valoreImpostazione']; ?>">
                    <input type="hidden" id="idImpostazione" name="idImpostazione"
                           value="<?php echo $idImpostazione; ?>">
                    <input type="submit" name="modifica" value="Modifica Impostazione">
                </form>
                <?php
            }


        } else {
            $impostazioni = $sql->query("SELECT * FROM impostazioni WHERE tipo = 2");
            if ($impostazioni->num_rows == 0) {
                echo "Non hai impostazioni";
            } else {
                while ($impostazione = $impostazioni->fetch_assoc()) {
                    $id = $impostazione['idImpostazione'];
                    $nome = $impostazione['nomeImpostazione'];
                    $descrizione = $impostazione['descrizione'];
                    $valore = $impostazione['valoreImpostazione'];
                    if ($_SESSION['impostazioni']['modificaImpostazioniAvanzate']) {
                        $modifica = "<td><a href='" . $siteURL . "amministrazione/impostazioni.php?modifica=" . $id . "'>Modifica</a></td>";
                    }
                    $dataAvanzate .= "
                            <tr>
                                <td>" . $id . "</td>
                                <td>" . $nome . "</td>
                                <td>" . $descrizione . "</td>
                                <td>" . $valore . "</td>
                                " . $modifica . "   
                            </tr>                
                        ";
                }
            }
            $impostazioni = $sql->query("SELECT * FROM impostazioni WHERE tipo = 1");
            if ($impostazioni->num_rows == 0) {
                echo "Non hai impostazioni";
            } else {
                while ($impostazione = $impostazioni->fetch_assoc()) {
                    $id = $impostazione['idImpostazione'];
                    $nome = $impostazione['nomeImpostazione'];
                    $descrizione = $impostazione['descrizione'];
                    $valore = $impostazione['valoreImpostazione'];
                    $dataGenerali .= "
                    <tr>
                        <td>" . $id . "</td>
                        <td>" . $nome . "</td>
                        <td>" . $descrizione . "</td>
                        <td>" . $valore . "</td>
                        <td><a href='" . $siteURL . "amministrazione/impostazioni.php?modifica=" . $id . "'>Modifica</a></td>
                    </tr>                
                ";
                }

                ?>

                <form method="post">
                    <label for="nomeImpostazione">Nome Impostazione:</label>
                    <input type="text" id="nomeImpostazione" name="nomeImpostazione">
                    <label for="descrizione">Descrizione:</label>
                    <input type="text" id="descrizione" name="descrizione">
                    <label for="valoreImpostazione">Valore:</label>
                    <input type="text" id="valoreImpostazione" name="valoreImpostazione">
                    <label for="tipo">Avanzata:</label>
                    <input type="checkbox" id="tipo" name="tipo">
                    <input type="submit" name="crea" value="Crea Impostazione">
                </form>


                <div id="impostazioniAvanzate" width="99.9%" style="display: none;">
                    <table id="tableAvanzati" class="table display table-bordered" width="99.9%">
                        <thead>
                        <tr>
                            <th>ID Impostazione</th>
                            <th>Nome</th>
                            <th>Descrizione</th>
                            <th>Valore</th>
                            <?php if ($_SESSION['impostazioni']['modificaImpostazioniAvanzate']) { ?>
                                <th>Modifica</th>
                            <?php } ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php echo $dataAvanzate; ?>
                        </tbody>
                    </table>
                </div>

                <div id="impostazioniGenerali" width="99.9%">
                    <table id="tableGenerali" class="table display table-bordered" width="99.9%">
                        <thead>
                        <tr>
                            <td>ID Impostazione</td>
                            <td>Nome</td>
                            <td>Descrizione</td>
                            <td>Valore</td>
                            <td>Modifica</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php echo $dataGenerali; ?>
                        </tbody>
                    </table>
                </div>

                <script>
                    $(document).ready(function () {
                        $('#tableGenerali').DataTable( { "scrollX": true } );
                        $('#tableAvanzati').DataTable( { "scrollX": true } );
                    });

                    function toggleGeneral() {
                        var tabGeneral = document.getElementById("impostazioniGenerali");
                        var tabAdvanced = document.getElementById("impostazioniAvanzate");
                        if (tabGeneral.style.display === "none") {
                            tabGeneral.style.display = "block";
                            tabAdvanced.style.display = "none";
                        }
                    }
                    function toggleAdvanced() {
                        var tabGeneral = document.getElementById("impostazioniGenerali");
                        var tabAdvanced = document.getElementById("impostazioniAvanzate");
                        if (tabAdvanced.style.display === "none") {
                            tabAdvanced.style.display = "block";
                            tabGeneral.style.display = "none";
                        }
                    }

                </script>

                <?php
            }
        }
    }
    include '../footer.php';