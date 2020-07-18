<?php
    include 'header.php';
    $idUtente = $_SESSION['utente']['idUtente'];
    if ($_GET['azione']=="Venduti"){
        //metti libri in stato venduto

        $libriInCarrello = $sql->query("select * from carrello where idUtente='$idUtente'");
        while ($libroCorrente = $libriInCarrello->fetch_assoc()){
            $statoLibroVenduto = $_SESSION['impostazioni']['statoLibroVenduto'];
            $idLibroCorrente = $libroCorrente['idLibro'];
            $sql->query("update libri set idStatoLibro='$statoLibroVenduto' where idLibro='$idLibroCorrente'");
            if($sql->error){
                die($sql->error);
            }
        }

        $sql->query("delete from carrello where idUtente = '$idUtente'");
        if($sql->error){
            die($sql->error);
        }

        echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'gestione/lista_libri.php">';

    }elseif($_GET['azione']=='Svuota'){
        //Togli tutti i libri e ripristina lo stato precedente
        $libriInCarrello = $sql->query("select * from carrello where idUtente='$idUtente'");
        while ($libroCorrente = $libriInCarrello->fetch_assoc()){
            $idLibro = $libroCorrente['idLibro'];
            $sql->query("DELETE FROM carrello WHERE idLibro='$idLibro' AND idUtente='$idUtente'");
            if($sql->error){
                die($sql->error);
            }else{

                $idStatoPrecedente = $sql->query("select idStatoPrecedente from libri where idLibro='$idLibro'");
                $idStatoPrecedente=$idStatoPrecedente->fetch_array();
                $idStatoPrecedente=$idStatoPrecedente['idStatoPrecedente'];
                $sql->query("update libri set idStatoLibro='$idStatoPrecedente' where idLibro='$idLibro'");
                if($sql->error){
                    die($sql->error);
                }
                echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'gestione/lista_libri.php">';
            }

        }
    }

    if(isset($_GET['elimina'])){
        $idLibro = $_GET['elimina'];
        $sql->query("DELETE FROM carrello WHERE idLibro='$idLibro' AND idUtente='$idUtente'");
        if($sql->error){
            die($sql->error);
        }else{

            $idStatoPrecedente = $sql->query("select idStatoPrecedente from libri where idLibro='$idLibro'");
            $idStatoPrecedente=$idStatoPrecedente->fetch_array();
            $idStatoPrecedente=$idStatoPrecedente['idStatoPrecedente'];
            $sql->query("update libri set idStatoLibro='$idStatoPrecedente' where idLibro='$idLibro'");
            if($sql->error){
                die($sql->error);
            }
            echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'gestione/carrello.php">';
        }
    }

    $data = '';
    $prezzoFinale = 0;
    $carrello = $sql->query("SELECT * FROM carrello where idUtente = '$idUtente'");
    while ($libri = $carrello->fetch_assoc()){
        $idLibro = $libri['idLibro'];
        $libro = $sql->query("SELECT * FROM libri WHERE idLibro = '$idLibro'");
        $libro = $libro->fetch_array();
        $prezzoFinale = $prezzoFinale + $libro['prezzoMercatino'];
        $data .= "
            <tr>
                <td>".$libro['nomeLibro']."</td>
                <td>".$libro['codiceLibro']."</td>
                <td>".$libro['idMateria']."</td>
                <td>".$libro['idCasaEditrice']."</td>
                <td>".$libro['autoreLibro']."</td>
                <td>".$libro['idTipoLibro']."</td>
                <td>".$libro['idTipoScuola']."</td>
                <td>".$libro['codicePortatore']."</td>
                <td>".$libro['idOperatore']."</td>
                <td>".$libro['prezzoRegolare']."</td>
                <td>".$libro['soldiDaRestituire']."</td>
                <td>".$libro['prezzoMercatino']."</td>
                <td><a href='".$siteURL."gestione/carrello.php?elimina=".$idLibro."'>Elimina</a></td>
            </tr>
        ";
    }

    ?>

<table id="myTable" class="table display table-bordered" style="width: 99.9%">
    <thead>
    <tr>
        <td>Nome Libro</td>
        <td>Codice Libro</td>
        <td>Materia</td>
        <td>Casa Editrice</td>
        <td>Autore</td>
        <td>Volume</td>
        <td>Tipo Scuola</td>
        <td>Codice Cliente</td>
        <td>Catalogato Da</td>
        <td>Prezzo Negozio</td>
        <td>Da Restituire</td>
        <td>Prezzo Mercatino</td>
        <td>Elimina</td>
    </tr>
    </thead>
    <tbody>
    <?php echo $data; ?>
    </tbody>
</table>
    Totale: <?php echo $prezzoFinale; ?>
<form method="get" action="carrello.php">
    <input type="submit" name="azione" value="Venduti">
    <input type="submit" name="azione" value="Svuota">
</form>
    <script>$(document).ready(function() { $('#myTable').DataTable( {  "scrollX": true } ); } );</script>
<?php include "../footer.php";