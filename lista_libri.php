
<?php
    include "header.php";
    $data = '';

    //TODO: Prenota

    $statoLibroInSede = $_SESSION['impostazioni']['statoLibroInSede'];

    if(isset($_GET['prenota'])){
        print_r($_GET);
    }

    $query = "SELECT * FROM libri WHERE idStatoLibro = '$statoLibroInSede'";
    $result = $sql->query($query);
    if($result->num_rows==0){
        die("Non ci sono libri");
    }else{
        while ($libro = $result->fetch_assoc()){
            $idMateria = $libro['idMateria'];
            $idCasaEditrice = $libro['idCasaEditrice'];
            $idTipoLibro = $libro['idTipoLibro'];
            $idTipoScuola = $libro['idTipoScuola'];

            $nomeMateria = $sql->query("SELECT nomeMateria FROM materie WHERE idMateria = '$idMateria'")->fetch_array()['nomeMateria'];
            $nomeCasaEditrice = $sql->query("SELECT nomeCasaEditrice FROM caseEditrici WHERE idCasaEditrice = '$idCasaEditrice'")->fetch_array()['nomeCasaEditrice'];
            $nomeTipoLibro = $sql->query("SELECT nomeTipoLibro FROM tipiLibri WHERE idTipoLibro = '$idTipoLibro'")->fetch_array()['nomeTipoLibro'];
            $nomeTipoScuola = $sql->query("SELECT nomeTipoScuola FROM tipiScuola WHERE idTipoScuola = '$idTipoScuola'")->fetch_array()['nomeTipoScuola'];
            $fotoLibro = $libro['idFotoLibro'];
            $fotoLibro = $sql->query("select urlFoto from fotoLibri where idFoto='$fotoLibro'")->fetch_array()['urlFoto'];
            if($_SESSION['impostazioni']['prenotazioniAbilitate']==1){
                $prenota="<td><a href='".$_SESSION['impostazioni']['siteURL']."lista_libri.php?prenota=".$libro['idLibro']."'>Prenota</a></td>";
            }

            $data .= "
                <tr>
                    <td>" .$fotoLibro."</td>
                    <td>".$libro['nomeLibro']."</td>
                    <td>".$libro['codiceLibro']."</td>
                    <td>".$nomeMateria."</td>
                    <td>".$nomeCasaEditrice."</td>
                    <td>".$libro['autoreLibro']."</td>
                    <td>".$nomeTipoLibro."</td>
                    <td>".$nomeTipoScuola."</td>
                    ".$prenota."
                </tr>";
        }
        ?>

        <title>Lista Libri</title>
        
        <table id="myTable" class="table table-striped table-dark" width="99.9%" >
            <thead>
            <tr class="header">
                <th>Foto Libro</th>
                <th>Libro</th>
                <th>Codice Libro</th>
                <th>Materia</th>
                <th>Casa Editrice</th>
                <th>Autore</th>
                <th>Volume</th>
                <th>Tipo Scuola</th>
                <?php if($_SESSION['impostazioni']['prenotazioniAbilitate']==1){ ?>
                    <th>Prenota</th>
                <?php } ?>
            </tr>
            </thead>
            <tbody>
            <?php echo $data; ?>
            </tbody>
        </table>
        <script>
            $(document).ready(function() { 
                var table = $('#myTable').DataTable( { "scrollX": true } ); 
            } );
        </script>

    <?php
    }

    include 'footer.php';