<?php
include "header.php";
$data = '';

/**
 * TODO: Modifica libri
 * TODO: Sistemare la tabella e renderla magari più carina.... perchè con le immagini a cazzo fa altamente cagare
 */

$result = $sql->query("SELECT * FROM libri ");

if(isset($_POST['modifica'])) {
    $idLibro = $_POST['bookID'];
    $idOperatoreModifica = $_SESSION['utente']['idUtente'];
    $codiceCliente = $_POST['codiceUtente'];
    $ISBN = $_POST['codiceLibro'];
    $bookName = $_POST['nomeLibro'];
    $idMateria = $_POST['materia'];
    $idCasaEditrice = $_POST['casaEditrice'];
    $autore = $_POST['autore'];
    $idTipoLibro = $_POST['tipoLibro'];
    $idTipoScuola = $_POST['tipoScuola'];
    $prezzoRegolare = $_POST['prezzoRegolare'];
    $soldiDaRestituire = $_POST['soldiDaRestituire'];
    $prezzoMercatino = $_POST['prezzoMercatino'];
    $idStatoLibro = $_POST['statoLibro'];

    $sql->query("UPDATE libri SET idOperatoreModifica = '$idOperatoreModifica' WHERE idLibro='$idLibro'");
    $sql->query("UPDATE libri SET codicePortatore = '$codiceCliente' WHERE idLibro='$idLibro'");
    $sql->query("UPDATE libri SET codiceLibro = '$ISBN' WHERE idLibro='$idLibro'");
    $sql->query("UPDATE libri SET nomeLibro = '$bookName' WHERE idLibro='$idLibro'");
    $sql->query("UPDATE libri SET idMateria = '$idMateria' WHERE idLibro='$idLibro'");
    $sql->query("UPDATE libri SET idCasaEditrice = '$idCasaEditrice' WHERE idLibro='$idLibro'");
    $sql->query("UPDATE libri SET autoreLibro = '$autore' WHERE idLibro='$idLibro'");
    $sql->query("UPDATE libri SET idTipoLibro = '$idTipoLibro' WHERE idLibro='$idLibro'");
    $sql->query("UPDATE libri SET idTipoScuola = '$idTipoScuola' WHERE idLibro='$idLibro'");
    $sql->query("UPDATE libri SET prezzoRegolare = '$prezzoRegolare' WHERE idLibro='$idLibro'");
    $sql->query("UPDATE libri SET soldiDaRestituire = '$soldiDaRestituire' WHERE idLibro='$idLibro'");
    $sql->query("UPDATE libri SET prezzoMercatino = '$prezzoMercatino' WHERE idLibro='$idLibro'");
    $sql->query("UPDATE libri SET idStatoLibro = '$idStatoLibro' WHERE idLibro='$idLibro'");

    echo '<meta http-equiv="refresh" content="0;url=' . $siteURL . 'gestione/lista_libri.php">';

}elseif(isset($_POST['modificaTutto'])){
    $originalISBN = $_POST['originalISBN'];
    $idLibro = $_POST['bookID'];
    $idOperatoreModifica = $_SESSION['utente']['idUtente'];
    $ISBN = $_POST['codiceLibro'];
    $bookName = $_POST['nomeLibro'];
    $idMateria = $_POST['materia'];
    $idCasaEditrice = $_POST['casaEditrice'];
    $autore = $_POST['autore'];
    $idTipoLibro = $_POST['tipoLibro'];
    $idTipoScuola = $_POST['tipoScuola'];
    $prezzoRegolare = $_POST['prezzoRegolare'];
    $soldiDaRestituire = $_POST['soldiDaRestituire'];
    $prezzoMercatino = $_POST['prezzoMercatino'];
    $idStatoLibro = $_POST['statoLibro'];

    $sql->query("UPDATE libri SET idOperatoreModifica = '$idOperatoreModifica' WHERE codiceLibro='$originalISBN'");
    $sql->query("UPDATE libri SET nomeLibro = '$bookName' WHERE codiceLibro='$originalISBN'");
    $sql->query("UPDATE libri SET idMateria = '$idMateria' WHERE codiceLibro='$originalISBN'");
    $sql->query("UPDATE libri SET idCasaEditrice = '$idCasaEditrice' WHERE codiceLibro='$originalISBN'");
    $sql->query("UPDATE libri SET autoreLibro = '$autore' WHERE codiceLibro='$originalISBN'");
    $sql->query("UPDATE libri SET idTipoLibro = '$idTipoLibro' WHERE codiceLibro='$originalISBN'");
    $sql->query("UPDATE libri SET idTipoScuola = '$idTipoScuola' WHERE codiceLibro='$originalISBN'");
    $sql->query("UPDATE libri SET prezzoRegolare = '$prezzoRegolare' WHERE codiceLibro='$originalISBN'");
    $sql->query("UPDATE libri SET soldiDaRestituire = '$soldiDaRestituire' WHERE codiceLibro='$originalISBN'");
    $sql->query("UPDATE libri SET prezzoMercatino = '$prezzoMercatino' WHERE codiceLibro='$originalISBN'");
    $sql->query("UPDATE libri SET codiceLibro = '$ISBN' WHERE codiceLibro='$originalISBN'");

    echo '<meta http-equiv="refresh" content="0;url=' . $siteURL . 'gestione/lista_libri.php">';

}elseif(isset($_GET['eliminaLibro'])){
    $idLibroDaEliminare = $_GET['eliminaLibro'];
    $sql->query("DELETE FROM libri WHERE idLibro = '$idLibroDaEliminare'");
    $errore = $sql->error;
    if($errore){
        die($errore);
    }
    echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'gestione/lista_libri.php">';
}elseif(isset($_GET['modificaLibro'])){
    //TODO: Modifica libri
    $idLibro = $_GET['modificaLibro'];
    $query = "SELECT * FROM libri WHERE idLibro = '$idLibro'";
    $result = $sql->query($query);
    if($result->num_rows==0){
        echo "Non esiste un libro con questo codice";
    }else{
        $libro = $result->fetch_array();
        $codiceLibro = $libro['codiceLibro'];
        $nomeLibro = $libro['nomeLibro'];

        $idMateria = $libro['idMateria'];
        $nomeMateria = $sql->query("SELECT nomeMateria FROM materie WHERE idMateria = '$idMateria'")->fetch_array()['nomeMateria'];
        $materie .= '<option value="'.$idMateria.'">'.$nomeMateria.'</option><option value="null" disabled>-------</option>';

        $idCasaEditrice = $libro['idCasaEditrice'];
        $nomeCasaEditrice = $sql->query("SELECT nomeCasaEditrice FROM caseEditrici WHERE idCasaEditrice = '$idCasaEditrice'")->fetch_array()['nomeCasaEditrice'];
        $caseEditrici .= '<option value="'.$idCasaEditrice.'">'.$nomeCasaEditrice.'</option><option value="null" disabled>-------</option>';

        $autore = $libro['autoreLibro'];

        $idTipoScuola = $libro['idTipoScuola'];
        $nomeTipoScuola = $sql->query("SELECT nomeTipoScuola FROM tipiScuola WHERE idTipoScuola = '$idTipoScuola'")->fetch_array()['nomeTipoScuola'];
        $tipiScuole .= '<option value="'.$idTipoScuola.'">'.$nomeTipoScuola.'</option><option value="null" disabled>-------</option>';

        $idTipoLibro = $libro['idTipoLibro'];
        $nomeTipoLibro = $sql->query("SELECT nomeTipoLibro FROM tipiLibri WHERE idTipoLibro = '$idTipoLibro'")->fetch_array()['nomeTipoLibro'];
        $tipiLibri .= '<option value="'.$idTipoLibro.'">'.$nomeTipoLibro.'</option><option value="null" disabled>-------</option>';

        $prezzoRegolare = $libro['prezzoRegolare'];

        $soldiDaRestituire = $libro['soldiDaRestituire'];

        $prezzoMercatino = $libro['prezzoMercatino'];

        $idStatoLibro = $libro['idStatoLibro'];
        $nomeStatoLibro = $sql->query("SELECT nomeStatoLibro FROM statiLibri WHERE idStatoLibro = '$idStatoLibro'")->fetch_array()['nomeStatoLibro'];
        $statiLibri .= '<option value="'.$idStatoLibro.'">'.$nomeStatoLibro.'</option><option value="null" disabled>-------</option>';

        //recupera lista portatori
        $result = $sql->query("SELECT * FROM portatoriLibri ORDER BY idPortatore DESC");
        if($result->num_rows==0){
            die("Nessuno ha portato libri, aggiungi prima una persona");
        }
        while ($utente = $result->fetch_assoc()){
            $utenti .= '<option value="'.$utente['idPortatore'].'">'.$utente['codicePortatore']." - ".$utente['nome']." ".$utente['cognome'].'</option>';
        }

        //recupera lista materie
        $result = $sql->query("SELECT * FROM materie");
        if($result->num_rows==0){
            die("Non hai inserito nessuna materia");
        }
        while ($materia = $result->fetch_assoc()){
            $materie .= '<option value="'.$materia['idMateria'].'">'.$materia['nomeMateria'].'</option>';
        }

        //recupera lista case editrici
        $result = $sql->query("SELECT * FROM caseEditrici");
        if($result->num_rows==0){
            die("Non hai inserito nessuna casa editrice");
        }
        while ($casaEditrice = $result->fetch_assoc()){
            $caseEditrici .= '<option value="'.$casaEditrice['idCasaEditrice'].'">'.$casaEditrice['nomeCasaEditrice'].'</option>';
        }

        //recupera lista tipi libri
        $result = $sql->query("SELECT * FROM tipiLibri");
        if($result->num_rows==0){
            die("Non hai inserito nessun tipo libro");
        }
        while ($tipo = $result->fetch_assoc()){
            $tipiLibri .= '<option value="'.$tipo['idTipoLibro'].'">'.$tipo['nomeTipoLibro'].'</option>';
        }

        //recupera lista tipi scuola
        $result = $sql->query("SELECT * FROM tipiScuola");
        if($result->num_rows==0){
            die("Non hai inserito nessun tipo scuola");
        }
        while ($tipo = $result->fetch_assoc()){
            $tipiScuole .= '<option value="'.$tipo['idTipoScuola'].'">'.$tipo['nomeTipoScuola'].'</option>';
        }

        //recupera lista stati libri
        $result = $sql->query("SELECT * FROM statiLibri");
        if($result->num_rows==0){
            die("Non hai inserito nessuno stato libro");
        }
        while ($stato = $result->fetch_assoc()){
            if($stato['idStatoLibro'] !== $_SESSION['impostazioni']['statoLibroInCarrello']) {
                $statiLibri .= '<option value="' . $stato['idStatoLibro'] . '">' . $stato['nomeStatoLibro'] . '</option>';
            }
        }

        //TODO: alla fine del form, se l'utente è amministratore aggiungere tasto per modificare tutti i libri che hanno lo stesso isbn


    }

    if($_SESSION['utente']['idRuolo'] == $_SESSION['impostazioni']['ruoloAdmin']){
        $modifyAllButton = '<input type="submit" name="modificaTutto" value="Modifica tutti i libri aventi questo codice">';
    }else{
        $modifyAllButton = '';
    }

    ?>

    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="originalISBN" value="<?php echo $codiceLibro; ?>">
        <input type="hidden" name="bookID" value="<?php echo $idLibro; ?>">
        <label for="codiceUtente">Cliente: </label>
        <select name="codiceUtente" id="codiceUtente">
            <?php echo $utenti; ?>
        </select><br>
        <label for="codiceLibro">Codice Libro:</label>
        <input type="text" name="codiceLibro" id="codiceLibro" value="<?php echo $codiceLibro; ?>" required><br>
        <label for="nomeLibro">Nome Libro:</label>
        <input type="text" name="nomeLibro" id="nomeLibro" value="<?php echo $nomeLibro; ?>" required><br>
        <label for="materia">Materia: </label>
        <select name="materia" id="materia">
            <?php echo $materie; ?>
        </select><br>
        <label for="casaEditrice">Casa Editrice: </label>
        <select name="casaEditrice" id="casaEditrice">
            <?php echo $caseEditrici; ?>
        </select><br>
        <label for="autore">Autore:</label>
        <input type="text" name="autore" id="autore" value="<?php echo $autore; ?>" required><br>
        <label for="tipoLibro">Tipo Libro / Volume: </label>
        <select name="tipoLibro" id="tipoLibro">
            <?php echo $tipiLibri; ?>
        </select><br>
        <label for="tipoScuola">Tipo Scuola: </label>
        <select name="tipoScuola" id="tipoScuola">
            <?php echo $tipiScuole; ?>
        </select><br>
        <label for="prezzoRegolare">Prezzo di vendita regolare:</label>
        <input type="text" name="prezzoRegolare" id="prezzoRegolare" value="<?php echo $prezzoRegolare; ?>" required><br>
        <label for="soldiDaRestituire">Soldi Da restituire al cliente:</label>
        <input type="number" name="soldiDaRestituire" id="soldiDaRestituire" value="<?php echo $soldiDaRestituire; ?>" required><br>
        <label for="prezzoMercatino">Prezzo mercatino:</label>
        <input type="number" name="prezzoMercatino" id="prezzoMercatino" value="<?php echo $prezzoMercatino; ?>" required><br>
        <label for="statoLibro">Stato Libro: </label>
        <select name="statoLibro" id="statoLibro">
            <?php echo $statiLibri; ?>
        </select><br>
        <label for="foto">Foto Libro:</label>
        <input type="file" accept="image/*" id="foto" name="foto" /><br>
        <input type="submit" name="modifica" value="Modifica">
        <?php echo $modifyAllButton; ?>
    </form>
    <?php
}elseif (isset($_GET['aggiungi'])){
    $idLibro = $_GET['aggiungi'];
    $idOperatore = $_SESSION['utente']['idUtente'];

    //UPDATE idStatoPrecedente con id attuale in tabella libri
    $idStatoLibro = $sql->query("select idStatoLibro from libri where idLibro = '$idLibro'")->fetch_array()['idStatoLibro'];
    $sql->query("update libri set idStatoPrecedente='$idStatoLibro' where idLibro='$idLibro'");
    if($sql->error){
        die($sql->error);
    }

    $sql->query("INSERT INTO carrello (idUtente, idLibro) VALUES ('$idOperatore', '$idLibro')");
    if ($sql->error){
        die($sql->error);
    }else{
        //UPDATE IDSTATOLIBRO CON ID STATO LIBRO IN CARRELLO
        //recupera da impostazioni
        $idStatoInCarrello = $_SESSION['impostazioni']['statoLibroInCarrello'];

        $sql->query("update libri set idStatoLibro = '$idStatoInCarrello' WHERE idLibro = '$idLibro'");
        if ($sql->error){
            die($sql->error);
        }else{
            echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'gestione/lista_libri.php">';
        }
    }

}else {

    if ($result->num_rows == 0) {
        die("Non ci sono libri");
    } else {
        while ($libro = $result->fetch_assoc()) {
            $idMateria = $libro['idMateria'];
            $idCasaEditrice = $libro['idCasaEditrice'];
            $idTipoLibro = $libro['idTipoLibro'];
            $idTipoScuola = $libro['idTipoScuola'];
            $idUtente = $libro['idOperatore'];
            $idStatoLibro = $libro['idStatoLibro'];
            $prezzoRegolare = $libro['prezzoRegolare'];
            $daRestituire = $libro['soldiDaRestituire'];
            $prezzoMercatino = $libro['prezzoMercatino'];
            $codiceLibro = $libro['codiceLibro'];

            $idFoto = $sql->query("SELECT idFoto FROM fotoCodiciLibri WHERE codiceLibro = '$codiceLibro'")->fetch_array()['idFoto'];
            $urlFotoLibro = $sql->query("SELECT urlFoto FROM fotoLibri where idFoto='$idFoto'")->fetch_array()['urlFoto'];

            $nomeMateria = $sql->query("SELECT nomeMateria FROM materie WHERE idMateria = '$idMateria'")->fetch_array()['nomeMateria'];
            $nomeCasaEditrice = $sql->query("SELECT nomeCasaEditrice FROM caseEditrici WHERE idCasaEditrice = '$idCasaEditrice'")->fetch_array()['nomeCasaEditrice'];
            $nomeTipoLibro = $sql->query("SELECT nomeTipoLibro FROM tipiLibri WHERE idTipoLibro = '$idTipoLibro'")->fetch_array()['nomeTipoLibro'];
            $nomeTipoScuola = $sql->query("SELECT nomeTipoScuola FROM tipiScuola WHERE idTipoScuola = '$idTipoScuola'")->fetch_array()['nomeTipoScuola'];
            $nomeOperatore = $sql->query("SELECT nome FROM utenti WHERE idUtente = '$idUtente'")->fetch_array()['nome'];
            $nomeStatoLibro = $sql->query("SELECT nomeStatoLibro FROM statiLibri WHERE idStatoLibro = '$idStatoLibro'")->fetch_array()['nomeStatoLibro'];
            $codiceCliente = $libro['codicePortatore'];
            $codiceCliente = $sql->query("SELECT codicePortatore FROM portatoriLibri WHERE idPortatore = '$codiceCliente'")->fetch_array()['codicePortatore'];

//            $fotoLibro = $libro['idFotoLibro'];
//            $fotoLibro = $sql->query("select urlFoto from fotoLibri where idFoto='$fotoLibro'")->fetch_array()['urlFoto'];

            if ($idStatoLibro !== $_SESSION['impostazioni']['statoLibroInCarrello'] && $idStatoLibro !== $_SESSION['impostazioni']['statoLibroVenduto'] && $idStatoLibro !== $_SESSION['impostazioni']['statoLibroRitirato']) {
                $aHrefAggiungiACarrello = "<a href='" . $siteURL . "gestione/lista_libri.php?aggiungi=" . $libro['idLibro'] . "'>Aggiungi</a>";
            } else {
                $aHrefAggiungiACarrello = "Aggiungi";
            }

            $data .= "
                <tr>
                    <td><img src='" . $urlFotoLibro . "'></td>
                    <td>" . $libro['nomeLibro'] . "</td>
                    <td>" . $codiceLibro . "</td>
                    <td>" . $nomeMateria . "</td>
                    <td>" . $nomeCasaEditrice . "</td>
                    <td>" . $libro['autoreLibro'] . "</td>
                    <td>" . $nomeTipoLibro . "</td>
                    <td>" . $nomeTipoScuola . "</td>
                    <td>" . $codiceCliente . "</td>
                    <td>" . $nomeOperatore . "</td>
                    <td>" . $prezzoRegolare . "</td>
                    <td>" . $daRestituire . "</td>
                    <td>" . $prezzoMercatino . "</td>
                    <td>" . $nomeStatoLibro . "</td>
                    <td>" . $aHrefAggiungiACarrello . "</td>
                    <td><a href='" . $siteURL . "gestione/lista_libri.php?modificaLibro=" . $libro['idLibro'] . "'</a>Modifica</td>
                    <td><a href='" . $siteURL . "gestione/cataloga_libro.php?duplica=" . $libro['codiceLibro'] . "'>Duplica</a></td>
                    <td><a href='" . $siteURL . "gestione/lista_libri.php?eliminaLibro=" . $libro['idLibro'] . "'>Elimina</a></td>
                </tr>";
        }
        ?>

        <style>
            table.dataTable thead .sorting:after,
            table.dataTable thead .sorting:before,
            table.dataTable thead .sorting_asc:after,
            table.dataTable thead .sorting_asc:before,
            table.dataTable thead .sorting_asc_disabled:after,
            table.dataTable thead .sorting_asc_disabled:before,
            table.dataTable thead .sorting_desc:after,
            table.dataTable thead .sorting_desc:before,
            table.dataTable thead .sorting_desc_disabled:after,
            table.dataTable thead .sorting_desc_disabled:before {
                bottom: .5em;
            }

            div.dataTables_wrapper {
                margin: 0 auto;
            }
        </style>

        <table id="myTable" class="table display nowrap table-bordered" width="99.9%">
            <thead>
            <tr class="header">
                <th>Foto Libro</th>
                <th>Nome Libro</th>
                <th>Codice Libro</th>
                <th>Materia</th>
                <th>Casa Editrice</th>
                <th>Autore</th>
                <th>Volume</th>
                <th>Tipo Scuola</th>
                <th>Codice Cliente</th>
                <th>Catalogato Da</th>
                <th>Prezzo Negozio</th>
                <th>Da Restituire</th>
                <th>Prezzo Mercatino</th>
                <th>Stato Libro</th>
                <th>Carrello</th>
                <th>Modifica</th>
                <th>Duplica</th>
                <th>Elimina</th>
            </tr>
            </thead>
            <tbody>
            <?php echo $data; ?>
            </tbody>
        </table>

        <script>
            $(document).ready(function () {
                $('#myTable').DataTable({
                    "scrollX": true
                });
            });
        </script>

        <?php
    }
}
include '../footer.php';