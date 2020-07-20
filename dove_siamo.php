<?php
    include "header.php";

    ?> <title>Dove siamo</title> <?php

    echo base64_decode($_SESSION['impostazioni']['htmlDoveSiamo']);

    ?>

    <div class="google-maps">
        <iframe src="https://goo.gl/maps/TR45AdB78szdMEdo6" allowfullscreen></iframe>
    </div>

<?php

    include 'footer.php';