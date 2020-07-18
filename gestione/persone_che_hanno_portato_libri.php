<?php

$dataUltimoAccesso = date('Y-m-d H:i:s');
$ipUltimoAccesso = '0.0.0.0';

include 'header.php';
$data = '';
if($_SERVER['REQUEST_METHOD']=='POST'){
    $codiceUtente = $_POST['codiceUtente'];
    $password = $_POST['password'];
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $risultatoQuery = $sql->query("SELECT * FROM portatoriLibri WHERE codicePortatore='$codiceUtente'");
    if($risultatoQuery->num_rows>0){
        die("Codice utente esistente");
    }else{
        $sql->query("INSERT INTO portatoriLibri (codicePortatore, password, dataUltimoAccesso, ipUltimoAccesso, nome, cognome) VALUES ('$codiceUtente', '$password', '$dataUltimoAccesso', '$ipUltimoAccesso', '$nome', '$cognome')");
        $errore = $sql->error;
        if($errore){
            die($errore);
        }else{
            echo '<meta http-equiv="refresh" content="0">';
            header('refresh: 0');
        }
    }
}elseif ($_SERVER['REQUEST_METHOD']=='GET'){
    if(isset($_GET['eliminaUtente'])){
        $idPortatore = $_GET['eliminaUtente'];
        $sql->query("DELETE FROM portatoriLibri WHERE idPortatore = '$idPortatore'");
        $errore = $sql->error;
        if($errore){
            die($errore);
        }else{
            echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'gestione/persone_che_hanno_portato_libri.php">';
        }
    } ?>

    <form method="post">
        <label for="codiceUtente">Codice Utente:</label>
        <input type="text" id="codiceUtente" name="codiceUtente">
        <label for="password">Password:</label>
        <input type="text" id="password" name="password">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome">
        <label for="cognome">Cognome:</label>
        <input type="text" id="cognome" name="cognome">
        <input type="submit" name="inserisci" value="Inserisci">
    </form>

    <?php
    $result = $sql->query("SELECT * FROM portatoriLibri");
    if($result->num_rows==0){
        echo "Non hai persone";
    }else{
        while ($utente = $result->fetch_assoc()){
            $data .= "<tr><td>".$utente['idPortatore']."</td><td>".$utente['codicePortatore']."</td><td>".$utente['password']."</td><td>".$utente['nome']."</td><td>".$utente['cognome']."</td><td>".$utente['dataUltimoAccesso']."</td><td>".$utente['ipUltimoAccesso']."</td><td><a href='persone_che_hanno_portato_libri.php?eliminaUtente=".$utente['idPortatore']."'>Elimina</a></td></tr>";
        } ?>
        
        <style>
            div.dataTables_wrapper {
                margin: 0 auto;
            }
        </style>
        
        <table id="myTable" class="table display nowrap table-bordered" width="99.9%">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Codice Utente</td>
                    <td>Password</td>
                    <td>Nome</td>
                    <td>Cognome</td>
                    <td>Ultimo Accesso</td>
                    <td>Ultimo IP</td>
                    <td>Elimina Utente</td>
                </tr>
            </thead>
            <tbody><?php echo $data; ?></tbody>
        </table>
        <script>$(document).ready(function() { $('#myTable').DataTable( { "scrollX": true } ); } );</script>
        <?php
    }

}


include "../footer.php";