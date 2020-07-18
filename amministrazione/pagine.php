<?php
    include 'header.php';
    if ($_SERVER['REQUEST_METHOD']=='POST'){

        if (isset($_POST['htmlHome'])){
            $nuovoHtml = base64_encode($_POST['htmlNuovo']);
            $sql->query("update impostazioni set valoreImpostazione='$nuovoHtml' where nomeImpostazione='htmlHome'");
            if ($sql->error){ die($sql->error); }
            echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'amministrazione/pagine.php">';
        }elseif (isset($_POST['htmlDoveSiamo'])){
            $nuovoHtml = base64_encode($_POST['htmlNuovo']);
            $sql->query("update impostazioni set valoreImpostazione='$nuovoHtml' where nomeImpostazione='htmlDoveSiamo'");
            if ($sql->error){ die($sql->error); }
            echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'amministrazione/pagine.php?pagina=DoveSiamo">';
        }elseif (isset ($_POST['aggiornaOrari']) ){
            if($_POST['checkLun']=='on'){ $checkLun = '1'; }else{ $checkLun = '0'; }
            if($_POST['checkMar']=='on'){ $checkMar = '1'; }else{ $checkMar = '0'; }
            if($_POST['checkMer']=='on'){ $checkMer = '1'; }else{ $checkMer = '0'; }
            if($_POST['checkGio']=='on'){ $checkGio = '1'; }else{ $checkGio = '0'; }
            if($_POST['checkVen']=='on'){ $checkVen = '1'; }else{ $checkVen = '0'; }
            if($_POST['checkSab']=='on'){ $checkSab = '1'; }else{ $checkSab = '0'; }
            if($_POST['checkDom']=='on'){ $checkDom = '1'; }else{ $checkDom = '0'; }

            $lun=$checkLun.','.$_POST['ap_lun_mat_or'].','.$_POST['ap_lun_mat_min'].','.$_POST['ch_lun_mat_or'].','.$_POST['ch_lun_mat_min'].','.$_POST['ap_lun_pom_or'].','.$_POST['ap_lun_pom_min'].','.$_POST['ch_lun_pom_or'].','.$_POST['ch_lun_pom_min'];
            $mar=$checkMar.','.$_POST['ap_mar_mat_or'].','.$_POST['ap_mar_mat_min'].','.$_POST['ch_mar_mat_or'].','.$_POST['ch_mar_mat_min'].','.$_POST['ap_mar_pom_or'].','.$_POST['ap_mar_pom_min'].','.$_POST['ch_mar_pom_or'].','.$_POST['ch_mar_pom_min'];
            $mer=$checkMer.','.$_POST['ap_mer_mat_or'].','.$_POST['ap_mer_mat_min'].','.$_POST['ch_mer_mat_or'].','.$_POST['ch_mer_mat_min'].','.$_POST['ap_mer_pom_or'].','.$_POST['ap_mer_pom_min'].','.$_POST['ch_mer_pom_or'].','.$_POST['ch_mer_pom_min'];
            $gio=$checkGio.','.$_POST['ap_gio_mat_or'].','.$_POST['ap_gio_mat_min'].','.$_POST['ch_gio_mat_or'].','.$_POST['ch_gio_mat_min'].','.$_POST['ap_gio_pom_or'].','.$_POST['ap_gio_pom_min'].','.$_POST['ch_gio_pom_or'].','.$_POST['ch_gio_pom_min'];
            $ven=$checkVen.','.$_POST['ap_ven_mat_or'].','.$_POST['ap_ven_mat_min'].','.$_POST['ch_ven_mat_or'].','.$_POST['ch_ven_mat_min'].','.$_POST['ap_ven_pom_or'].','.$_POST['ap_ven_pom_min'].','.$_POST['ch_ven_pom_or'].','.$_POST['ch_ven_pom_min'];            $sab=$checkLun.','.$_POST['ap_lun_mat_or'].','.$_POST['ap_lun_mat_min'].','.$_POST['ch_lun_mat_or'].','.$_POST['ch_lun_mat_min'].','.$_POST['ap_lun_pom_or'].','.$_POST['ap_lun_pom_min'].','.$_POST['ch_lun_pom_or'].','.$_POST['ch_lun_pom_min'];
            $sab=$checkSab.','.$_POST['ap_sab_mat_or'].','.$_POST['ap_sab_mat_min'].','.$_POST['ch_sab_mat_or'].','.$_POST['ch_sab_mat_min'].','.$_POST['ap_sab_pom_or'].','.$_POST['ap_sab_pom_min'].','.$_POST['ch_sab_pom_or'].','.$_POST['ch_sab_pom_min'];
            $dom=$checkDom.','.$_POST['ap_dom_mat_or'].','.$_POST['ap_dom_mat_min'].','.$_POST['ch_dom_mat_or'].','.$_POST['ch_dom_mat_min'].','.$_POST['ap_dom_pom_or'].','.$_POST['ap_dom_pom_min'].','.$_POST['ch_dom_pom_or'].','.$_POST['ch_dom_pom_min'];

            $sql->query("UPDATE impostazioni SET valoreImpostazione='$lun' WHERE nomeImpostazione='orariLun'");
            $sql->query("UPDATE impostazioni SET valoreImpostazione='$mar' WHERE nomeImpostazione='orariMar'");
            $sql->query("UPDATE impostazioni SET valoreImpostazione='$mer' WHERE nomeImpostazione='orariMer'");
            $sql->query("UPDATE impostazioni SET valoreImpostazione='$gio' WHERE nomeImpostazione='orariGio'");
            $sql->query("UPDATE impostazioni SET valoreImpostazione='$ven' WHERE nomeImpostazione='orariVen'");
            $sql->query("UPDATE impostazioni SET valoreImpostazione='$sab' WHERE nomeImpostazione='orariSab'");
            $sql->query("UPDATE impostazioni SET valoreImpostazione='$dom' WHERE nomeImpostazione='orariDom'");

            echo "Lunedì: ".$lun;
            echo "<br>";
            echo "Martedì: ".$mar;
            echo "<br>";
            echo "Mercoledì: ".$mer;
            echo "<br>";
            echo "Giovedì: ".$gio;
            echo "<br>";
            echo "Venerdì: ".$ven;
            echo "<br>";
            echo "Sabato: ".$sab;
            echo "<br>";
            echo "Domenica: ".$dom;
            echo "<br>";

        }



    }else{

        if ($_GET['pagina']=='Orari'){
            //recupera stringhe attuali
            $lun = $sql->query("SELECT * from impostazioni where nomeImpostazione='orariLun'")->fetch_array()['valoreImpostazione'];
            $lunArray = explode(',',$lun);
            if($lunArray[0]==1){ $checkLun='checked'; }

            $mar = $sql->query("SELECT * from impostazioni where nomeImpostazione='orariMar'")->fetch_array()['valoreImpostazione'];
            $marArray = explode(',',$mar);
            if($marArray[0]==1){ $checkMar='checked'; }

            $mer = $sql->query("SELECT * from impostazioni where nomeImpostazione='orariMer'")->fetch_array()['valoreImpostazione'];
            $merArray = explode(',',$mer);
            if($merArray[0]==1){ $checkMer='checked'; }

            $gio = $sql->query("SELECT * from impostazioni where nomeImpostazione='orariGio'")->fetch_array()['valoreImpostazione'];
            $gioArray = explode(',',$gio);
            if($gioArray[0]==1){ $checkGio='checked'; }

            $ven = $sql->query("SELECT * from impostazioni where nomeImpostazione='orariVen'")->fetch_array()['valoreImpostazione'];
            $venArray = explode(',',$ven);
            if($venArray[0]==1){ $checkVen='checked'; }

            $sab = $sql->query("SELECT * from impostazioni where nomeImpostazione='orariSab'")->fetch_array()['valoreImpostazione'];
            $sabArray = explode(',',$sab);
            if($sabArray[0]==1){ $checkSab='checked'; }

            $dom = $sql->query("SELECT * from impostazioni where nomeImpostazione='orariDom'")->fetch_array()['valoreImpostazione'];
            $domArray = explode(',',$dom);
            if($domArray[0]==1){ $checkDom='checked'; }

            //associazione orari db, mastro aperto,ora_ap_mat,min_ap,mat
            $oraLunApMat = $lunArray[1];
            $minLunApMat = $lunArray[2];
            $oraLunChMat = $lunArray[3];
            $minLunChMat = $lunArray[4];
            $oraLunApPom = $lunArray[5];
            $minLunApPom = $lunArray[6];
            $oraLunChPom = $lunArray[7];
            $minLunChPom = $lunArray[8];

            $oraMarApMat = $marArray[1];
            $minMarApMat = $marArray[2];
            $oraMarChMat = $marArray[3];
            $minMarChMat = $marArray[4];
            $oraMarApPom = $marArray[5];
            $minMarApPom = $marArray[6];
            $oraMarChPom = $marArray[7];
            $minMarChPom = $marArray[8];

            $oraMerApMat = $merArray[1];
            $minMerApMat = $merArray[2];
            $oraMerChMat = $merArray[3];
            $minMerChMat = $merArray[4];
            $oraMerApPom = $merArray[5];
            $minMerApPom = $merArray[6];
            $oraMerChPom = $merArray[7];
            $minMerChPom = $merArray[8];

            $oraGioApMat = $gioArray[1];
            $minGioApMat = $gioArray[2];
            $oraGioChMat = $gioArray[3];
            $minGioChMat = $gioArray[4];
            $oraGioApPom = $gioArray[5];
            $minGioApPom = $gioArray[6];
            $oraGioChPom = $gioArray[7];
            $minGioChPom = $gioArray[8];

            $oraVenApMat = $venArray[1];
            $minVenApMat = $venArray[2];
            $oraVenChMat = $venArray[3];
            $minVenChMat = $venArray[4];
            $oraVenApPom = $venArray[5];
            $minVenApPom = $venArray[6];
            $oraVenChPom = $venArray[7];
            $minVenChPom = $venArray[8];

            $oraSabApMat = $sabArray[1];
            $minSabApMat = $sabArray[2];
            $oraSabChMat = $sabArray[3];
            $minSabChMat = $sabArray[4];
            $oraSabApPom = $sabArray[5];
            $minSabApPom = $sabArray[6];
            $oraSabChPom = $sabArray[7];
            $minSabChPom = $sabArray[8];

            $oraDomApMat = $domArray[1];
            $minDomApMat = $domArray[2];
            $oraDomChMat = $domArray[3];
            $minDomChMat = $domArray[4];
            $oraDomApPom = $domArray[5];
            $minDomApPom = $domArray[6];
            $oraDomChPom = $domArray[7];
            $minDomChPom = $domArray[8];

            $selectedLunApMat = "<option name='selected'>".$oraLunApMat."</option><option disabled>--</option>";
            $selectedLunChMat = "<option name='selected'>".$oraLunChMat."</option><option disabled>--</option>";
            $selectedLunApPom = "<option name='selected'>".$oraLunApPom."</option><option disabled>--</option>";
            $selectedLunChPom = "<option name='selected'>".$oraLunChPom."</option><option disabled>--</option>";

            $selectedLunApMatMin = "<option name='selected'>".$minLunApMat."</option><option disabled>--</option>";
            $selectedLunChMatMin = "<option name='selected'>".$minLunChMat."</option><option disabled>--</option>";
            $selectedLunApPomMin = "<option name='selected'>".$minLunApPom."</option><option disabled>--</option>";
            $selectedLunChPomMin = "<option name='selected'>".$minLunChPom."</option><option disabled>--</option>";

            $selectedMarApMat = "<option name='selected'>".$oraMarApMat."</option><option disabled>--</option>";
            $selectedMarChMat = "<option name='selected'>".$oraMarChMat."</option><option disabled>--</option>";
            $selectedMarApPom = "<option name='selected'>".$oraMarApPom."</option><option disabled>--</option>";
            $selectedMarChPom = "<option name='selected'>".$oraMarChPom."</option><option disabled>--</option>";

            $selectedMarApMatMin = "<option name='selected'>".$minMarApMat."</option><option disabled>--</option>";
            $selectedMarChMatMin = "<option name='selected'>".$minMarChMat."</option><option disabled>--</option>";
            $selectedMarApPomMin = "<option name='selected'>".$minMarApPom."</option><option disabled>--</option>";
            $selectedMarChPomMin = "<option name='selected'>".$minMarChPom."</option><option disabled>--</option>";

            $selectedMerApMat = "<option name='selected'>".$oraMerApMat."</option><option disabled>--</option>";
            $selectedMerChMat = "<option name='selected'>".$oraMerChMat."</option><option disabled>--</option>";
            $selectedMerApPom = "<option name='selected'>".$oraMerApPom."</option><option disabled>--</option>";
            $selectedMerChPom = "<option name='selected'>".$oraMerChPom."</option><option disabled>--</option>";

            $selectedMerApMatMin = "<option name='selected'>".$minMerApMat."</option><option disabled>--</option>";
            $selectedMerChMatMin = "<option name='selected'>".$minMerChMat."</option><option disabled>--</option>";
            $selectedMerApPomMin = "<option name='selected'>".$minMerApPom."</option><option disabled>--</option>";
            $selectedMerChPomMin = "<option name='selected'>".$minMerChPom."</option><option disabled>--</option>";

            $selectedGioApMat = "<option name='selected'>".$oraGioApMat."</option><option disabled>--</option>";
            $selectedGioChMat = "<option name='selected'>".$oraGioChMat."</option><option disabled>--</option>";
            $selectedGioApPom = "<option name='selected'>".$oraGioApPom."</option><option disabled>--</option>";
            $selectedGioChPom = "<option name='selected'>".$oraGioChPom."</option><option disabled>--</option>";

            $selectedGioApMatMin = "<option name='selected'>".$minGioApMat."</option><option disabled>--</option>";
            $selectedGioChMatMin = "<option name='selected'>".$minGioChMat."</option><option disabled>--</option>";
            $selectedGioApPomMin = "<option name='selected'>".$minGioApPom."</option><option disabled>--</option>";
            $selectedGioChPomMin = "<option name='selected'>".$minGioChPom."</option><option disabled>--</option>";

            $selectedVenApMat = "<option name='selected'>".$oraVenApMat."</option><option disabled>--</option>";
            $selectedVenChMat = "<option name='selected'>".$oraVenChMat."</option><option disabled>--</option>";
            $selectedVenApPom = "<option name='selected'>".$oraVenApPom."</option><option disabled>--</option>";
            $selectedVenChPom = "<option name='selected'>".$oraVenChPom."</option><option disabled>--</option>";

            $selectedVenApMatMin = "<option name='selected'>".$minVenApMat."</option><option disabled>--</option>";
            $selectedVenChMatMin = "<option name='selected'>".$minVenChMat."</option><option disabled>--</option>";
            $selectedVenApPomMin = "<option name='selected'>".$minVenApPom."</option><option disabled>--</option>";
            $selectedVenChPomMin = "<option name='selected'>".$minVenChPom."</option><option disabled>--</option>";

            $selectedSabApMat = "<option name='selected'>".$oraSabApMat."</option><option disabled>--</option>";
            $selectedSabChMat = "<option name='selected'>".$oraSabChMat."</option><option disabled>--</option>";
            $selectedSabApPom = "<option name='selected'>".$oraSabApPom."</option><option disabled>--</option>";
            $selectedSabChPom = "<option name='selected'>".$oraSabChPom."</option><option disabled>--</option>";

            $selectedSabApMatMin = "<option name='selected'>".$minSabApMat."</option><option disabled>--</option>";
            $selectedSabChMatMin = "<option name='selected'>".$minSabChMat."</option><option disabled>--</option>";
            $selectedSabApPomMin = "<option name='selected'>".$minSabApPom."</option><option disabled>--</option>";
            $selectedSabChPomMin = "<option name='selected'>".$minSabChPom."</option><option disabled>--</option>";

            $selectedDomApMat = "<option name='selected'>".$oraDomApMat."</option><option disabled>--</option>";
            $selectedDomChMat = "<option name='selected'>".$oraDomChMat."</option><option disabled>--</option>";
            $selectedDomApPom = "<option name='selected'>".$oraDomApPom."</option><option disabled>--</option>";
            $selectedDomChPom = "<option name='selected'>".$oraDomChPom."</option><option disabled>--</option>";

            $selectedDomApMatMin = "<option name='selected'>".$minDomApMat."</option><option disabled>--</option>";
            $selectedDomChMatMin = "<option name='selected'>".$minDomChMat."</option><option disabled>--</option>";
            $selectedDomApPomMin = "<option name='selected'>".$minDomApPom."</option><option disabled>--</option>";
            $selectedDomChPomMin = "<option name='selected'>".$minDomChPom."</option><option disabled>--</option>";
            ?>

            <form method="post" action="pagine.php" id="formOrari">
                <table>
                    <tr><td>Giorno</td><td>Aperto</td><td>Orario Apertura Mattina</td><td>Orario Chiusura Mattina</td><td>Orario Apertura Pomeriggio</td><td>Orario Chiusura Pomeriggio</td></tr>
                    <tr><td>Lunedì</td><td><input type="checkbox" name="checkLun" <?php echo $checkLun; ?> ></td><td><select name="ap_lun_mat_or" form="formOrari"><?php echo $selectedLunApMat; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ap_lun_mat_min" form="formOrari"><?php echo $selectedLunApMatMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td><td><select name="ch_lun_mat_or" form="formOrari"><?php echo $selectedLunChMat; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ch_lun_mat_min" form="formOrari"><?php echo $selectedLunChMatMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td><td><select name="ap_lun_pom_or" form="formOrari"><?php echo $selectedLunApPom; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ap_lun_pom_min" form="formOrari"><?php echo $selectedLunApPomMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td><td><select name="ch_lun_pom_or" form="formOrari"><?php echo $selectedLunChPom; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ch_lun_pom_min" form="formOrari"><?php echo $selectedLunChPomMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td></tr>
                    <tr><td>Martedì</td><td><input type="checkbox" name="checkMar" <?php echo $checkMar; ?> ></td><td><select name="ap_mar_mat_or" form="formOrari"><?php echo $selectedMarApMat; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ap_mar_mat_min" form="formOrari"><?php echo $selectedMarApMatMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td><td><select name="ch_mar_mat_or" form="formOrari"><?php echo $selectedMarChMat; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ch_mar_mat_min" form="formOrari"><?php echo $selectedMarChMatMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td><td><select name="ap_mar_pom_or" form="formOrari"><?php echo $selectedMarApPom; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ap_mar_pom_min" form="formOrari"><?php echo $selectedMarApPomMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td><td><select name="ch_mar_pom_or" form="formOrari"><?php echo $selectedMarChPom; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ch_mar_pom_min" form="formOrari"><?php echo $selectedMarChPomMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td></tr>
                    <tr><td>Mercoledì</td><td><input type="checkbox" name="checkMer" <?php echo $checkMer; ?> ></td><td><select name="ap_mer_mat_or" form="formOrari"><?php echo $selectedMerApMat; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ap_mer_mat_min" form="formOrari"><?php echo $selectedMerApMatMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td><td><select name="ch_mer_mat_or" form="formOrari"><?php echo $selectedMerChMat; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ch_mer_mat_min" form="formOrari"><?php echo $selectedMerChMatMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td><td><select name="ap_mer_pom_or" form="formOrari"><?php echo $selectedMerApPom; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ap_mer_pom_min" form="formOrari"><?php echo $selectedMerApPomMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td><td><select name="ch_mer_pom_or" form="formOrari"><?php echo $selectedMerChPom; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ch_mer_pom_min" form="formOrari"><?php echo $selectedMerChPomMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td></tr>
                    <tr><td>Giovedì</td><td><input type="checkbox" name="checkGio" <?php echo $checkGio; ?> ></td><td><select name="ap_gio_mat_or" form="formOrari"><?php echo $selectedGioApMat; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ap_gio_mat_min" form="formOrari"><?php echo $selectedGioApMatMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td><td><select name="ch_gio_mat_or" form="formOrari"><?php echo $selectedGioChMat; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ch_gio_mat_min" form="formOrari"><?php echo $selectedGioChMatMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td><td><select name="ap_gio_pom_or" form="formOrari"><?php echo $selectedGioApPom; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ap_gio_pom_min" form="formOrari"><?php echo $selectedGioApPomMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td><td><select name="ch_gio_pom_or" form="formOrari"><?php echo $selectedGioChPom; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ch_gio_pom_min" form="formOrari"><?php echo $selectedGioChPomMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td></tr>
                    <tr><td>Venerdì</td><td><input type="checkbox" name="checkVen" <?php echo $checkVen; ?> ></td><td><select name="ap_ven_mat_or" form="formOrari"><?php echo $selectedVenApMat; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ap_ven_mat_min" form="formOrari"><?php echo $selectedVenApMatMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td><td><select name="ch_ven_mat_or" form="formOrari"><?php echo $selectedVenChMat; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ch_ven_mat_min" form="formOrari"><?php echo $selectedVenChMatMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td><td><select name="ap_ven_pom_or" form="formOrari"><?php echo $selectedVenApPom; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ap_ven_pom_min" form="formOrari"><?php echo $selectedVenApPomMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td><td><select name="ch_ven_pom_or" form="formOrari"><?php echo $selectedVenChPom; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ch_ven_pom_min" form="formOrari"><?php echo $selectedVenChPomMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td></tr>
                    <tr><td>Sabato</td><td><input type="checkbox" name="checkSab" <?php echo $checkSab; ?> ></td><td><select name="ap_sab_mat_or" form="formOrari"><?php echo $selectedSabApMat; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ap_sab_mat_min" form="formOrari"><?php echo $selectedSabApMatMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td><td><select name="ch_sab_mat_or" form="formOrari"><?php echo $selectedSabChMat; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ch_sab_mat_min" form="formOrari"><?php echo $selectedSabChMatMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td><td><select name="ap_sab_pom_or" form="formOrari"><?php echo $selectedSabApPom; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ap_sab_pom_min" form="formOrari"><?php echo $selectedSabApPomMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td><td><select name="ch_sab_pom_or" form="formOrari"><?php echo $selectedSabChPom; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ch_sab_pom_min" form="formOrari"><?php echo $selectedSabChPomMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td></tr>
                    <tr><td>Domenica</td><td><input type="checkbox" name="checkDom" <?php echo $checkDom; ?> ></td><td><select name="ap_dom_mat_or" form="formOrari"><?php echo $selectedDomApMat; ?> <option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ap_dom_mat_min" form="formOrari"><?php echo $selectedDomApMatMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td><td><select name="ch_dom_mat_or" form="formOrari"><?php echo $selectedDomChMat; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ch_dom_mat_min" form="formOrari"><?php echo $selectedDomChMatMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td><td><select name="ap_dom_pom_or" form="formOrari"><?php echo $selectedDomApPom; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ap_dom_pom_min" form="formOrari"><?php echo $selectedDomApPomMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td><td><select name="ch_dom_pom_or" form="formOrari"><?php echo $selectedDomChPom; ?><option name="00">00</option><option name="01">01</option><option name="02">02</option><option name="03">03</option><option name="04">04</option><option name="05">05</option><option name="06">06</option><option name="07">07</option><option name="08">08</option><option name="09">09</option><option name="10">10</option><option name="11">11</option><option name="12">12</option><option name="13">13</option><option name="14">14</option><option name="15">15</option><option name="16">16</option><option name="17">17</option><option name="18">18</option><option name="19">19</option><option name="20">20</option><option name="21">21</option><option name="22">22</option><option name="23">23</option></select><select name="ch_dom_pom_min" form="formOrari"><?php echo $selectedDomChPomMin; ?><option name="00">00</option><option name="15">15</option><option name="30">30</option><option name="45">45</option></select></td></tr>
                </table>
                <input type="submit" name="aggiornaOrari" value="Aggiorna!">
            </form>
            <?php
        }elseif ($_GET['pagina']=='DoveSiamo'){
            //recupera contenuto attuale
            $htmlAttuale = base64_decode($sql->query("select * from impostazioni where nomeImpostazione='htmlDoveSiamo'")->fetch_array()['valoreImpostazione']);
            ?>
            <form method="post" action="pagine.php?modOrari">
                <label for="htmlNuovo">HTML PAGINA:</label>
                <textarea id="htmlNuovo" name="htmlNuovo"><?php echo $htmlAttuale; ?></textarea>
                <input type="submit" name="htmlDoveSiamo" value="Modifica">
            </form>
            <?php
        }else{
            //recupera contenuto attuale
            $htmlAttuale = base64_decode($sql->query("select * from impostazioni where nomeImpostazione='htmlHome'")->fetch_array()['valoreImpostazione']);
            ?>
            <form method="post" action="pagine.php">
                <label for="htmlNuovo">HTML PAGINA:</label>
                <textarea id="htmlNuovo" name="htmlNuovo"><?php echo $htmlAttuale; ?></textarea>
                <input type="submit" name="htmlHome" value="Modifica">
            </form>
            <?php
        }
    }
include "../footer.php";