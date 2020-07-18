<?php
    include "header.php";

    ?> <title>Dove siamo</title> <?php

    echo base64_decode($_SESSION['impostazioni']['htmlDoveSiamo']);

    include 'footer.php';