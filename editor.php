<?php include_once("backend/auth/google_auth.php"); ?>
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
            <a class="navbar-brand" href="index.php">MTG Companion</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapNavbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="randomizer.php" role="button" data-bs-toggle="dropdown">Challange</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="information.php">Informationen</a></li>
                            <li><a class="dropdown-item" href="randomizer.php">Challange Randomizer</a></li>
                            <li><a class="dropdown-item" href="upgrade.php">Preis Checker</a></li>
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
                    <a href="backend/auth/logout.php?site=trading.php"><i class="fa-solid fa-right-from-bracket fa-lg"></i></a>
                </div>
                <?php } ?>
            </div>
        </div>
    </nav>
    <div class="container mx-auto text-center p-0 m-5">
        <h3>Editor</h3>
        <label class="switch mt-3">
            <input id="switch" type="checkbox" onclick="changeView()">
            <span class="slider"></span>
        </label>
        <div class="content mt-5">
            <span id="matcheditor">
                <h5>Match Editor</h5>
                <div class="row pt-3">
                    <div class="editor col-12 col-lg-6 mt-3">
                        <h4>Neues Match</h4>
                        <form>
                            <span class="row d-flex justify-content-center">
                                <div class="col-12 mt-2">
                                    <input type="date">
                                </div>
                                <h5 class="col-12 mt-3">Spieler</h5>
                                <div class="col-4 mt-2">
                                    <select class="player" name="Spieler">
                                        <option  value="0">Niemand</option>
                                    </select>
                                    <br>
                                    <label for="player_1_extra_point">+1</label>
                                    <input name="player_1_extra_point" type="checkbox">
                                    <label for="player_1_minus_point">-1</label>
                                    <input name="player_1_minus_point" type="checkbox">
                                </div>
                                <div class="col-4 mt-2">
                                    <select class="player" name="Spieler">
                                        <option value="0">Niemand</option>
                                    </select>
                                    <br>
                                    <label for="player_1_extra_point">+1</label>
                                    <input name="player_1_extra_point" type="checkbox">
                                    <label for="player_1_minus_point">-1</label>
                                    <input name="player_1_minus_point" type="checkbox">
                                </div>
                                <div class="col-4 mt-2">
                                    <select class="player" name="Spieler">
                                        <option value="0">Niemand</option>
                                    </select>
                                    <br>
                                    <label for="player_1_extra_point">+1</label>
                                    <input name="player_1_extra_point" type="checkbox">
                                    <label for="player_1_minus_point">-1</label>
                                    <input name="player_1_minus_point" type="checkbox">
                                </div>
                                <div class="col-4 mt-2">
                                    <select class="player" name="Spieler">
                                        <option value="0">Niemand</option>
                                    </select>
                                    <br>
                                    <label for="player_1_extra_point">+1</label>
                                    <input name="player_1_extra_point" type="checkbox">
                                    <label for="player_1_minus_point">-1</label>
                                    <input name="player_1_minus_point" type="checkbox">
                                </div>
                                <div class="col-4 mt-2">
                                    <select class="player" name="Spieler">
                                        <option value="0">Niemand</option>
                                    </select>
                                    <br>
                                    <label for="player_1_extra_point">+1</label>
                                    <input name="player_1_extra_point" type="checkbox">
                                    <label for="player_1_minus_point">-1</label>
                                    <input name="player_1_minus_point" type="checkbox">
                                </div>
                                <div class="col-12 mt-2">
                                    <label for="winner">Gewinner:</label><br>
                                    <select class="winner player" name="winner">
                                        <option value="0">Niemand</option>
                                    </select>
                                </div>
                                <h5 class="col-12 mt-3">Challanges</h5>
                                <div class="col-3 mt-2">
                                    <span class="lifesaver">Life Saver</span>
                                    <br>
                                    <select class="mt-1 player" name="Achiever">
                                        <option value="0">Niemand</option>
                                    </select>
                                </div>
                                <div class="col-3 mt-2">
                                    <select class="challanges" name="Challange">
                                        <option>Myriad</option>
                                        <option>Test</option>
                                    </select>
                                    <br>
                                    <select class="mt-1 player" name="Achiever">
                                        <option value="0">Niemand</option>
                                    </select>
                                </div>
                                <div class="col-3 mt-2">
                                    <select class="challanges" name="Challange">
                                        <option>Myriad</option>
                                        <option>Test</option>
                                    </select>
                                    <br>
                                    <select class="mt-1 player" name="Achiever">
                                        <option value="0">Niemand</option>
                                    </select>
                                </div>
                                <div class="col-3 mt-2">
                                    <select class="challanges" name="Challange">
                                        <option>Myriad</option>
                                        <option>Test</option>
                                    </select>
                                    <br>
                                    <select class="mt-1 player" name="Achiever">
                                        <option value="0">Niemand</option>
                                    </select>     
                                </div>
                                <button class="mt-3">Hinzufügen</button>
                            </span>
                        </form>
                    </div>
                    <div class="col-12 col-lg-6 mt-3">
                        <h5>Match bearbeiten</h5>
                    </div>
                </div>
            </span>
            <span id="challangeeditor" class="hidden">
                <h5>Challange Editor</h5>
            </span>
        </div>
    </div>
    <div class="container mt-auto">
        <footer class="py-3 my-4">
          <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item"><a href="impressum.php" class="nav-link px-2 text-muted">Impressum</a></li>
            <li class="nav-item"><a href="dataprotection.php" class="nav-link px-2 text-muted">Datenschutz</a></li>
          </ul>
          <p class="text-center text-muted">MTG Companion is unofficial Fan Content permitted under the Fan Content Policy. Not approved/endorsed by Wizards. Portions of the materials used are property of Wizards of the Coast. ©Wizards of the Coast LLC.</p>
        </footer>
    </div>
</body>
<script>
window.addEventListener('DOMContentLoaded', (event) => {
    readyEditor();
});

async function readyEditor() {
    readyPlayer();
    readyChallanges();
}

async function readyPlayer() {
    const response = await fetch('backend/player/player.php', {
        method: 'GET',
    });
    const result = await response.json();
    const playerboxes = document.querySelectorAll('select.player');
    for (const playerbox of playerboxes) {
        for(let i = 0; i < Object.keys(result).length; i++) {
            playerbox.innerHTML += `<option value="${result[i].id}">${result[i].name}</option>`;
        }
    }
}

async function readyChallanges() {
    const response = await fetch('backend/challanges/challanges.php', {
        method: 'GET',
    });
    const result = await response.json();
    const challangeboxes = document.querySelectorAll('select.challanges');
    for (const challangebox of challangeboxes) {
        for(let i = 0; i < Object.keys(result).length; i++) {
            challangebox.innerHTML += `<option value="${result[i].id}">${result[i].name}</option>`;
        }
    }
}

function changeView() {
    document.getElementById('matcheditor').classList.toggle('hidden');
    document.getElementById('challangeeditor').classList.toggle('hidden');
}
</script>
</html>