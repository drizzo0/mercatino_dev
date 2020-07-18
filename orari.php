<?php
include "header.php";

//recupera stringhe attuali
$lun = $sql->query("SELECT * from impostazioni where nomeImpostazione='orariLun'")->fetch_array()['valoreImpostazione'];
$lunArray = explode(',',$lun);

$mar = $sql->query("SELECT * from impostazioni where nomeImpostazione='orariMar'")->fetch_array()['valoreImpostazione'];
$marArray = explode(',',$mar);

$mer = $sql->query("SELECT * from impostazioni where nomeImpostazione='orariMer'")->fetch_array()['valoreImpostazione'];
$merArray = explode(',',$mer);

$gio = $sql->query("SELECT * from impostazioni where nomeImpostazione='orariGio'")->fetch_array()['valoreImpostazione'];
$gioArray = explode(',',$gio);

$ven = $sql->query("SELECT * from impostazioni where nomeImpostazione='orariVen'")->fetch_array()['valoreImpostazione'];
$venArray = explode(',',$ven);

$sab = $sql->query("SELECT * from impostazioni where nomeImpostazione='orariSab'")->fetch_array()['valoreImpostazione'];
$sabArray = explode(',',$sab);

$dom = $sql->query("SELECT * from impostazioni where nomeImpostazione='orariDom'")->fetch_array()['valoreImpostazione'];
$domArray = explode(',',$dom);

//Lunedì
if($lunArray[1] == "00"){
    $oraLunApMat = 'Chiuso';
    $minLunApMat = '';
    $oraLunChMat = 'Chiuso';
    $minLunChMat = '';
    $lmat = "<td colspan='2'>Chiuso</td>";
}else{
    $oraLunApMat = $lunArray[1];
    $minLunApMat = $lunArray[2];
    $oraLunChMat = $lunArray[3];
    $minLunChMat = $lunArray[4];
    $lunApMat = $oraLunApMat.':'.$minLunApMat;
    $lunChMat = $oraLunChMat.':'.$minLunChMat;
    $lmat = "<td>".$lunApMat."</td><td>".$lunChMat."</td>";
}

if($lunArray[5] == "00"){
    $oraLunApPom = 'Chiuso';
    $minLunApPom = '';
    $oraLunChPom = 'Chiuso';
    $minLunChPom = '';
    $lpom = "<td colspan='2'>Chiuso</td>";
}else{
    $oraLunApPom = $lunArray[5];
    $minLunApPom = $lunArray[6];
    $oraLunChPom = $lunArray[7];
    $minLunChPom = $lunArray[8];
    $lunApPom = $oraLunApPom.':'.$minLunApPom;
    $lunChPom = $oraLunChPom.':'.$minLunChPom;
    $lpom = "<td>".$lunApPom."</td><td>".$lunChPom."</td>";
}

//Martedì
if($marArray[1] == "00"){
    $oraMarApMat = 'Chiuso';
    $minMarApMat = '';
    $oraMarChMat = 'Chiuso';
    $minMarChMat = '';
    $mamat = "<td colspan='2'>Chiuso</td>";
}else{
    $oraMarApMat = $marArray[1];
    $minMarApMat = $marArray[2];
    $oraMarChMat = $marArray[3];
    $minMarChMat = $marArray[4];
    $marApMat = $oraMarApMat.':'.$minMarApMat;
    $marChMat = $oraMarChMat.':'.$minMarChMat;
    $mamat = "<td>".$marApMat."</td><td>".$marChMat."</td>";
}

if($marArray[5] == "00"){
    $oraMarApPom = 'Chiuso';
    $minMarApPom = '';
    $oraMarChPom = 'Chiuso';
    $minMarChPom = '';
    $mapom = "<td colspan='2'>Chiuso</td>";
}else{
    $oraMarApPom = $marArray[5];
    $minMarApPom = $marArray[6];
    $oraMarChPom = $marArray[7];
    $minMarChPom = $marArray[8];
    $marApPom = $oraMarApPom.':'.$minMarApPom;
    $marChPom = $oraMarChPom.':'.$minMarChPom;
    $mapom = "<td>".$marApPom."</td><td>".$marChPom."</td>";
}

//Mercoledì
if($merArray[1] == "00"){
    $oraMerApMat = 'Chiuso';
    $minMerApMat = '';
    $oraMerChMat = 'Chiuso';
    $minMerChMat = '';
    $memat = "<td colspan='2'>Chiuso</td>";
}else{
    $oraMerApMat = $merArray[1];
    $minMerApMat = $merArray[2];
    $oraMerChMat = $merArray[3];
    $minMerChMat = $merArray[4];
    $merApMat = $oraMerApMat.':'.$minMerApMat;
    $merChMat = $oraMerChMat.':'.$minMerChMat;
    $memat = "<td>".$merApMat."</td><td>".$merChMat."</td>";
}

if($merArray[5] == "00"){
    $oraMerApPom = 'Chiuso';
    $minMerApPom = '';
    $oraMerChPom = 'Chiuso';
    $minMerChPom = '';
    $mepom = "<td colspan='2'>Chiuso</td>";
}else{
    $oraMerApPom = $merArray[5];
    $minMerApPom = $merArray[6];
    $oraMerChPom = $merArray[7];
    $minMerChPom = $merArray[8];
    $merApPom = $oraMerApPom.':'.$minMerApPom;
    $merChPom = $oraMerChPom.':'.$minMerChPom;
    $mepom = "<td>".$merApPom."</td><td>".$merChPom."</td>";
}

//Giovedì
if($gioArray[1] == "00"){
    $oraGioApMat = 'Chiuso';
    $minGioApMat = '';
    $oraGioChMat = 'Chiuso';
    $minGioChMat = '';
    $gmat = "<td colspan='2'>Chiuso</td>";
}else{
    $oraGioApMat = $gioArray[1];
    $minGioApMat = $gioArray[2];
    $oraGioChMat = $gioArray[3];
    $minGioChMat = $gioArray[4];
    $gioApMat = $oraGioApMat.':'.$minGioApMat;
    $gioChMat = $oraGioChMat.':'.$minGioChMat;
    $gmat = "<td>".$gioApMat."</td><td>".$gioChMat."</td>";
}

if($gioArray[5] == "00"){
    $oraGioApPom = 'Chiuso';
    $minGioApPom = '';
    $oraGioChPom = 'Chiuso';
    $minGioChPom = '';
    $gpom = "<td colspan='2'>Chiuso</td>";
}else{
    $oraGioApPom = $gioArray[5];
    $minGioApPom = $gioArray[6];
    $oraGioChPom = $gioArray[7];
    $minGioChPom = $gioArray[8];
    $gioApPom = $oraGioApPom.':'.$minGioApPom;
    $gioChPom = $oraGioChPom.':'.$minGioChPom;
    $gpom = "<td>".$gioApPom."</td><td>".$gioChPom."</td>";
}

//Venerdì
if($venArray[1] == "00"){
    $oraVenApMat = 'Chiuso';
    $minVenApMat = '';
    $oraVenChMat = 'Chiuso';
    $minVenChMat = '';
    $vmat = "<td colspan='2'>Chiuso</td>";
}else{
    $oraVenApMat = $venArray[1];
    $minVenApMat = $venArray[2];
    $oraVenChMat = $venArray[3];
    $minVenChMat = $venArray[4];
    $venApMat = $oraVenApMat.':'.$minVenApMat;
    $venChMat = $oraVenChMat.':'.$minVenChMat;
    $vmat = "<td>".$venApMat."</td><td>".$venChMat."</td>";
}

if($venArray[5] == "00"){
    $oraVenApPom = 'Chiuso';
    $minVenApPom = '';
    $oraVenChPom = 'Chiuso';
    $minVenChPom = '';
    $vpom = "<td colspan='2'>Chiuso</td>";
}else{
    $oraVenApPom = $venArray[5];
    $minVenApPom = $venArray[6];
    $oraVenChPom = $venArray[7];
    $minVenChPom = $venArray[8];
    $venApPom = $oraVenApPom.':'.$minVenApPom;
    $venChPom = $oraVenChPom.':'.$minVenChPom;
    $vpom = "<td>".$venApPom."</td><td>".$venChPom."</td>";
}

//Sabato
if($sabArray[1] == "00"){
    $oraSabApMat = 'Chiuso';
    $minSabApMat = '';
    $oraSabChMat = 'Chiuso';
    $minSabChMat = '';
    $smat = "<td colspan='2'>Chiuso</td>";
}else{
    $oraSabApMat = $sabArray[1];
    $minSabApMat = $sabArray[2];
    $oraSabChMat = $sabArray[3];
    $minSabChMat = $sabArray[4];
    $sabApMat = $oraSabApMat.':'.$minSabApMat;
    $sabChMat = $oraSabChMat.':'.$minSabChMat;
    $smat = "<td>".$sabApMat."</td><td>".$sabChMat."</td>";
}

if($sabArray[5] == "00"){
    $oraSabApPom = 'Chiuso';
    $minSabApPom = '';
    $oraSabChPom = 'Chiuso';
    $minSabChPom = '';
    $spom = "<td colspan='2'>Chiuso</td>";
}else{
    $oraSabApPom = $sabArray[5];
    $minSabApPom = $sabArray[6];
    $oraSabChPom = $sabArray[7];
    $minSabChPom = $sabArray[8];
    $sabApPom = $oraSabApPom.':'.$minSabApPom;
    $sabChPom = $oraSabChPom.':'.$minSabChPom;
    $spom = "<td>".$sabApPom."</td><td>".$sabChPom."</td>";
}

//Domenica
if($domArray[1] == "00"){
    $oraDomApMat = 'Chiuso';
    $minDomApMat = '';
    $oraDomChMat = 'Chiuso';
    $minDomChMat = '';
    $dmat = "<td colspan='2'>Chiuso</td>";
}else{
    $oraDomApMat = $domArray[1];
    $minDomApMat = $domArray[2];
    $oraDomChMat = $domArray[3];
    $minDomChMat = $domArray[4];
    $domApMat = $oraDomApMat.':'.$minDomApMat;
    $domChMat = $oraDomChMat.':'.$minDomChMat;
    $dmat = "<td>".$domApMat."</td><td>".$domChMat."</td>";
}

if($domArray[5] == "00"){
    $oraDomApPom = 'Chiuso';
    $minDomApPom = '';
    $oraDomChPom = 'Chiuso';
    $minDomChPom = '';
    $dpom = "<td colspan='2'>Chiuso</td>";
}else{
    $oraDomApPom = $domArray[5];
    $minDomApPom = $domArray[6];
    $oraDomChPom = $domArray[7];
    $minDomChPom = $domArray[8];
    $domApPom = $oraDomApPom.':'.$minDomApPom;
    $domChPom = $oraDomChPom.':'.$minDomChPom;
    $dpom = "<td>".$domApPom."</td><td>".$domChPom."</td>";
}

//fixare orari in base a chiuso
if($lunArray[0]==1){ $lunAp = "Si"; }else{ $lunAp = "Si"; $lmat = $lpom = "<td colspan='2'>Chiuso</td>";  }
if($marArray[0]==1){ $marAp = "Si"; }else{ $marAp = "No"; $mamat = $mapom = "<td colspan='2'>Chiuso</td>";  }
if($merArray[0]==1){ $merAp = "Si"; }else{ $merAp = "No"; $memat = $mepom = "<td colspan='2'>Chiuso</td>";  }
if($gioArray[0]==1){ $gioAp = "Si"; }else{ $gioAp = "No"; $gmat = $gpom = "<td colspan='2'>Chiuso</td>";  }
if($venArray[0]==1){ $venAp = "Si"; }else{ $venAp = "No"; $vmat = $vpom = "<td colspan='2'>Chiuso</td>";  }
if($sabArray[0]==1){ $sabAp = "Si"; }else{ $sabAp = "No"; $smat = $spom = "<td colspan='2'>Chiuso</td>";  }
if($domArray[0]==1){ $domAp = "Si"; }else{ $domAp = "No"; $dmat = $dpom = "<td colspan='2'>Chiuso</td>";  }



    ?> <title>I nostri orari</title>
    
    <style>
    
        #tabellaOrari td th {
            text-align: center; 
            vertical-align: middle;
        }
        
    </style>
    
    <body>
        <center>
            <h1>Orari</h1>
            <table id="tabellaOrari" class="table table-bordered align-content-center">
                <thead>
                    <tr><th>Giorno</th><th>Aperto</th><th>Apertura Mattina</th><th>Chiusura Mattina</th><th>Apertura Pomeriggio</th><th>Chiusura Sera</th></tr>
                </thead>
                <tbody>
                    <tr><td>Lunedì</td><td><?php echo $lunAp; ?></td><?php echo $lmat; ?><?php echo $lpom; ?></tr>
                    <tr><td>Martedì</td><td><?php echo $marAp; ?></td><?php echo $mamat; ?><?php echo $mapom; ?></tr>
                    <tr><td>Mercoledì</td><td><?php echo $merAp; ?></td><?php echo $memat; ?><?php echo $mepom; ?></tr>
                    <tr><td>Giovedì</td><td><?php echo $gioAp; ?></td><?php echo $gmat; ?><?php echo $gpom; ?></tr>
                    <tr><td>Venerdì</td><td><?php echo $venAp; ?></td><?php echo $vmat; ?><?php echo $vpom; ?></tr>
                    <tr><td>Sabato</td><td><?php echo $sabAp; ?></td><?php echo $smat; ?><?php echo $spom; ?></tr>
                    <tr><td>Domenica</td><td><?php echo $domAp; ?></td><?php echo $dmat; ?><?php echo $dpom; ?></tr>
                </tbody>
            </table>
        </center>
    </body>
<?php
    include 'footer.php';
