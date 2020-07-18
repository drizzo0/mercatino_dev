<?php
include 'header.php';
$data = '';
$ruoli = '';


if ($_SERVER['REQUEST_METHOD']=='POST'){

    $idRuolo = $_POST['ruolo'];
    $idUtente = $_POST['userID'];

    $sql->query("UPDATE ruoliUtente SET idRuolo = '$idRuolo' WHERE idUtente = '$idUtente'");
    if($sql->error){
        die($sql->error);
    }
    echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'amministrazione/utenti.php">';

}else {

    if (isset($_GET['modificaID'])){
        $userID = $_GET['modificaID'];
        $user=$sql->query("SELECT * FROM utenti WHERE idUtente = '$userID'")->fetch_array();

        $trovaRuoloAttuale = $sql->query("SELECT idRuolo FROM ruoliUtente WHERE idUtente = '$userID'");
        $trovaRuoloAttuale = $trovaRuoloAttuale->fetch_array();
        $ruoloAttuale = $trovaRuoloAttuale['idRuolo'];
        $trovaNomeRuoloAttuale = $sql->query("SELECT nomeRuolo from ruoli WHERE idRuolo = '$ruoloAttuale'");
        $trovaNomeRuoloAttuale = $trovaNomeRuoloAttuale->fetch_array();
        $nomeRuoloAttuale = $trovaNomeRuoloAttuale['nomeRuolo'];
        $ruoli .= '<option value="'.$ruoloAttuale.'">'.$nomeRuoloAttuale.'</option>';
        $ruoli .= '<option value="null" disabled>-------</option>';
        $listaRuoli = $sql->query("SELECT * FROM ruoli");
        while ($ruoloLista = $listaRuoli->fetch_assoc()){
            $ruoli .= '<option value="'.$ruoloLista['idRuolo'].'">'.$ruoloLista['nomeRuolo'].'</option>';
        }

        ?>

        <form method="post" action="utenti.php">
            <label for="userID">ID Utente:</label>
            <input type="text" id="userID" name="userID" value="<?php echo $user['idUtente']; ?>" readonly><br>
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $user['nome']; ?>" readonly><br>
            <label for="cognome">Cognome:</label>
            <input type="text" id="cognome" name="cognome" value="<?php echo $user['cognome']; ?>" readonly><br>
            <label for="ruolo">Ruolo: </label>
            <select name="ruolo" id="ruolo">
                <?php echo $ruoli; ?>
            </select><br>
            <input type="submit" name="modifica" value="Modifica Utente">
        </form>

        <?php
    } else {
        $query = "SELECT * FROM utenti ";
        $result = $sql->query($query);

        if ($result->num_rows == 0) {
            die("Non ci sono utenti");
        } else {
            while ($utente = $result->fetch_assoc()) {
                $abilitato = $utente['abilitato'];
                if ($abilitato == 1) {
                    $abilitato = "Si";
                } else {
                    $abilitato = "No";
                }
                $userID = $utente['idUtente'];
                $idRuolo = $sql->query("SELECT idRuolo FROM ruoliUtente WHERE idUtente = '$userID'")->fetch_array()['idRuolo'];
                $ruolo = $sql->query("SELECT nomeRuolo FROM ruoli WHERE idRuolo = '$idRuolo'")->fetch_array()['nomeRuolo'];
                $data .= "
                <tr>
                    <td>" . $userID . "</td>
                    <td>" . $utente['username'] . "</td>
                    <td>" . $utente['email'] . "</td>
                    <td>" . $utente['nome'] . "</td>
                    <td>" . $utente['cognome'] . "</td>
                    <td>" . $utente['dataRegistrazione'] . "</td>
                    <td>" . $utente['dataUltimoAccess'] . "</td>
                    <td>" . $utente['ipRegistrazione'] . "</td>
                    <td>" . $utente['ipUltimoAccesso'] . "</td>
                    <td>" . $abilitato . "</td>
                    <td>" . $ruolo . "</td>
                    <td><a href='" . $siteURL . "amministrazione/utenti.php?modificaID=" . $utente['idUtente'] . "'>Modifica</a></td>
                </tr>";
            }
            ?>

            <table id="myTable" class="table display table-bordered" width="99.9%">
                <thead>
                <tr>
                    <td>ID Utente</td>
                    <td>Username</td>
                    <td>Email</td>
                    <td>Nome</td>
                    <td>Cognome</td>
                    <td>Data Registrazione</td>
                    <td>Ultimo Accesso</td>
                    <td>IP Registrazione</td>
                    <td>Ultimo IP</td>
                    <td>Abilitato</td>
                    <td>Ruolo</td>
                    <td>Modifica</td>
                </tr>
                </thead>
                <tbody>
                <?php echo $data; ?>
                </tbody>
            </table>
            <script>$(document).ready(function() { $('#myTable').DataTable( {  "scrollX": true } ); } );</script>
            <?php
        }
    }
}

include "../footer.php";