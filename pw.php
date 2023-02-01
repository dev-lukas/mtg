<?php
include_once 'backend/functions.php';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <title>MTG Companion</title>
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
            <a class="navbar-brand active" href="index.html">MTG Companion</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapNavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="randomizer.html" role="button" data-bs-toggle="dropdown">Challange</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="information.html">Informationen</a></li>
                            <li><a class="dropdown-item" href="randomizer.html">Challange Randomizer</a></li>
                            <li><a class="dropdown-item" href="upgrade.html">Preis Checker</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="trading.html">Trade-Hub</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="mt-auto pt-3 row mx-auto text-center">
        <?php 
        /*
        */
        if($_GET) {
            if(isset($_GET['id']) and isset($_GET['identifier'])) {
                if(is_numeric($_GET['id'])) {
                    $id = $_GET['id'];
                    if(strcmp(getHash($id), $_GET['identifier']) == 0) {


        ?>    
        <form class="pwform">
            <div class="pt-5">
                <h3>Hallo Lukas!</h3>
                <br>
                <div class="disclaimer">Dein Username ist dein Name</div>
            </div>
            <div class="pw">
                <label for="pw-1">Passwort</label><br>
                <input type="password" id="pw-1">
            </div>
            <div class="pw">
                <label for="pw-1">Passwort wiederholen</label><br>
                <input type="password" id="pw-2">
            </div>
            <div class="pt-5">
                <button class="pw-btn" type="submit">Passwort setzen</button>
            </div>
        </form>
        <?php
                    }
                }
            }
        }   
        ?>
    </div>
    <div class="container mt-auto">
        <footer class="py-3 my-4">
          <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item"><a href="impressum.html" class="nav-link px-2 text-muted">Impressum</a></li>
          </ul>
          <p class="text-center text-muted">MTG Companion is unofficial Fan Content permitted under the Fan Content Policy. Not approved/endorsed by Wizards. Portions of the materials used are property of Wizards of the Coast. ©Wizards of the Coast LLC.</p>
        </footer>
      </div>
</body>
</html>