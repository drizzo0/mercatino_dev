<?php
include 'header.php';
$data = '';
if($_SERVER['REQUEST_METHOD']=='POST'){
    $nomeStato = $_POST['nome'];
    $risultatoQuery = $sql->query("SELECT * FROM statiLibri WHERE nomeStatoLibro='$nomeStato'");
    if($risultatoQuery->num_rows>0){
        die("stato esistente");
    }else{
        $sql->query("INSERT INTO statiLibri (nomeStatoLibro) VALUES ('$nomeStato')");
        $errore = $sql->error;
        if($errore){
            die($errore);
        }else{
            echo '<meta http-equiv="refresh" content="0">';
        }
    }
}elseif ($_SERVER['REQUEST_METHOD']=='GET'){
    if(isset($_GET['eliminaStato'])){
        $idStatoDaEliminare = $_GET['eliminaStato'];
        $sql->query("DELETE FROM statiLibri WHERE idStatoLibro = '$idStatoDaEliminare'");
        $errore = $sql->error;
        if($errore){
            die($errore);
        }else{
            echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'gestione/stati_libri.php">';
        }
    } ?>

    <form method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome">
        <input type="submit" name="inserisci" value="Inserisci">
    </form>

    <?php
    $result = $sql->query("SELECT * FROM statiLibri");
    if($result->num_rows==0){
        echo "Non hai stati";
    }else{
        while ($stato = $result->fetch_assoc()){
            $data .= "<tr><td>".$stato['idStatoLibro']."</td><td>".$stato['nomeStatoLibro']."</td><td><a href='stati_libri.php?eliminaStato=".$stato['idStatoLibro']."'>Elimina</a></td></tr>";
        } ?>

        <table>
            <tr><td>ID Stato</td><td>Nome Stato</td><td>Elimina Stato</td></tr>
            <?php echo $data; ?>
        </table>

        <?php
    }

}

include "../footer.php";