<?php
//    header("location: home");
    include 'header.php';
    ?>

    <title><?php echo $_SESSION['impostazioni']['titoloPaginaPrincipale']; ?></title>

<?php
    echo base64_decode($_SESSION['impostazioni']['htmlHome']);
?>


<?php
    include 'footer.php';