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
<body class="d-flex flex-column min-vh-100" style="background: url('img/swamp.jpg') no-repeat center center; background-size: cover;">
    <nav class="navbar navbar-expand-sm static-top navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">MTG Companion</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapNavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="randomizer.php" role="button" data-bs-toggle="dropdown">Challange</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="randomizer.php">Challange Randomizer</a></li>
                            <li><a class="dropdown-item" href="checker.php">Preis Checker</a></li>
                            <li><a class="dropdown-item" href="history.php">Match History</a></li>
                            <li><a class="dropdown-item" href="upgrade.php">Upgrade History</a></li>
                            <li><a class="dropdown-item" href="editor.php">Editor</a></li>
                            <li><a class="dropdown-item active" href="information.php">Informationen</a></li>
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
                    <a href="backend/auth/logout.php?site=information.php"><i class="fa-solid fa-right-from-bracket fa-lg"></i></a>
                </div>
                <?php } ?>
            </div>
        </div>
    </nav>
    <div class="container text-center mx-auto p-5">
        <h4>Challange Regeln</h4>
        <div class="rulestext p-4 text-start">
            <div>Jeder Teilnehmer startet die Challange mit einem Precon-Commander Deck.
                 Wenn nun EDH Runden gespielt werden mit ausschlie??lich Challange Decks,
                 werden drei zuf??llige <a class="reflink" href="randomizer.php">Challanges</a> ausgelost. Nun wird normal die Partie
                 gespielt. Punkte werden danach wie folgt erhalten:</div>
            <ul class="p-2 text-start">
                <li>F??r das Teilnehmen an der Runde erh??lt jeder Spieler 3 Punkte</li>
                <li>Der Spieler der eine Challange erf??llt erh??lt die spezifizierten Challange-Punkte</li>
                <li>Spieler die nicht teilgenommen haben erhalten 2 Punkte</li>
                <li>Per Mehrheitsentscheid darf ein weiterer Punkt verteilt oder abgezogen werden</li>
            </ul>
            <div>Punkte k??nnen wie folgt zum upgraden eines Decks verwendet werden:</div>
            <ul class="p-2 text-start">
                <li>Ganze Decks k??nnen immer zu anderen Precons getauscht werden. Hierbei verfallen alle bisherigen Punkte</li>
                <li>Karten d??rfen ohne Punkteausgabe durch Basic Lands ausgetauscht werden</li>
                <li>Karten k??nnen geupgraded werden zum Punkte-Preis des <a class="reflink" href="upgrade.php">Preis Checkers</a></li>
            </ul>
        </div>
    </div>
    <div class="container-fluid text-center p-4">
        <h4>Alle m??glichen Challanges</h4>
        <div id="challanges" class="row mx-auto p-4">
            <div class="col col-md-3 col-xl-2 pt-3">
                <div class="mcard mx-auto">
                    <span class="title fade">Life Saver</span>
                    <span class="description fade">Rette einen Mitspieler</span>
                    <span class="points fade">1</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-auto">
        <footer class="py-3 my-4">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li class="nav-item"><a href="impressum.html" class="nav-link px-2">Impressum</a></li>
                <li class="nav-item"><a href="dataprotection.php" class="nav-link px-2">Datenschutz</a></li>
            </ul>
            <p class="text-center">MTG Companion is unofficial Fan Content permitted under the Fan Content Policy. Not approved/endorsed by Wizards. Portions of the materials used are property of Wizards of the Coast. ??Wizards of the Coast LLC.</p>
        </footer>
    </div>
</body>
<script>
var challange_data;
window.addEventListener('DOMContentLoaded', (event) => {
  loadChallangeData();
});

async function loadChallangeData() {
  const response = await fetch('backend/challanges/challanges.php');
  const data = await response.json();
  challange_data = data;
  for (let i = 0; i < Object.keys(challange_data).length; i++) {
    document.getElementById("challanges").innerHTML += '<div class="col col-md-3 col-xl-2 pt-3"><div class="mcard m-auto"><span class="title fade dynamic">' + challange_data[i].name +'</span><span class="description fade dynamic">' + challange_data[i].content + '</span><span class="points">' + challange_data[i].points + '</span></div></div>';
  }
}
</script>
</html>