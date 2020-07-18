<?php
include 'header.php';

$userID = $_SESSION['utente']['idUtente'];

$utenti = '';
$codiceLibro = '';
$materie = '';
$caseEditrici = '';
$nomeLibro = '';
$tipiLibri = '';
$autore = '';
$prezzoRegolare = '';
$tipiScuole = '';
$statiLibri = '';
$soldiDaRestituire = 0;
$prezzoMercatino = 0;
if($_SERVER['REQUEST_METHOD']=='POST'){

    $codicePortatore = $_POST['codiceUtente'];
    $codiceLibro = $_POST['codiceLibro'];
    $nomeLibro = $_POST['nomeLibro'];
    $idMateria = $_POST['materia'];
    $idCasaEditrice = $_POST['casaEditrice'];
    $autore = $_POST['autore'];
    $idTipoScuola = $_POST['tipoScuola'];
    $idTipoLibro = $_POST['tipoLibro'];
    $prezzoRegolare = $_POST['prezzoRegolare'];
    $soldiDaRestituire = $_POST['soldiDaRestituire'];
    $prezzoMercatino = $_POST['prezzoMercatino'];
    $idStatoLibro = $_POST['statoLibro'];

    $fileError = $_FILES["FILE_NAME"]["error"];
    switch($fileError) {
        case UPLOAD_ERR_INI_SIZE:
            die("File troppo grande, caricane un altro!");
            break;
        case UPLOAD_ERR_PARTIAL:
            die("File troppo grande, caricane un altro!");
            break;
        case UPLOAD_ERR_NO_FILE:
            // No file was uploaded
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            die("Impossibile scrivere nella cartella temporanea! - Contattare Daniele");
            break;
        case UPLOAD_ERR_CANT_WRITE:
            die("Impossibile scrivere il file sul disco! - Contattare Daniele");
            break;
        default:
            $file_name = $_FILES['foto']['name'];
            $file_tmp = $_FILES['foto']['tmp_name'];
            $file_ext = strtolower(end(explode('.', $_FILES['foto']['name'])));
            $time = time();
            $file_name_new = $codiceLibro . "_" . $time . "." . $file_ext;

            move_uploaded_file($file_tmp, "../immagini/" . $file_name_new);
            $url = $siteURL . 'immagini/' . $file_name_new;
            $sql->query("INSERT INTO fotoLibri (urlFoto,caricatoDaIdUtente,dataCaricamento) VALUES ('$url','$userID','$time')");
            $idFoto = $sql->query("SELECT * from fotoLibri WHERE urlFoto = '$url'")->fetch_array()['idFoto'];
            if ($sql->query("SELECT * FROM fotoCodiciLibri WHERE codiceLibro = '$codiceLibro'")->num_rows > 0) {
                $sql->query("UPDATE fotoCodiciLibri SET idFoto = '$idFoto' WHERE codiceLibro = '$codiceLibro'");
            } else {
                $sql->query("INSERT INTO fotoCodiciLibri (idFoto, codiceLibro) VALUES ('$idFoto','$codiceLibro')");
            }
            break;
    }

    $sql->query("INSERT INTO libri (idOperatore, idOperatoreModifica, codicePortatore, codiceLibro, nomeLibro, idMateria, idCasaEditrice, autoreLibro, idTipoLibro, idTipoScuola, prezzoRegolare, soldiDaRestituire, prezzoMercatino, idStatoLibro) VALUES ('$userID', '$userID', '$codicePortatore', '$codiceLibro', '$nomeLibro', '$idMateria', '$idCasaEditrice', '$autore', '$idTipoLibro', '$idTipoScuola', '$prezzoRegolare', '$soldiDaRestituire', '$prezzoMercatino', '$idStatoLibro')");
    $error = $sql->error;
    if($error){
        die($error);
    }else{
        echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'gestione/lista_libri.php">';
    }


}elseif ($_SERVER['REQUEST_METHOD']=='GET'){

    if(isset($_GET['duplica'])){
        $codiceLibro = $_GET['duplica'];
        $query = "SELECT * FROM libri WHERE codiceLibro = '$codiceLibro'";
        $result = $sql->query($query);
        if($result->num_rows==0){
            echo "Non esiste un libro con questo codice";
        }else{
            $libro = $result->fetch_array();

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

        }

    }elseif (isset($_GET['creaDaCodice'])){
        //TODO: che cazzo stavo facendo qui?
        $codiceLibro = $_GET['creaDaCodice'];
    }

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

    ?>

    <!--- MOSTRA FORM PER CATALOGARE -->
    <form method="post" enctype="multipart/form-data">

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
        <input type="submit" name="cataloga" value="Cataloga">
    </form>

<?php
}

    include "../footer.php";