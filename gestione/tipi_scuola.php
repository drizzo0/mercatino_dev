<?php
include 'header.php';
$data = '';
if($_SERVER['REQUEST_METHOD']=='POST'){
    $nomeTipo = $_POST['nome'];
    $risultatoQuery = $sql->query("SELECT * FROM tipiScuola WHERE nomeTipoScuola='$nomeTipo'");
    if($risultatoQuery->num_rows>0){
        die("tipo scuola esistente");
    }else{
        $sql->query("INSERT INTO tipiScuola (nomeTipoScuola) VALUES ('$nomeTipo')");
        $errore = $sql->error;
        if($errore){
            die($errore);
        }else{
            echo '<meta http-equiv="refresh" content="0">';        }
    }
}elseif ($_SERVER['REQUEST_METHOD']=='GET'){
    if(isset($_GET['eliminaTipo'])){
        $idTipoDaEliminare = $_GET['eliminaTipo'];
        $sql->query("DELETE FROM tipiScuola WHERE idTipoScuola = '$idTipoDaEliminare'");
        $errore = $sql->error;
        if($errore){
            die($errore);
        }else{
            echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'gestione/tipi_scuola.php">';
        }
    } ?>

    <form method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome">
        <input type="submit" name="inserisci" value="Inserisci">
    </form>

    <?php

    $query = "SELECT * FROM tipiScuola";
    $result = $sql->query($query);
    if($result->num_rows==0){
        echo "Non hai tipi scuola";
    }else{
        while ($tipo = $result->fetch_assoc()){
            $data .= "<tr><td>".$tipo['idTipoScuola']."</td><td>".$tipo['nomeTipoScuola']."</td><td><a href='tipi_scuola.php?eliminaTipo=".$tipo['idTipoScuola']."'>Elimina</a></td></tr>";
        } ?>

        <table>
            <tr><td>ID Tipo</td><td>Nome Tipo</td><td>Elimina Tipo</td></tr>
            <?php echo $data; ?>
        </table>

        <?php
    }

}
include '../footer.php';