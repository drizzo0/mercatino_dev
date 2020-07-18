<?php
include 'header.php';
$data = '';
if($_SERVER['REQUEST_METHOD']=='POST'){
    $nomeTipo = $_POST['nome'];
    $risultatoQuery = $sql->query("SELECT * FROM tipiLibri WHERE nomeTipoLibro='$nomeTipo'");
    if($risultatoQuery->num_rows>0){
        die("tipo libro esistente");
    }else{
        $sql->query("INSERT INTO tipiLibri (nomeTipoLibro) VALUES ('$nomeTipo')");
        $errore = $sql->error;
        if($errore){
            die($errore);
        }else{
            echo '<meta http-equiv="refresh" content="0">';
        }
    }
}elseif ($_SERVER['REQUEST_METHOD']=='GET'){
    if(isset($_GET['eliminaTipo'])){
        $idTipoDaEliminare = $_GET['eliminaTipo'];
        $sql->query("DELETE FROM tipiLibri WHERE idTipoLibro = '$idTipoDaEliminare'");
        $errore = $sql->error;
        if($errore){
            die($errore);
        }else{
            echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'gestione/tipi_libri.php">';
        }
    } ?>

    <form method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome">
        <input type="submit" name="inserisci" value="Inserisci">
    </form>

    <?php
    $result = $sql->query("SELECT * FROM tipiLibri");
    if($result->num_rows==0){
        echo "Non hai tipi libri";
    }else{
        while ($tipo = $result->fetch_assoc()){
            $data .= "<tr><td>".$tipo['idTipoLibro']."</td><td>".$tipo['nomeTipoLibro']."</td><td><a href='tipi_libri.php?eliminaTipo=".$tipo['idTipoLibro']."'>Elimina</a></td></tr>";
        } ?>
        <table>
            <tr><td>ID Tipo</td><td>Nome Tipo</td><td>Elimina Tipo</td></tr>
            <?php echo $data; ?>
        </table>
        <?php
    }
}

include '../footer.php';
