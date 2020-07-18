<?php
    include 'header.php';
    $data = '';
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $nomeCasaEditrice = $_POST['nome'];
        $query = "SELECT * FROM caseEditrici WHERE nomeCasaEditrice='$nomeCasaEditrice'";
        $risultatoQuery = $sql->query($query);
        if($risultatoQuery->num_rows>0){
            die("casa editrice esistente");
        }else{
            $query = "INSERT INTO caseEditrici (nomeCasaEditrice) VALUES ('$nomeCasaEditrice')";
            $sql->query($query);
            $errore = $sql->error;
            if($errore){
                die($errore);
            }else{
                echo '<meta http-equiv="refresh" content="0">';
            }
        }
    }elseif ($_SERVER['REQUEST_METHOD']=='GET'){
        if(isset($_GET['eliminaCasaEditrice'])){
            $idCasaDaEliminare = $_GET['eliminaCasaEditrice'];
            $query = "DELETE FROM caseEditrici WHERE idCasaEditrice = '$idCasaDaEliminare'";
            $sql->query($query);
            $errore = $sql->error;
            if($errore){
                die($errore);
            }else{
                echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'gestione/case_editrici.php">';
            }
        } ?>

        <form method="post">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome">
            <input type="submit" name="inserisci" value="Inserisci">
        </form>

    <?php

        $query = "SELECT * FROM caseEditrici";
        $result = $sql->query($query);
        if($result->num_rows==0){
            echo "Non hai case editrici";
        }else{
            while ($casaEditrice = $result->fetch_assoc()){
                $data .= "<tr><td>".$casaEditrice['idCasaEditrice']."</td><td>".$casaEditrice['nomeCasaEditrice']."</td><td><a href='case_editrici.php?eliminaCasaEditrice=".$casaEditrice['idCasaEditrice']."'>Elimina</a></td></tr>";
            } ?>

            <table>
                <tr><td>ID Casa Editrice</td><td>Nome Casa Editrice</td><td>Elimina Casa Editrice</td></tr>
                <?php echo $data; ?>
            </table>

        <?php
        }

    }

    include "../footer.php";