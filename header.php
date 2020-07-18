<?php
    $db = '';
    $gestione='';
    $amministrazione='';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    include 'dbconfig.php';
    require 'vendor/autoload.php';
    include '../mercatino_private/core.php';


    $impostazioniSql = $sql->query("SELECT * FROM impostazioni");
    while ($impostazione = $impostazioniSql->fetch_assoc()){
        $_SESSION['impostazioni'][$impostazione['nomeImpostazione']] = $impostazione['valoreImpostazione'];
    }

    $Core = new CoreFunctions();
    $Mail = new PHPMailer(true);
    $Mail->isHTML(true);                                  // Set email format to HTML
    $Google_Client = new Google_Client();
    $Facebook = new \Facebook\Facebook([
            'app_id' => $_SESSION['impostazioni']['facebookSSOAppID'],
            'app_secret' => $_SESSION['impostazioni']['facebookSSOAppSecret'],
            'default_graph_version' => $_SESSION['impostazioni']['facebookSSOAppGraphVersion'],
    ]);


    //TODO: INSERIRE BANNER PER I COOKIES (NEL FOOTER)

    $Google_Client->setClientId($_SESSION['impostazioni']['googleClientID']);
    $Google_Client->setClientSecret($_SESSION['impostazioni']['googleClientSecret']);
    $Google_Client->setRedirectUri($_SESSION['impostazioni']['googleRedirectUri']);
    $Google_Client->addScope('email');
    $Google_Client->addScope('profile');
    $Google_Client->addScope('openid');

    $FacebookHelper = $Facebook->getRedirectLoginHelper();
    $FacebookPermissions = ['email'];

    //Server settings
    $Mail->SMTPDebug = 0;                                       // Enable verbose debug output
    $Mail->isSMTP();                                            // Set mailer to use SMTP
    $Mail->Host       = $_SESSION['impostazioni']['mailSmtpAddress'];  // Specify main and backup SMTP servers
    $Mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $Mail->Username   = $_SESSION['impostazioni']['mailSmtpUsername'];                     // SMTP username
    $Mail->Password   = $_SESSION['impostazioni']['mailSmtpPassword'];                               // SMTP password
    $Mail->SMTPSecure = 'ssl';                                  // Enable TLS encryption, `ssl` also accepted
    $Mail->Port       = $_SESSION['impostazioni']['mailSmtpPort'];                                    // TCP port to connect to

    //Recipients
    $Mail->setFrom($_SESSION['impostazioni']['mailSenderAddress'], $_SESSION['impostazioni']['mailSenderName']);
    $Mail->addReplyTo($_SESSION['impostazioni']['mailSenderAddress'], $_SESSION['impostazioni']['mailSenderName']);

    //$Mail->addBCC('bcc@example.com');

    $Core->checkLoginByCookies();


    $siteURL = $_SESSION['impostazioni']['siteURL'];

    echo '
        <link rel="stylesheet" href="'.$siteURL.'css/bootstrap.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script type="text/javascript" src="'.$siteURL.'js/popper.js"></script>
        <script type="text/javascript" src="'.$siteURL.'js/bootstrap.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        ';


    if(isset($_SESSION['loggedIn'])){
        $loggedIn = $_SESSION['loggedIn'];

        if($loggedIn == true) {

            $userID = $_SESSION['utente']['idUtente'];
            $roleID = $sql->query("SELECT * FROM ruoliUtente WHERE idUtente = '$userID'");
            $roleID = $roleID->fetch_array();
            $roleID = $roleID['idRuolo'];
            $role = $sql->query("SELECT * FROM ruoli WHERE idRuolo = '$roleID'");
            $role = $role->fetch_array();
            if ($role['puoAccedere'] == 0) {
                echo '<meta http-equiv="refresh" content="0;url='.$siteURL.'esci.php">';
            }
            $gestione = $role['accessoPannelloOperatore'];
            $amministrazione = $role['modificaImpostazioniSito'];
        }

    }else{
        $_SESSION['loggedIn'] = false;
        $loggedIn = false;
    }

    ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav md-auto">
                <li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>index.php">Home</a></li>
                <?php if($loggedIn==true){ ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>lista_libri.php">Lista Libri</a></li>
                    <li class="nav-item"><a class="nav-link <?php if($_SESSION['impostazioni']['prenotazioniAbilitate']==0){ echo "disabled"; } ?>" href="<?php echo $siteURL; ?>prenotazioni.php">Prenotazioni</a></li>
                <?php } ?>
                <li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>libri_portati.php">Stato Libri</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>orari.php">Orari</a></li>
                <li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>dove_siamo.php">Dove Siamo</a></li>
                <?php if ($gestione==1){ ?><li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>gestione/">Gestione Mercatino</a></li><?php } ?>
                <?php if ($amministrazione==1){ ?><li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>amministrazione/">Amministrazione Mercatino</a></li><?php } ?>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if($loggedIn==false){ ?><li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>accedi.php">Accedi</a></li><?php } ?>
                <?php if($loggedIn==false){ ?><li class="nav-item"><a class="nav-link" href="<?php echo $siteURL; ?>registrati.php">Registrati</a></li><?php } ?>
                <?php if($loggedIn==true){ ?>
                    <div class="dropdown dropleft nav-item ml-auto">
                        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['utente']['nome'].' '.$_SESSION['utente']['cognome']; ?></button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="<?php echo $siteURL; ?>cambia_password.php">Cambia Password</a>
                            <a class="dropdown-item" href="<?php echo $siteURL; ?>esci.php">Disconnettiti</a>
                        </div>
                    </div>
                <?php } ?>
            </ul>
        </div>
    </nav>
