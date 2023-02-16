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
                        <a class="nav-link dropdown-toggle active" href="randomizer.html" role="button" data-bs-toggle="dropdown">Challange</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="randomizer.php">Challange Randomizer</a></li>
                            <li><a class="dropdown-item" href="checker.php">Preis Checker</a></li>
                            <li><a class="dropdown-item active" href="history.php">Match History</a></li>
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
                    <a href="backend/auth/logout.php?site=history.php"><i class="fa-solid fa-right-from-bracket fa-lg"></i></a>
                </div>
                <?php } ?>
            </div>
        </div>
    </nav>
    <div id="matches" class="container mx-auto text-center p-0 m-5">
        <h4 class="pb-3">Match History</h4>
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
<script>
window.addEventListener('DOMContentLoaded', (event) => {
    loadMatchData();
});

function hasPlayer5(match) {
    if(Object.keys(match).length > 11) {
        return `<div class="playerbox col-3 d-flex justify-content-center">
                    <div class="player">${match.player_5.name}</div>
                    <div class="points">${match.player_5.points}</div>
                </div>`;
    } else {
        return '';
    }
}

function isWinner(player, winner) {
    if(player == winner) {
        return 'winner';
    } else {
        return '';
    }
}

function wasAchieved(achieved) {
    if(achieved == "1") {
        return 'achieved';
    } else {
        return '';
    }
}

function wasAchievedFrom(achieved, achievedFrom) {
    console.log(achieved);
    if(achieved == "1") {
        return `<span class="name fade">${achievedFrom}</span>`;
    } else {
        return '';
    }
}

async function loadMatchData() {
    const response = await fetch('backend/matches/matches.php', {
        method: 'GET',
    });
    const result = await response.json();
    for(let i = 0; i < Object.keys(result).length; i++) {
        document.getElementById('matches').innerHTML += `
            <div class="match pt-3 mt-5 mx-auto"><h5>${result[i].date}</h5>
                <div class="row justify-content-center">
                    <div class="playerbox ${isWinner(result[i].player_1.name, result[i].winner)} col-3 d-flex justify-content-center">
                        <div class="player">${result[i].player_1.name}</div>
                        <div class="points">${result[i].player_1.points}</div>
                    </div>
                    <div class="playerbox ${isWinner(result[i].player_2.name, result[i].winner)} col-3 d-flex justify-content-center">
                        <div class="player">${result[i].player_2.name}</div>
                        <div class="points">${result[i].player_2.points}</div>
                    </div>
                    <div class="playerbox ${isWinner(result[i].player_3.name, result[i].winner)} col-3 d-flex justify-content-center">
                        <div class="player">${result[i].player_3.name}</div>
                        <div class="points">${result[i].player_3.points}</div>
                    </div>
                    <div class="playerbox ${isWinner(result[i].player_4.name, result[i].winner)} col-3 d-flex justify-content-center">
                        <div class="player">${result[i].player_4.name}</div>
                        <div class="points">${result[i].player_4.points}</div>
                    </div>
                    ${hasPlayer5(result[i])}
                </div>
                <div class="pt-4 pb-3 row d-flex justify-content-center align-items-center">
                    <div class="col-3 mcard ${wasAchieved(result[i].challange_1.achieved)} mx-auto">
                        <span class="title fade">${result[i].challange_1.name}</span>
                        <span class="description fade">${result[i].challange_1.content}</span>
                        <span class="points fade">${result[i].challange_1.points}</span>
                        ${wasAchievedFrom(result[i].challange_1.achieved, result[i].challange_1.achieved_from)}
                    </div>
                    <div class="col-3 mcard ${wasAchieved(result[i].challange_2.achieved)} mx-auto">
                        <span class="title fade">${result[i].challange_2.name}</span>
                        <span class="description fade">${result[i].challange_2.content}</span>
                        <span class="points fade">${result[i].challange_2.points}</span>
                        ${wasAchievedFrom(result[i].challange_2.achieved, result[i].challange_2.achieved_from)}
                    </div>
                    <div class="col-3 mcard ${wasAchieved(result[i].challange_3.achieved)} mx-auto">
                        <span class="title fade">${result[i].challange_3.name}</span>
                        <span class="description fade">${result[i].challange_3.content}</span>
                        <span class="points fade">${result[i].challange_3.points}</span>
                        ${wasAchievedFrom(result[i].challange_3.achieved, result[i].challange_3.achieved_from)}
                    </div>
                    <div class="col-3 mcard ${wasAchieved(result[i].challange_4.achieved)} mx-auto">
                        <span class="title fade">${result[i].challange_4.name}</span>
                        <span class="description fade">${result[i].challange_4.content}</span>
                        <span class="points fade">${result[i].challange_4.points}</span>
                        ${wasAchievedFrom(result[i].challange_4.achieved, result[i].challange_4.achieved_from)}
                    </div>
                </div>
            </div>     
        `;
    }
}    
</script>
</html>