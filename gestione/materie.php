<?php
    include 'header.php';
    $data = '';
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $nomeMateria = $_POST['nome'];
        $risultatoQuery = $sql->query("SELECT * FROM materie WHERE nomeMateria='$nomeMateria'");
        if($risultatoQuery->num_rows>0){
            die("materia esistente");
        }else{
            $sql->query("INSERT INTO materie (nomeMateria) VALUES ('$nomeMateria')");
            $errore = $sql->error;
            if($errore){
                die($errore);
            }else{
                echo '<meta http-equiv="refresh" content="0">';
            }
        }
    }elseif ($_SERVER['REQUEST_METHOD']=='GET'){
        if(isset($_GET['eliminaMateria'])){
            $idMateriaDaEliminare = $_GET['eliminaMateria'];
            $sql->query("DELETE FROM materie WHERE idMateria = '$idMateriaDaEliminare'");
            $errore = $sql->error;
            if($errore){
                die($errore);
            }else{
                echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'gestione/materie.php">';
            }
        } ?>

        <form method="post">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome">
            <input type="submit" name="inserisci" value="Inserisci">
        </form>

        <?php
        $result = $sql->query("SELECT * FROM materie");
        if($result->num_rows==0){
            echo "Non hai materie";
        }else{
            while ($materia = $result->fetch_assoc()){
                $data .= "<tr><td>".$materia['idMateria']."</td><td>".$materia['nomeMateria']."</td><td><a href='materie.php?eliminaMateria=".$materia['idMateria']."'>Elimina</a></td></tr>";
            } ?>

            <table>
                <tr><td>ID Materia</td><td>Nome Materia</td><td>Elimina Materia</td></tr>
                <?php echo $data; ?>
            </table>
            <?php
        }
    }
    include '../footer.php';