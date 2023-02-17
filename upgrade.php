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
                            <li><a class="dropdown-item active" href="upgrade.php">Upgrade History</a></li>
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
                    <a href="backend/auth/logout.php?site=upgrade.php"><i class="fa-solid fa-right-from-bracket fa-lg"></i></a>
                </div>
                <?php } ?>
            </div>
        </div>
    </nav>
    <div class="container-fluid mx-auto text-center p-0 mt-5">
        <h4>Punkte</h4>
        <div class="row" id="cardArea"></div>
    </div>
    <div class="modal" tabindex="-1" id="formAddCard">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upgrade hinzufügen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addCard" method="POST" action="backend/cards/cardshandler.php?mode=add">
                    <div class="modal-body text-center">
                        <div class="searchInput" id="searchInput">
                            <input id="cardname" type="text" placeholder="Kartenname" name="cardname">
                            <div class="resultBox position-absolute border rounded shadow" id="resultBox"></div>
                        </div>
                        <input class="cardpoints mt-3" type="number" placeholder="Punkte" name="points">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary">Hinzufügen</button>
                    </div>
                </form>
            </div>
         </div>
    </div>
    <div class="modal" tabindex="-1" id="formDeleteCard">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upgrade entfernen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteCard" method="POST" action="backend/cards/cardshandler.php?mode=delete">
                    <div class="modal-body text-center">
                        <input type="number" name="id" class="hidden" id="deletePoint">
                        Bist du dir sicher, dass du dieses Upgrade entfernen willst?
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary">Entfernen</button>
                    </div>
                </form>
            </div>
         </div>
    </div>
    <div class="modal" tabindex="-1" id="message">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php if(isset($_SESSION['title'])) { echo $_SESSION['title']; } ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p><?php if(isset($_SESSION['content'])) { echo $_SESSION['content']; } ?></p>
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
          <p class="text-center">MTG Companion is unofficial Fan Content permitted under the Fan Content Policy. Not approved/endorsed by Wizards. Portions of the materials used are property of Wizards of the Coast. ©Wizards of the Coast LLC.</p>
        </footer>
    </div>
</body>
<script>
let scyrfall_timeout = false;

window.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById('cardname').onkeyup = (e)=> {
        let cardname = e.target.value;
        if(cardname && cardname.length > 1) {
            fetchScryfallSuggestions();
        } else {
            document.getElementById('searchInput').classList.remove("active");
        }
    }
    var message = new bootstrap.Modal(document.getElementById('message'));
    <?php if(isset($_GET['mode']) && $_GET['mode'] == 'message') { ?>
    message.show();
    <?php } ?>
    fetchData();
});

async function fetchScryfallSuggestions() {
    if(!scyrfall_timeout) {
        scyrfall_timeout = true;
        setTimeout(function(){
            scyrfall_timeout = false;
        }, 100);
        const response = await fetch('https://api.scryfall.com/cards/autocomplete?q=' + encodeURI(document.getElementById('cardname').value), {
            method: 'GET',
        });
        const result = await response.json();
        let resultBox =  document.getElementById('resultBox');
        resultBox.innerHTML = '';
        document.getElementById('searchInput').classList.add("active");
        for (let i = 0; i < Object.keys(result.data).length; i++) {
           resultBox.innerHTML += '<li>' + result.data[i] + '</li>'
        }
        let allList = document.getElementById('resultBox').querySelectorAll("li");
        for (let i = 0; i < allList.length; i++) {
            //adding onclick attribute in all li tag
            allList[i].setAttribute('onclick', 'setCard(this)');
        }
    }
}

async function fetchData() {
    let id = <?php if(isset($_SESSION['id'])) { echo $_SESSION['id']; } else { echo 0; } ?>;
    let response = await fetch('backend/player/player.php');
    let data = await response.json();
    let player_data = data;
    response = await fetch('backend/cards/cards.php');
    data = await response.json();
    let card_data = data;
    const cardArea = document.getElementById('cardArea');
    for (let i = 0; i < Object.keys(player_data).length; i++) {
        let used_points = 0;
        for(let j = 0; j < Object.keys(card_data).length; j++) {
            if(card_data[j].owner == player_data[i].id) {
                used_points += parseInt(card_data[j].points, 10);
            }
        }
        cardArea.innerHTML += `
            <div class="col pb-2 mx-auto" align="center">
                <div class="player-points row">
                    <h5 class="name col-12 pt-1">${player_data[i].name}</h5>
                    <div class="col-4">
                        <div class="points pb-1">${player_data[i].points}</div>
                    </div>
                    <div class="col-4">
                        <i class="fa-solid fa-coins"></i>
                    </div>
                    <div class="col-4">
                        <div class="points pb-1">${player_data[i].points - used_points}</div>
                    </div>
                </div>
            </div>`;
    }
    for (let i = 0; i < Object.keys(player_data).length; i++) {
        cardArea.innerHTML += `
            <div class="col-12 row mx-auto mt-3 player-card-area" id="player-${player_data[i].name}">
                <h4 class="mt-2">${player_data[i].name}</h4>
            </div>`;
        var playerarea = document.getElementById(`player-${player_data[i].name}`);
        for(let j = 0; j < Object.keys(card_data).length; j++) {
            if(card_data[j].owner == player_data[i].id) {
                if(card_data[j].owner == id) {
                    playerarea.innerHTML += `
                    <div class="col">
                        <img class="scryfallcard" src="${card_data[j].artlink}" data-toggle="tooltip" data-placement="top" title="${card_data[j].points} Punkt(e)"><br>
                        <a class="cardremover" onclick="showForm(2, ${card_data[j].id})"><i class="fa-solid fa-circle-minus"></i></a>
                    </div>`;
                } else {
                    playerarea.innerHTML += `
                    <div class="col">
                        <img class="scryfallcard" src="${card_data[j].artlink}" data-toggle="tooltip" data-placement="top" title="${card_data[j].points} Punkt(e)">
                    </div>`;
                }
            }
        }
        if(id == player_data[i].id) {
            playerarea.innerHTML += `
                <div class="col my-auto addCard">
                    <a class="cardbutton" onclick="showForm(1)"><i class="fa-solid fa-circle-plus fa-xl"></i></a>
                </div>`;
        }
        if(!playerarea.querySelector('div.col')) {
            playerarea.innerHTML += `
            <div class="col my-auto addCard mt-5">
                <p>Hier ist es noch etwas leer</p>    
            </div>`;
        }
    }
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
}

function setCard(e) {
    var field = document.getElementById('cardname');
    field.value = e.innerHTML; 
    let resultBox =  document.getElementById('resultBox');
    resultBox.innerHTML = '';
    document.getElementById('searchInput').classList.remove("active");
}

function showForm(i, cardid = 0) {
    if(i == 1) {
        var form = new bootstrap.Modal(document.getElementById('formAddCard'));
        form.show();
    } else {
        document.getElementById('deletePoint').value = cardid;
        var form = new bootstrap.Modal(document.getElementById('formDeleteCard'));
        form.show();
    }
    
}
</script>
</html>