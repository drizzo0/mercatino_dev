<?php
    include "header.php";
    $lista = '';
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $codiceUtente = $_POST['codiceUtente'];
        $password = $_POST['password'];
        $selezionaUtente = $sql->query("SELECT * FROM portatoriLibri WHERE codicePortatore = '$codiceUtente'");
        if($selezionaUtente->num_rows==0){
            die("Codice utente non corretto");
        }else{
            $selezionaUtente = $selezionaUtente->fetch_array();
            $idPortatore = $selezionaUtente['idPortatore'];
            if($password == $selezionaUtente['password']){
                $data = date('Y-m-d H:i:s');
                $ip = $Core->getUserIpAddr();
                $sql->query("update portatoriLibri set ipUltimoAccesso='$ip' where idPortatore='$idPortatore'");
                $sql->query("update portatoriLibri set dataUltimoAccesso='$data' where idPortatore='$idPortatore'");

                $libri = $sql->query("SELECT * FROM libri WHERE codicePortatore = '$idPortatore'");
                if($libri->num_rows==0){
                    die("Non hai portato libri");
                }else{
                    while ($libro = $libri->fetch_assoc()){
                        $codiceLibro = $libro['codiceLibro'];
                        $nomeLibro = $libro['nomeLibro'];
                        $idMateria = $libro['idMateria'];
                        $idCasaEditrice = $libro['idCasaEditrice'];
                        $autoreLibro = $libro['autoreLibro'];
                        $idTipoLibro = $libro['idTipoLibro'];
                        $idStatoLibro = $libro['idStatoLibro'];

                        $nomeMateria = $sql->query("SELECT nomeMateria FROM materie WHERE idMateria = '$idMateria'")->fetch_array()['nomeMateria'];
                        $nomeCasaEditrice = $sql->query("SELECT nomeCasaEditrice FROM caseEditrici WHERE idCasaEditrice = '$idCasaEditrice'")->fetch_array()['nomeCasaEditrice'];
                        $nomeTipoLibro = $sql->query("SELECT nomeTipoLibro FROM tipiLibri WHERE idTipoLibro = '$idTipoLibro'")->fetch_array()['nomeTipoLibro'];
                        $nomeStatoLibro = $sql->query("SELECT nomeStatoLibro FROM statiLibri WHERE idStatoLibro = '$idStatoLibro'")->fetch_array()['nomeStatoLibro'];

                        $fotoLibro = $libro['idFotoLibro'];
                        $fotoLibro = $sql->query("select urlFoto from fotoLibri where idFoto='$fotoLibro'")->fetch_array()['urlFoto'];

                        $lista .= "
                            <tr>
                                <td>$fotoLibro</td>
                                <td>$codiceLibro</td>
                                <td>$nomeLibro</td>
                                <td>$nomeMateria</td>
                                <td>$nomeCasaEditrice</td>
                                <td>$autoreLibro</td>
                                <td>$nomeTipoLibro</td>
                                <td>$nomeStatoLibro</td>
                            </tr>
                        ";
                    }
                    ?>

                    <table id="myTable" class="table display table-bordered" width="99.9%">
                        <thead>
                        <tr>
                            <td>Foto Libro</td>
                            <td>Codice Libro</td>
                            <td>Nome Libro</td>
                            <td>Materia</td>
                            <td>Casa Editrice</td>
                            <td>Autore</td>
                            <td>Volume</td>
                            <td>Stato</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php echo $lista; ?>
                        </tbody>
                    </table>
                    <script>
                        $(document).ready(function() {
                            $('#myTable').DataTable( { 
                                "scrollX": true
                            } ); 
                        } );
                    </script>
                    <?php
                }
            }else{
                die("Password non corretta.");
            }
        }
    }else{
        ?>

        <title>I miei libri</title>

        <div class="container rounded col-md-6 py-2">
            <div class="card rounded align-content-center text-center">
                <div class="card-header">
                    Inserisci i tuoi dati di accesso per visualizzare lo stato dei tuoi libri.
                </div>
                <div class="card-body align-content-center text-center"></div>
                    <form method="post" action="libri_portati.php">
                        <div class="form-group">
                            <label id="codiceUtente">Codice Utente:</label>
                            <input class="form-control" type="text" id="codiceUtente" name="codiceUtente">
                        </div>
                        <div class="form-group">
                            <label id="password">Password:</label>
                            <input class="form-control" type="password" id="password" name="password">
                        </div>
                        <input type="submit" name="accedi" value="Accedi">
                    </form>
                </div>
            </div>
        </div>
        <?php
    }

    include 'footer.php';