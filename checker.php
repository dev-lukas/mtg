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
    <nav class="navbar navbar-dark navbar-expand-sm static-top">
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
                            <li><a class="dropdown-item active" href="checker.php">Preis Checker</a></li>
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
                    <a href="backend/auth/logout.php?site=checker.php"><i class="fa-solid fa-right-from-bracket fa-lg"></i></a>
                </div>
                <?php } ?>
            </div>
        </div>
    </nav>
    <div class="container mx-auto text-center p-0 m-5">
        <h4>Cardmarket Preis Checker</h4>
        <div class="container-search p-1 m-5 mx-auto">
            <div class="searchInput" id="searchInput">
                <input id="cardname" type="text" placeholder="Kartenname">
                <div class="resultBox position-absolute border rounded shadow" id="resultBox"></div>
                <div id="search" class="icon">
                    <i class="fas fa-search"></i>
                </div>
            </div>
        </div>
        <div id="error" role="alert" class="alert alert-warning hidden"><strong>Tut uns Leid!</strong> Die Cardmarket API ist leider sehr inkosistent. Diese Karte musst du wohl manuell nachschauen!</div>
        <div class="container-search row m-5 mx-auto">
            <div class="col-md-6 pt-2">
                <h5>Preis</h5>
                <div id="price" class="d-flex align-items-center justify-content-center price-box mx-auto"></div>
            </div>
            <div class="col-md-6 pt-2">
                <h5>Punkte</h5>
                <div id="points" class="d-flex align-items-center justify-content-center price-box mx-auto"></div>
            </div>
        </div>
        <div class="container mx-auto">
            <span class="note">Achtung: Die Kartenpreise gelten für Deutsch/Englische Karten von Händlern aus Deutschland in Condition "Good"</span>
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
//Timeout variable to satisfy api regulations
let scyrfall_timeout = false;
let cardmarket_timeout = false;

window.addEventListener('DOMContentLoaded', (event) => {
    document.getElementById('cardname').onkeyup = (e)=> {
        let cardname = e.target.value;
        if(cardname && cardname.length > 1) {
            fetchScryfallSuggestions();
        } else {
            document.getElementById('searchInput').classList.remove("active");
        }
    }
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
            allList[i].setAttribute('onclick', 'requestCardmarketData("' + allList[i].innerText + '")');
        }
    }
} 

function requestCardmarketData(name) {
    if(!cardmarket_timeout) {
        cardmarket_timeout = true;
        setTimeout(function(){
            cardmarket_timeout = false;
        }, 5000);
        document.getElementById('cardname').value = name;
        document.getElementById('resultBox').innerHTML = '';
        document.getElementById('searchInput').classList.remove("active");
        document.getElementById('price').innerHTML = '<div class="spinner-border"></div>';
        document.getElementById('points').innerHTML = '<div class="spinner-border"></div>';
        let cardname = encodeCardmarketCard(name, 0);
        let cardname_variation = encodeCardmarketCard(name, 1);
        const postData = new FormData();
        postData.append('cardname', cardname);
        postData.append('cardnameVariation', cardname_variation);
        sendData(postData);
    }
}

//Since cardmarket uses wierd formatting for it's links we need to reformat typical cardnames
function encodeCardmarketCard(cardname, mode) {
    let result;
    switch(mode) {
        // Some - signs are kept, others not, this case they are kept
        case 1:
            result = cardname.replace(/'/g, '');
            result = result.replace(/,/g, '');
            result = result.replace(/!/g, '');
            result = result.replace(/\s\/\/\s/g, '-');
            result = result.replace(/\s/g, '-');
            return result;
            break;
        // Default Case - remove everything
        default:
            result = cardname.replace(/'/g, '');
            result = result.replace(/-/g, '');
            result = result.replace(/,/g, '');
            result = result.replace(/!/g, '');
            result = result.replace(/\s\/\/\s/g, '-');
            result = result.replace(/\s/g, '-');
            return result;
    }
}

async function sendData(postData) {
    var dataHeader = new Headers();
    dataHeader.append('pragma', 'no-cache');
    dataHeader.append('cache-control', 'no-cache');
    const response = await fetch('backend/price_scraper.php', {
        method: 'POST',
        header: dataHeader,
        body: postData
    });
    const price = await response.text();
    if(price == '-1' || price == '0') {
        document.getElementById('price').innerHTML = '';
        document.getElementById('points').innerHTML = '';
        document.getElementById('error').classList.toggle('hidden');
        setTimeout(function() {
            document.getElementById('error').classList.toggle('hidden');
        }, 15000);
        document.getElementById('cardname').value = '';
    } else {
        const points = Math.ceil(parseFloat((price.replace(/s€/,'')).replace(',','.')));
        document.getElementById('price').innerHTML = price;
        document.getElementById('points').innerHTML = points;
    }
}
</script>
</html>