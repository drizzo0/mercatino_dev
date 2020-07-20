<?php
    include "header.php";

    ?> <title>Dove siamo</title> <?php

    echo base64_decode($_SESSION['impostazioni']['htmlDoveSiamo']);

    ?>

    <div class="google-maps">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3137.8513518435598!2d15.214648915486034!3d38.14364929862346!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1314254cf92e6753%3A0x36b9f870cd768681!2sVia%20Roma%2C%20215%2C%2098051%20Barcellona%20Pozzo%20di%20Gotto%20ME!5e0!3m2!1sen!2sit!4v1595284915516!5m2!1sen!2sit" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0" allowfullscreen></iframe>
    </div>

<?php

    include 'footer.php';