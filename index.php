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
<body class="d-flex flex-column min-vh-100" style="background: url('img/dragon.jpg') no-repeat center center; background-size: cover;">
    <nav class="navbar navbar-expand-sm static-top navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand active" href="index.php">MTG Companion</a>
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
                        <i class="fa-brands fa-google fa-lg"></i>Google Login
                    </div>
                </a>
                <?php } else { ?>
                <div class="logout">
                    Hallo <?php echo $_SESSION['name']; ?>!
                    <a href="backend/auth/logout.php?site=index.php"><i class="fa-solid fa-right-from-bracket fa-lg"></i></a>
                </div>
                <?php } ?>
            </div>
        </div>
    </nav>
    <div class="container-fluid pt-3 row mx-auto text-center">    
        <div class="col-12 col-md-6 col-xl-3 pt-3 d-flex justify-content-center align-items-stretch">
            <a class="landing-tile d-flex container linkbox mx-auto d-flex justify-content-center align-items-center text-decoration-none" href="randomizer.php">
                <h3 class="landing-title">Challange Randomizer</h3>  
                <i class="landing-icon fa-solid fa-shuffle fa-2xl"></i>       
            </a>
        </div>
        <div class="col-12 col-md-6 col-xl-3 pt-3 d-flex justify-content-center align-items-stretch">
            <a class="landing-tile d-flex container linkbox mx-auto d-flex justify-content-center align-items-center text-decoration-none" href="checker.php">
                <h3 class="landing-title">Preis Checker</h3>
                <i class="landing-icon fa-solid fa-magnifying-glass fa-2xl"></i>
            </a>
        </div>
        <div class="col-12 col-md-6 col-xl-3 pt-3 d-flex justify-content-center align-items-stretch">
            <a class="landing-tile d-flex container linkbox mx-auto d-flex justify-content-center align-items-center text-decoration-none" href="history.php">
                <h3 class="landing-title">Match History</h3>
                <i class="landing-icon fa-solid fa-rectangle-list fa-2xl"></i>
            </a>
        </div>
        <div class="col-12 col-md-6 col-xl-3 pt-3 d-flex justify-content-center align-items-stretch">
            <a class="landing-tile d-flex container linkbox mx-auto d-flex justify-content-center align-items-center text-decoration-none" href="upgrade.php">
                <h3 class="landing-title">Upgrade History</h3>  
                <i class="landing-icon fa-solid fa-arrow-up fa-2xl"></i>       
            </a>
        </div>
        <div class="col-12 col-md-6 col-xl-3 pt-3 d-flex justify-content-center align-items-stretch">
            <a class="landing-tile d-flex container linkbox mx-auto d-flex justify-content-center align-items-center text-decoration-none" href="editor.php">
                <h3 class="landing-title">Editor</h3>
                <i class="landing-icon fa-solid fa-pen fa-2xl"></i>  
            </a>
        </div>
        <div class="col-12 col-md-6 col-xl-3 pt-3 d-flex justify-content-center align-items-stretch">
            <a class="landing-tile d-flex container linkbox mx-auto d-flex justify-content-center align-items-center text-decoration-none" href="trading.php">
                <h3 class="landing-title">Trade-Hub</h3>  
                <i class="landing-icon fa-solid fa-arrow-right-arrow-left fa-2xl"></i>     
            </a>
        </div>
        <div class="col-12 col-md-6 col-xl-3 pt-3 d-flex justify-content-center align-items-stretch">
            <a class="landing-tile d-flex container linkbox mx-auto d-flex justify-content-center align-items-center text-decoration-none" href="information.php">
                <h3 class="landing-title">Informationen</h3>
                <i class="landing-icon fa-solid fa-circle-info fa-2xl"></i>  
            </a>
        </div>
    </div>
    <div class="modal" tabindex="-1" id="message">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tut uns Leid</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p>Der Login ist leider nur f??r eine bestimmte Playgroup gedacht! Der Login-Versuch wurde abgebrochen.</p>
                </div>
            </div>
         </div>
    </div>
    <div class="container mt-auto">
        <footer class="py-3 my-4">
          <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item"><a href="impressum.php" class="nav-link px-2">Impressum</a></li>
            <li class="nav-item"><a href="dataprotection.php" class="nav-link px-2">Datenschutz</a></li>
          </ul>
          <p class="text-center">MTG Companion is unofficial Fan Content permitted under the Fan Content Policy. Not approved/endorsed by Wizards. Portions of the materials used are property of Wizards of the Coast. ??Wizards of the Coast LLC.</p>
        </footer>
      </div>
</body>
<script>
window.addEventListener('DOMContentLoaded', (event) => {
    var message = new bootstrap.Modal(document.getElementById('message'));
    <?php if(isset($_GET['mode']) && $_GET['mode'] == 'message') { ?>
    message.show();
    <?php } ?>
});
</script>
</html>