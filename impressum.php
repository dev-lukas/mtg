<?php include_once("backend/auth/google_auth.php"); ?>
<html lang="de">
<head>
    <title>MTG Companion</title>
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet">
    <link href="style/mtgcompanion.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-sm static-top navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">MTG Companion</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapNavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="randomizer.php" role="button" data-bs-toggle="dropdown">Challange</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="randomizer.php">Challange Randomizer</a></li>
                            <li><a class="dropdown-item" href="checker.php">Preis Checker</a></li>
                            <li><a class="dropdown-item" href="history.php">Match History</a></li>
                            <li><a class="dropdown-item" href="upgrade.php">Upgrade History</a></li>
                            <li><a class="dropdown-item" href="editor.php">Editor</a></li>
                            <li><a class="dropdown-item" href="information.php">Informationen</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="trading.php">Trade-Hub</a>
                    </li>
                </ul>
                <?php if(!isset($_SESSION['id'])) { ?>
                <a class="google-sign-in" href="<?php echo $client->createAuthUrl(); ?>">
                    <div>
                        <i class="fa-brands fa-google"></i>Google Login
                    </div>
                </a>
                <?php } else { ?>
                <div class="logout">
                    Hallo <?php echo $_SESSION['name']; ?>!
                    <a href="backend/auth/logout.php?site=impressum.php"><i class="fa-solid fa-right-from-bracket fa-lg"></i></a>
                </div>
                <?php } ?>
            </div>
        </div>
    </nav>
    <div class="container mx-auto justify-content-center text-center p-0 m-5">
        <h5 class="p-4">Impressum</h5>
        <div class="impressum pt-4 text-center">
            <p><i class="fas fa-signature"></i> Lukas Roth</p>
            <p><i class="fas fa-map-marker-alt"></i>Quartiersweg 2, 10829 Berlin, Deutschland</p>
            <p><i class="fas fa-phone"></i>Auf Anfrage</p>
            <p><i class="fas fa-envelope"></i>admin@firephenix.de</p>
        </div>
    </div>
    <div class="container mt-auto">
        <footer class="py-3 my-4">
          <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item"><a href="impressum.php" class="nav-link px-2">Impressum</a></li>
            <li class="nav-item"><a href="dataprotection.php" class="nav-link px-2">Datenschutz</a></li>
          </ul>
          <p class="text-center">MTG Companion is unofficial Fan Content permitted under the Fan Content Policy. Not approved/endorsed by Wizards. Portions of the materials used are property of Wizards of the Coast. ©Wizards of the Coast LLC.</p>
        </footer>
      </div>
</html>