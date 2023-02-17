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
              <li><a class="dropdown-item active" href="randomizer.php">Challange Randomizer</a></li>
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
            <a href="backend/auth/logout.php?site=randomizer.php"><i class="fa-solid fa-right-from-bracket fa-lg"></i></a>
        </div>
        <?php } ?>
      </div>
    </div>
  </nav>
  <div class="d-flex align-items-center justify-content-center">
    <div class="container-fluid text-center">
      <br>
      <h4>Challanges</h4>
      <div class="row mx-auto p-4">
        <div class="col pt-3">
          <div class="mcard mx-auto">
            <span class="title fade">Life Saver</span>
            <span class="description fade">Rette einen Mitspieler</span>
            <span class="points fade">1</span>
          </div>
        </div>
        <div class="col pt-3">
          <div class="mcard m-auto" id="challange-1"><i class="fa-solid fa-question"></i></div>
        </div>
        <div class="col pt-3">
          <div class="mcard m-auto" id="challange-2"><i class="fa-solid fa-question"></i></div>
        </div>
        <div class="col pt-3">
          <div class="mcard m-auto" id="challange-3"><i class="fa-solid fa-question"></i></div>
        </div>
      </div>
      <div class="pt-5"></div>
      <button type="button" class="button-generate" id="cbutton" onclick="generateChallanges()">Let's Duel</button>
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
var challange_data;
window.addEventListener('DOMContentLoaded', (event) => {
  loadChallangeData();
});

async function loadChallangeData() {
  const response = await fetch('backend/challanges/challanges.php');
  const data = await response.json();
  challange_data = data;
}

function setChallange(id, cid) {
  challange_card = document.getElementById('challange-' + id);
  challange_card.innerHTML = '<div class="mcard m-auto"><span class="title dynamic">' + challange_data[cid].name +'</span><span class="description dynamic">' + challange_data[cid].content + '</span><span class="points fade">' + challange_data[cid].points + '</span></div>';
  content = challange_card.querySelectorAll('span');
  content.forEach(function (element) {
    setTimeout(function() {
    element.classList.toggle('fade');
  }, 20);
  });
  challange_card.classList.remove('load');
}

function generateChallanges() {
  let numbers = [];
  let timeout = 700;
  numbers = Array.from({length: 3}, () => Math.floor(Math.random() * Object.keys(challange_data).length));
  while(numbers[0] == numbers[1] || numbers[1] == numbers[2] || numbers[0] == numbers[2]) {
    numbers = Array.from({length: 3}, () => Math.floor(Math.random() * Object.keys(challange_data).length));
  }
  for (let i = 0; i < 3; i++) {
    let card = document.getElementById('challange-' + (i + 1));
    card.classList.add('load');
    card.innerHTML = '<i class="fa-solid fa-question"></i>';
    setTimeout(setChallange, timeout, i + 1, numbers[i]);
    timeout += 700;
  }
}
</script>
</html>